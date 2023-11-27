<?php
//namespace SapphireSiteManager\Tests\Integration\AdminFacing\Styles;
//
//use SapphireSiteManager\AdminFacing\Styles\EnqueueAdminStyles;
//use SapphireSiteManager\Traits\PluginNameTrait;
//use SapphireSiteManager\Traits\PluginSlugTrait;
//use SapphireSiteManager\Traits\PluginVersionTrait;
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
// *
// */
//uses( TestCase::class );
//uses( PluginVersionTrait::class );
//uses( PluginSlugTrait::class );
//uses( PluginNameTrait::class );
//
//beforeEach(
//	function () {
//		parent::setUp();
//
//		//// Create a user and log them in
//		//$this->user_id = $this::factory()->user->create();
//		//wp_set_current_user( $this->user_id );
//
//		set_current_screen( 'dashboard' );
//		$this->admin_styles = new EnqueueAdminStyles();
//		$this->admin_styles->run();
//
//
//		//// Create a test page
//		//$this->test_page_id = $this::factory()->post->create( array(
//		//	'post_title'   => 'Test Page',
//		//	'post_content' => 'Welcome to the Test Page content.',
//		//	'post_type'    => 'page',
//		//) );
//		//
//		//global $wp_styles;
//		//$this->styles  = $wp_styles;
//		//$this->version = $this->plugin_version();
//	}
//);
//
//afterEach(
//	function () {
//		$this->admin_styles = null;
//		$this->styles       = null;
//		//$this->version      = null;
//		//wp_set_current_user( 0 );
//		//wp_delete_post( $this->test_page_id, true );
//
//		parent::tearDown();
//	}
//);
//
//test(
//	'Action admin_enqueue_scripts is added from the run() method.',
//	function () {
//		// Create an instance of YourClass
//
//		// Mock the global WordPress actions
//		$GLOBALS['wp_actions'] = [];
//
//		// Trigger the action
//		do_action( 'admin_enqueue_scripts' );
//
//		// Check if the action has been added
//		$this->assertArrayHasKey( 'admin_enqueue_scripts', $GLOBALS['wp_actions'] );
//
//		// Get the callbacks attached to the action
//		$callbacks = $GLOBALS['wp_filter']['admin_enqueue_scripts'];
//
//
//		// Check if there's a callback that matches your class method
//		$callbackFound = false;
//
//		foreach ( $callbacks as $priority => $actions ) {
//			foreach ( $actions as $action ) {
//				print_r( $action );
//				// Check if the callback is an instance of YourClass and the method name is enqueue_admin_styles
//				//if ( ( $action['function'] instanceof Closure && $action['function'] === [ $this->admin_styles, 'enqueue_admin_styles' ] ) ||
//				//     ( $action['function'][0] instanceof EnqueueAdminStyles && $action['function'][1] === 'enqueue_admin_styles' ) ) {
//				//	$callbackFound = true;
//				//	break;
//				//}
//			}
//		}
//
//	}
//);
