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
	 * Initialize the class and set its properties.
	 */
	public function __construct() {
		$this->create_menu_page();
	}

	/**
	 * Add AdminFacing Page/Menu item
	 */
	public function create_menu_page(): void {
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
