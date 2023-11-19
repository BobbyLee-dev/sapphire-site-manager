<?php
namespace SapphireSiteManager\Tests\Integration\AdminFacing;

use SapphireSiteManager\AdminFacing\EnqueueAdminStyles;
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

beforeEach(
	function () {
		parent::setUp();

		$this->sapphire_admin_styles = new EnqueueAdminStyles();
		//echo get_plugin_page_hook( 'sapphire-site-manager', 'sapphire-site-manager' );
		//set_current_screen( 'toplevel_page_sapphire-site-manager' );
		set_current_screen( 'dashboard' );
		do_action( 'admin_enqueue_scripts', $this->sapphire_admin_styles->enqueue_admin_styles() );
		global $wp_styles;
		$this->styles  = $wp_styles;
		$this->version = $this->plugin_version();
	}

);

afterEach(
	function () {
		$this->sapphire_admin_styles = null;
		$this->styles                = null;
		$this->version               = null;

		parent::tearDown();
	}
);

test(
	'SSM Admin Styles are not enqueued if not on the frontend (homepage test).',
	function () {
		$this->go_to( '/' );
		expect( is_home() )->toBeTrue()
		                   ->and( wp_style_is( 'sapphire-site-manager-style', 'registered' ) )->toBeFalse();
	}

);

it( 'should not have SSM styles enqueued on admin dashboard.',
	function () {
		expect( is_admin() )->toBeTrue()
		                    ->and( wp_style_is( 'sapphire-site-manager-style', 'registered' ) )->toBeFalse()
		                    ->and( is_home() )->toBeFalse();
	} );


it( 'should have SSM styles enqueued SSM page.',
	function () {
		set_current_screen( 'toplevel_page_sapphire-site-manager' );
		do_action( 'admin_enqueue_scripts', $this->sapphire_admin_styles->enqueue_admin_styles() );
		expect( is_admin() )->toBeTrue()
		                    ->and( wp_style_is( 'sapphire-site-manager-style', 'registered' ) )->toBeTrue()
		                    ->and( is_home() )->toBeFalse();
	} );

it( 'should have the handle of "sapphire-site-manager-style".',
	function () {
		set_current_screen( 'toplevel_page_sapphire-site-manager' );
		do_action( 'admin_enqueue_scripts', $this->sapphire_admin_styles->enqueue_admin_styles() );
		expect( $this->styles->registered['sapphire-site-manager-style'] )->toHaveProperty( 'handle', 'sapphire-site-manager-style' );
	} );

it( 'should have the src which contains "sapphire-site-manager/build/adminFacing/Main.css".',
	function () {
		set_current_screen( 'toplevel_page_sapphire-site-manager' );
		do_action( 'admin_enqueue_scripts', $this->sapphire_admin_styles->enqueue_admin_styles() );
		expect( $this->styles->registered['sapphire-site-manager-style'] )->toHaveProperty( 'src' );
		assertTrue( str_contains(
			$this->styles->registered['sapphire-site-manager-style']->src,
			'sapphire-site-manager/build/adminFacing/Main.css' ) );
	} );

it( 'should have the version that matches the plugin version.',
	function () {
		set_current_screen( 'toplevel_page_sapphire-site-manager' );
		do_action( 'admin_enqueue_scripts', $this->sapphire_admin_styles->enqueue_admin_styles() );
		expect( $this->styles->registered['sapphire-site-manager-style']->ver )->toEqual( $this->version );
	} );
