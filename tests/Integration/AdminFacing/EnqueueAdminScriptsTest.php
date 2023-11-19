<?php
//namespace SapphireSiteManager\Tests\Integration\AdminFacing;
//
//use SapphireSiteManager\AdminFacing\EnqueueAdminScripts;
//use Yoast\WPTestUtils\WPIntegration\TestCase;
//
//if ( isUnitTest() ) {
//	return;
//}
//
///*
// * We need to provide the base test class to every integration test.
// * This will enable us to use all the WordPress test goodies, such as
// * factories and proper test cleanup.
// */
//uses( TestCase::class );
//
//beforeEach(
//	function () {
//		parent::setUp();
//
//		$this->sapphire_admin_scripts = new EnqueueAdminScripts();
//		set_current_screen( 'dashboard' );
//		do_action( 'admin_enqueue_scripts', $this->sapphire_admin_styles->enqueue_admin_styles() );
//	}
//
//);
//
//afterEach(
//	function () {
//		$this->sapphire_admin_scripts = null;
//
//		parent::tearDown();
//	}
//);
//
//test(
//	'SSM Admin Styles are not enqueued if not on the frontend (homepage test).',
//	function () {
//		$this->go_to( '/' );
//		expect( is_home() )->toBeTrue()
//		                   ->and( wp_style_is( 'sapphire-site-manager-style', 'registered' ) )->toBeFalse();
//	}
//
//);
//
//it( 'should not have SSM styles enqueued on admin dashboard.',
//	function () {
//		expect( is_admin() )->toBeTrue()
//		                    ->and( wp_style_is( 'sapphire-site-manager-style', 'registered' ) )->toBeFalse()
//		                    ->and( is_home() )->toBeFalse();
//	} );
//
//
//it( 'should have SSM styles enqueued SSM page.',
//	function () {
//		set_current_screen( 'toplevel_page_sapphire-site-manager' );
//		do_action( 'admin_enqueue_scripts', $this->sapphire_admin_styles->enqueue_admin_styles() );
//		expect( is_admin() )->toBeTrue()
//		                    ->and( wp_style_is( 'sapphire-site-manager-style', 'registered' ) )->toBeTrue()
//		                    ->and( is_home() )->toBeFalse();
//	} );
//
