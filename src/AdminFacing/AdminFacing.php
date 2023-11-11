<?php
declare( strict_types=1 );

namespace SapphireSiteManager\AdminFacing;

/**
 * Defines the admin functionality and classes.
 */
class AdminFacing {
	/**
	 * Initialize the class and set its properties.
	 */
	public function __construct() {
		$this->enqueue_admin_styles();
		$this->enqueue_admin_scripts();
		$this->add_admin_menu();
	}

	/**
	 * Adds admin menu item/page.
	 */
	public function add_admin_menu(): void {
		add_action(
			'admin_menu',
			function () {
				new AdminMenu();
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
}
