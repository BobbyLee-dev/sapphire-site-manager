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
	 * Set up the adminFacing items.
	 */
	public function run(): void {

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
