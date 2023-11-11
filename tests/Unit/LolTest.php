<?php
namespace SapphireSiteManager\Tests\Unit;

require dirname( __DIR__, 2 ) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use PHPUnit\Framework\TestCase;
use SapphireSiteManager\Main;

/**
 * Arrange | Act | Assert.
 *
 * @group unit
 **/
class LolTest extends TestCase {
	public function setUp(): void {
		$this->Main = new Main();
	}

	public function tearDown(): void {
		unset( $this->Main );
	}

	public function testLol() {
		$input  = [ 0, 2, 5, 8 ];
		$output = $this->Main->array_sum( $input );
		$this->assertEquals(
			15,
			$output,
			'When summing the total should equal 15'
		);
	}
}
