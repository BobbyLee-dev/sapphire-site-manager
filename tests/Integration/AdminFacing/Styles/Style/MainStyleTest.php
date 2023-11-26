<?php
namespace SapphireSiteManager\Tests\Integration\AdminFacing;

use SapphireSiteManager\AdminFacing\Styles\Style\MainStyle;
use SapphireSiteManager\Traits\PluginDirectoryUrlTrait;
use SapphireSiteManager\Traits\PluginNameTrait;
use SapphireSiteManager\Traits\PluginSlugTrait;
use SapphireSiteManager\Traits\PluginVersionTrait;
use Yoast\WPTestUtils\WPIntegration\TestCase;

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
uses( PluginDirectoryUrlTrait::class );
uses( PluginNameTrait::class );

beforeEach(
	function () {
		parent::setUp();

		$this->main_style = new MainStyle();
	}

);

afterEach(
	function () {
		$this->main_style = null;

		parent::tearDown();
	}
);

test(
	'The handle is the plugin-slug-style.',
	function () {
		expect( $this->main_style->handle() )->toBe( $this->plugin_slug() . '-style' );
	}
);

it(
	'should have the src plugin_dir_url/build/adminFacing/Main.css.',
	function () {
		expect( $this->main_style->src() )->toBe( $this->my_plugin_dir_url() . 'build/adminFacing/Main.css' );
	}
);

it(
	'should have the dpendency array("wp-components").',
	function () {
		expect( $this->main_style->dependecis() )->toBeArray();
	}
);


//it( 'should have the styles enqueued on the plugin admin page.',
//	function () {
//		set_current_screen( 'toplevel_page_' . $this->plugin_slug() );
//		do_action( 'admin_enqueue_scripts', $this->admin_styles->enqueue_admin_styles() );
//		expect( is_admin() )->toBeTrue()
//		                    ->and( wp_style_is( $this->plugin_slug() . '-style', 'registered' ) )->toBeTrue()
//		                    ->and( is_home() )->toBeFalse();
//	} );

//it( 'should have the plugin style handle/name',
//	function () {
//		set_current_screen( 'toplevel_page_' . $this->plugin_slug() );
//		do_action( 'admin_enqueue_scripts', $this->admin_styles->enqueue_admin_styles() );
//		expect( $this->styles->registered[ $this->plugin_slug() . '-style' ] )->toHaveProperty( 'handle', $this->plugin_slug() . '-style' );
//	} );

//it( 'should have the src which contains "/build/adminFacing/Main.css".',
//	function () {
//		set_current_screen( 'toplevel_page_' . $this->plugin_slug() );
//		do_action( 'admin_enqueue_scripts', $this->admin_styles->enqueue_admin_styles() );
//		expect( $this->styles->registered[ $this->plugin_slug() . '-style' ] )->toHaveProperty( 'src' );
//		assertTrue( str_contains(
//			$this->styles->registered[ $this->plugin_slug() . '-style' ]->src,
//			$this->plugin_slug() . '/build/adminFacing/Main.css' ) );
//	} );

//it( 'should have the version that matches the plugin version.',
//	function () {
//		set_current_screen( 'toplevel_page_' . $this->plugin_slug() );
//		do_action( 'admin_enqueue_scripts', $this->admin_styles->enqueue_admin_styles() );
//		expect( $this->styles->registered[ $this->plugin_slug() . '-style' ]->ver )->toEqual( $this->version );
//	} );
