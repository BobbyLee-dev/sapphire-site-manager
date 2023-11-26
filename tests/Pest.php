<?php

use Yoast\WPTestUtils\BrainMonkey\TestCase;

//
uses( TestCase::class );

uses()->group( 'integration' )->in( 'Integration' );
//uses()->group( 'integration' )->in( 'Integration' );
uses()->group( 'unit' )->in( 'Unit' );


function isUnitTest(): bool {
	return ! empty( $GLOBALS['argv'] ) && $GLOBALS['argv'][1] === '--group=unit';
}
