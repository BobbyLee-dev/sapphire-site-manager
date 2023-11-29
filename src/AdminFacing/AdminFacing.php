<?php
declare( strict_types=1 );

namespace SapphireSiteManager\AdminFacing;

use SapphireSiteManager\AdminFacing\Menu\AdminMenu;
use SapphireSiteManager\AdminFacing\Scripts\EnqueueAdminScripts;
use SapphireSiteManager\AdminFacing\Styles\EnqueueAdminStyles;

/**
 * Defines the admin functionality and classes.
 */
class AdminFacing {
	/**
	 * Find and run all classes in Helpers.
	 *
	 * @return void
	 */
	public function run_admin_facing_helpers(): void {
		foreach ( glob( dirname( __DIR__, 1 ) . DIRECTORY_SEPARATOR . 'AdminFacing' . DIRECTORY_SEPARATOR . 'Helpers' . DIRECTORY_SEPARATOR . '*.php' ) as $path ) {
			$helper_name = 'SapphireSiteManager\AdminFacing\Helpers\\' . wp_basename( $path, '.php' );
			if ( class_exists( $helper_name ) ) {
				$helper = new $helper_name();
				$helper->run();
			}
		}
	}

	/**
	 * Set up the adminFacing items.
	 */
	public function run(): void {

		$this->run_admin_facing_helpers();

		// Admin Menu.
		$admin_menu = new AdminMenu();
		$admin_menu->run();

		// Enqueue Admin Styles.
		$admin_styles = new EnqueueAdminStyles();
		$admin_styles->run();

		// Enqueue Admin Scripts.
		$admin_scripts = new EnqueueAdminScripts();
		$admin_scripts->run();
	}
}
