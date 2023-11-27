<?php
namespace SapphireSiteManager\Tests\Integration\AdminFacing\Styles\Style;

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
		// Create a user and log them in.
		$this->user_id = $this::factory()->user->create();
		wp_set_current_user( $this->user_id );
	}

);

afterEach(
	function () {
		wp_set_current_user( 0 );
		$this->main_style = null;
		parent::tearDown();
	}
);

it(
	'should return true if the user is logged in.',
	function () {
		expect( $this->main_style->conditionals() )->toBe( true );
	}
);

it(
	'should return false if the user is not logged in.',
	function () {
		wp_set_current_user( 0 );
		expect( $this->main_style->conditionals() )->toBe( false );
	}
);

it(
	'should have the handle plugin-slug-name-style.',
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
		expect( $this->main_style->dependencies() )
			->toBeArray()
			->and( 'wp-components' )->toBeIn( $this->main_style->dependencies() );
	}
);

it(
	'should have the same version as the plugin version.',
	function () {
		expect( $this->main_style->version() )->toBe( $this->plugin_version() );
	}
);

it(
	'should have media "all".',
	function () {
		expect( $this->main_style->media() )->toBe( 'all' );
	}
);
