<?php
declare( strict_types=1 );

namespace SapphireSiteManager\AdminFacing;

use SapphireSiteManager\Traits\PluginNameTrait;

/**
 * Create the Admin Menu Item
 */
class AdminMenu {
	use PluginNameTrait;

	/**
	 * Setup action to create the admin menu.
	 */
	public function run(): void {
		add_action(
			'admin_menu',
			function () {
				$this->create_admin_pages();
			}
		);
	}

	/**
	 * Add AdminFacing Page/Menu items.
	 */
	public function create_admin_pages(): void {
		add_menu_page(
			esc_html__( 'Sapphire Site Manager', 'sapphire-site-manager' ),
			esc_html__( 'Sapphire Site Manager', 'sapphire-site-manager' ),
			'manage_options',
			$this->plugin_name,
			function () {
				echo '<div id="' . esc_html( $this->plugin_name ) . '"></div>';
			},
			'dashicons-smiley',
			null
		);
	}
}
