<?php

namespace SapphireSiteManager\Tests\Integration\CPT\CPTs;

use Yoast\WPTestUtils\WPIntegration\TestCase;
use function get_post_type_object;
use function get_post_types;

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
		$this->registerdPostTypes = get_post_types();
		$this->todoCpt            = get_post_type_object( 'sapphire-sm-todo' );
	}
);

afterEach(
	function () {
		unset( $this->registerdPostTypes );
		unset( $this->todoCpt );
		parent::tearDown();
	}
);

test(
	'Todo custom post type is registered',
	function () {
		expect( $this->registerdPostTypes )
			->toBeArray()
			->toHaveKey( 'sapphire-sm-todo' );
	}
);

it(
	'should be public',
	function () {
		expect( $this->todoCpt )
			->toBeTruthy( $this->todoCpt->public );
	}
);
