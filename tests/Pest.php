<?php

use SapphireSiteManager\Traits\PluginVersionTrait;
use Yoast\WPTestUtils\BrainMonkey\TestCase;

uses( PluginVersionTrait::class );
uses( TestCase::class );

uses()->group( 'integration' )->in( 'Integration' );
uses()->group( 'unit' )->in( 'Unit' );

//uses( TestCase::class )->in( 'Unit' );

function isUnitTest() {
	return ! empty( $GLOBALS['argv'] ) && $GLOBALS['argv'][1] === '--group=unit';
}
