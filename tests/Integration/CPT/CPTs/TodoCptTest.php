<?php

namespace SapphireSiteManager\Tests\Integration\CPT\CPTs;

use Yoast\WPTestUtils\WPIntegration\TestCase;

/*
 * We need to provide the base test class to every integration test.
 * This will enable us to use all the WordPress test goodies, such as
 * factories and proper test cleanup.
 */
//uses( TestCase::class );

beforeEach(
	function () {
		parent::setUp();
	}
);

afterEach(
	function () {
		parent::tearDown();
	}
);

test(
	'Todo custom post type is registered',
	function () {
		$registered_post_types = \get_post_types();
		// Or we can use expectations API from Pest.
		expect( $registered_post_types )
			->toBeArray()
			->toHaveKey( 'sapphire-sm-todo' );
	}
);

it(
	'should be public',
	function () {
		$todo_cpt = \get_post_type_object( 'sapphire-sm-todo' );
		expect( $todo_cpt )
			->toBeTruthy( $todo_cpt->public );
	}
);
