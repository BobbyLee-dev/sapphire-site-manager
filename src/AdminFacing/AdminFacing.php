<?php
declare( strict_types=1 );

namespace SapphireSiteManager\AdminFacing;

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

		// Enqueue Styles.
		$this->enqueue_admin_styles();

		// Enqueue Scripts.
		$this->enqueue_admin_scripts();
	}

	/**
	 * Register and Enqueue the Styles for the adminFacing area.
	 */
	public function enqueue_admin_styles(): void {
		add_action(
			'admin_enqueue_scripts',
			function () {
				new EnqueueAdminStyles();
			}
		);
	}

	/**
	 * Register and Enqueue the JavaScript for the adminFacing area.
	 */
	public function enqueue_admin_scripts(): void {
		add_action(
			'admin_enqueue_scripts',
			function () {
				new EnqueueAdminScripts();
			}
		);
	}
}
