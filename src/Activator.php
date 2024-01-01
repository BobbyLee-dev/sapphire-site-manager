<?php
declare( strict_types=1 );

namespace SapphireSiteManager;

use SapphireSiteManager\DB\DB;

/**
 * Fired during plugin activation
 */
class Activator {

	/**
	 * Defines the code to be run during plugin activation.
	 */
	public static function activate(): void {
		$test = new DB();
		$test->run();
	}
}
