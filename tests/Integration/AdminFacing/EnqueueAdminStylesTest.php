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
 */
uses( TestCase::class );
uses( PluginVersionTrait::class );
uses( PluginSlugTrait::class );
uses( PluginNameTrait::class );

beforeEach(
	function () {
		parent::setUp();

		$this->admin_styles = new EnqueueAdminStyles();
		//echo get_plugin_page_hook( $this->plugin_slug(), $this->plugin_slug() );
		//set_current_screen( 'toplevel_page_' . $this->plugin_slug() );
		set_current_screen( 'dashboard' );
		do_action( 'admin_enqueue_scripts', $this->admin_styles->enqueue_admin_styles() );
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

		parent::tearDown();
	}
);

test(
	'Admin Styles are not enqueued if not on the frontend (homepage test).',
	function () {
		$this->go_to( '/' );
		expect( is_home() )->toBeTrue()
		                   ->and( wp_style_is( $this->plugin_slug() . '-style', 'registered' ) )->toBeFalse();
	}

);

it( 'should not have the styles enqueued on admin dashboard.',
	function () {
		expect( is_admin() )->toBeTrue()
		                    ->and( wp_style_is( $this->plugin_slug() . '-style', 'registered' ) )->toBeFalse()
		                    ->and( is_home() )->toBeFalse();
	} );


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
