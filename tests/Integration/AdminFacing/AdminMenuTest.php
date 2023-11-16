<?php
namespace SapphireSiteManager\Tests\Integration\AdminFacing;

use SapphireSiteManager\AdminFacing\AdminMenu;
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

beforeEach(
	function () {
		parent::setUp();

		$this->sapphire_menu = new AdminMenu();
		global $menu;
		$this->test_user = wp_set_current_user( self::factory()->user->create( [
			'role' => 'administrator',
		] ) );


	}

);

afterEach(
	function () {
		global $menu;
		$menu                = null;
		$this->sapphire_menu = null;

		parent::tearDown();
	}
);

test(
	'Sapphire Site Manager Admin menu exists',
	function () {
		global $menu;
		expect( $menu[0] )
			->toBeArray()
			->and( 'sapphire-site-manager' )->toBeIn( $menu[0] );
	}
);

it(
	'should have page title Sapphire Site Manager',
	function () {
		global $menu;
		expect( $menu[0] )
			->and( 'Sapphire Site Manager' )->toBeIn( $menu[0] );
	}
);

it(
	'should have top level page - toplevel_page_sapphire-site-manager',
	function () {
		global $menu;
		expect( $menu[0] )
			->and( 'toplevel_page_sapphire-site-manager' )->toBeIn( $menu[0] );
	}
);

it(
	'should have capability of manage_options',
	function () {
		global $menu;
		expect( $menu[0] )
			->and( 'manage_options' )->toBeIn( $menu[0] );
	}
);

it(
	'should have the dasicon dashicons-smiley',
	function () {
		global $menu;
		expect( $menu[0] )
			->and( 'dashicons-smiley' )->toBeIn( $menu[0] );
	}
);
