<?php
namespace SapphireSiteManager\Tests\Integration\AdminFacing;

use SapphireSiteManager\AdminFacing\Styles\EnqueueAdminStyles;
use SapphireSiteManager\Traits\PluginNameTrait;
use SapphireSiteManager\Traits\PluginSlugTrait;
use SapphireSiteManager\Traits\PluginVersionTrait;
use Yoast\WPTestUtils\WPIntegration\TestCase;
use function PHPUnit\Framework\assertTrue;

if ( isUnitTest() ) {
	return;
}

/*
 * We need to provide the base test class to every integration test.
 * This will enable us to use all the WordPress test goodies, such as
 * factories and proper test cleanup.
 *
 */
uses( TestCase::class );
uses( PluginVersionTrait::class );
uses( PluginSlugTrait::class );
uses( PluginNameTrait::class );

beforeEach(
	function () {
		parent::setUp();

		$this->admin_styles = new EnqueueAdminStyles();
		//set_current_screen( 'toplevel_page_' . $this->plugin_slug() );
		set_current_screen( 'dashboard' );

		// Create a user and log them in
		$this->user_id = $this::factory()->user->create();
		wp_set_current_user( $this->user_id );

		// Trigger the wp hook to set up user capabilities
		do_action( 'wp' );

		// Create a test page
		$this->test_page_id = $this::factory()->post->create( array(
			'post_title'   => 'Test Page',
			'post_content' => 'Welcome to the Test Page content.',
			'post_type'    => 'page',
		) );

		global $wp_styles;
		$this->styles  = $wp_styles;
		$this->version = $this->plugin_version();
	}

);

afterEach(
	function () {
		$this->admin_styles = null;
		$this->styles       = null;
		$this->version      = null;
		wp_set_current_user( 0 );
		wp_delete_post( $this->test_page_id, true );

		parent::tearDown();
	}
);

test(
	'Admin Styles are not enqueued if not logged in.',
	function () {
		wp_set_current_user( 0 );
		do_action( 'wp_enqueue_scripts', $this->admin_styles->enqueue_admin_styles() );
		$this->go_to( get_permalink( $this->test_page_id ) );
		expect( wp_style_is( $this->plugin_slug() . '-style', 'enqueued' ) )->toBeFalse();
	}

);

test(
	'Admin Styles are enqueued if on admin screen.',
	function () {
		set_current_screen( 'admin' );
		do_action( 'admin_enqueue_scripts' );
		expect( wp_style_is( $this->plugin_slug() . '-style', 'enqueued' ) )->toBeTrue();
	}

);

test(
	'Admin Styles are enqueued if on homepage while logged in.',
	function () {
		$this->go_to( get_permalink( $this->test_page_id ) );
		echo get_the_title();
		// Set up post data for the homepage
		expect( wp_style_is( $this->plugin_slug() . '-style', 'enqueued' ) )->toBeTrue();
	}

);

it( 'should have the styles enqueued on the plugin admin page.',
	function () {
		set_current_screen( 'toplevel_page_' . $this->plugin_slug() );
		do_action( 'admin_enqueue_scripts', $this->admin_styles->enqueue_admin_styles() );
		expect( is_admin() )->toBeTrue()
		                    ->and( wp_style_is( $this->plugin_slug() . '-style', 'registered' ) )->toBeTrue()
		                    ->and( is_home() )->toBeFalse();
	} );

it( 'should have the plugin style handle/name',
	function () {
		set_current_screen( 'toplevel_page_' . $this->plugin_slug() );
		do_action( 'admin_enqueue_scripts', $this->admin_styles->enqueue_admin_styles() );
		expect( $this->styles->registered[ $this->plugin_slug() . '-style' ] )->toHaveProperty( 'handle', $this->plugin_slug() . '-style' );
	} );

it( 'should have the src which contains "/build/adminFacing/Main.css".',
	function () {
		set_current_screen( 'toplevel_page_' . $this->plugin_slug() );
		do_action( 'admin_enqueue_scripts', $this->admin_styles->enqueue_admin_styles() );
		expect( $this->styles->registered[ $this->plugin_slug() . '-style' ] )->toHaveProperty( 'src' );
		assertTrue( str_contains(
			$this->styles->registered[ $this->plugin_slug() . '-style' ]->src,
			$this->plugin_slug() . '/build/adminFacing/Main.css' ) );
	} );

it( 'should have the version that matches the plugin version.',
	function () {
		set_current_screen( 'toplevel_page_' . $this->plugin_slug() );
		do_action( 'admin_enqueue_scripts', $this->admin_styles->enqueue_admin_styles() );
		expect( $this->styles->registered[ $this->plugin_slug() . '-style' ]->ver )->toEqual( $this->version );
	} );
