<?php
//namespace SapphireSiteManager\Tests\Unit;
//
//require dirname( __DIR__, 2 ) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
//
//use PHPUnit\Framework\TestCase;
//use SapphireSiteManager\Plugin;
//
///**
// * LolTest - an example test.
// * setup | tearDown | tests
// * Arrange | Act | Assert.
// *
// * @group unit
// **/
//class LolTest extends TestCase {
//
//	/**
//	 * Setup
//	 */
//	public function setUp(): void {
//		$this->Main = new Plugin();
//	}
//
//	/**
//	 * Tear Down
//	 */
//	public function tearDown(): void {
//		unset( $this->Main );
//	}
//
//	public function testTax() {
//		$inputAmount = 10.00;
//		$taxInput    = 0.10;
//		$output      = $this->Main->tax( $inputAmount, $taxInput );
//		$this->assertEquals(
//			1.00,
//			$output,
//			'The tax calculation should equal 1.00'
//		);
//	}
//
//	public function testLol() {
//		$input  = 'lol';
//		$output = $this->Main->say_lol( $input );
//		$this->assertEquals(
//			'lol',
//			$output,
//			'The message should say lol'
//		);
//	}
//
//	public function testAddTwo() {
//		$input  = 2;
//		$output = $this->Main->add_two( $input );
//		$this->assertEquals(
//			4,
//			$output,
//			'The number should be 4.'
//		);
//	}
//}
