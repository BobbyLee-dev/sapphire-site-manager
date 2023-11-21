<?php
namespace SapphireSiteManager\Tests\Integration\AdminFacing;

use SapphireSiteManager\AdminFacing\AdminMenu;
use SapphireSiteManager\Traits\PluginSlugTrait;
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
uses( PluginSlugTrait::class );

beforeEach(
	function () {
		parent::setUp();

		global $menu;
		$this->admin_menu = new AdminMenu();
		//set_current_screen( 'dashboard' );
		do_action( 'admin_menu', $this->admin_menu->create_admin_pages() );
		set_current_screen( 'toplevel_page_' . $this->plugin_slug() );
		$this->menu = $menu;

		//$data = get_plugin_data( dirname( __DIR__, 3 ) . '/sapphire-site-manager.php' );
		//print_r( $data );

	}

);

afterEach(
	function () {
		global $menu;
		$menu             = null;
		$this->admin_menu = null;
		$this->menu       = null;

		parent::tearDown();
	}
);

test(
	'Sapphire Site Manager Admin menu exists',
	function () {
		expect( $this->menu[0] )
			->toBeArray()
			->and( $this->plugin_slug() )->toBeIn( $this->menu[0] );
	}


);

it(
	'should have page title Sapphire Site Manager',
	function () {
		expect( $this->menu[0] )
			->and( 'Sapphire Site Manager' )->toBeIn( $this->menu[0] );
	}
);

it(
	'should have top level page - toplevel_page_sapphire-site-manager',
	function () {
		expect( $this->menu[0] )
			->and( 'toplevel_page_sapphire-site-manager' )->toBeIn( $this->menu[0] );
	}
);

it(
	'should have capability of manage_options',
	function () {
		expect( $this->menu[0] )
			->and( 'manage_options' )->toBeIn( $this->menu[0] );
	}
);

it(
	'should have the dasicon dashicons-smiley',
	function () {
		expect( $this->menu[0] )
			->and( 'dashicons-smiley' )->toBeIn( $this->menu[0] );
	}
);
