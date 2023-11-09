<?php

use SapphireSiteManager\Main;

test( 'sum', function () {
	$result = 3;

	expect( $result )->toBe( 3 );
} );

test( 'say hi', function () {
	$result = 'hi bobby';
	$t      = new Main( 'test' );

	expect( $result )->toBe( $t->say_hi() );

} );
