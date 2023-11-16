<?php
namespace SapphireSiteManager\Tests\Integration\AdminFacing;

use SapphireSiteManager\AdminFacing\AdminFacing;
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

		$this->sapphire_styles = new AdminFacing();
		global $wp_styles;
		print_r( $wp_styles->registered );
		//$GLOBALS['wp_scripts']->registered

	}

);

afterEach(
	function () {
		global $wp_styles;
		$wp_styles             = null;
		$this->sapphire_styles = null;

		parent::tearDown();
	}
);

test(
	'Sapphire Site Manager Styles are enqueued',
	function () {
		global $wp_styles;
		echo 'lol';
		//print_r( wp_style_is( 'sapphire-site-manager-style', 'enqueued' ) );
		//expect( $menu[0] )
		//	->toBeArray()
		//	->and( 'sapphire-site-manager' )->toBeIn( $menu[0] );
	}
);
