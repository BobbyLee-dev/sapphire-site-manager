<?php
namespace SapphireSiteManager\Tests\Unit;

require dirname( dirname( __FILE__, 2 ) ) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use PHPUnit\Framework\TestCase;
use SapphireSiteManager\Main;

/**
 * @group unit
 **/
class LolTest extends TestCase {
	public function testLol() {
		$Receipt = new Main();
		$this->assertEquals(
			15,
			$Receipt->array_sum( [ 0, 2, 5, 8 ] ),
			'When summing the total should equal 15'
		);
	}
}



