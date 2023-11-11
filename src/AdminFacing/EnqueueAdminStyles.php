<?php
declare( strict_types=1 );

namespace SapphireSiteManager\AdminFacing;

use SapphireSiteManager\Traits\{PluginDirectoryUrlTrait, PluginNameTrait, PluginVersionTrait};

/**
 * Register the stylesheets for the adminFacing area.
 *
 * @since 1.0.0
 */
class EnqueueAdminStyles {
	use PluginNameTrait;
	use PluginVersionTrait;
	use PluginDirectoryUrlTrait;

	/**
	 * Initialize the class and set its properties.
	 */
	public function __construct() {
		$this->enqueue_styles();
	}

	/**
	 * Register the stylesheets for the adminFacing area.
	 */
	public function enqueue_styles(): void {
		// Only run if is on a Sapphire Site Manager parent page.
		$screen              = get_current_screen();
		$admin_scripts_bases = array( 'toplevel_page_' . $this->plugin_name );
		if ( ! ( isset( $screen->base ) && in_array( $screen->base, $admin_scripts_bases, true ) ) ) {
			return;
		}

		wp_enqueue_style(
			$this->plugin_name . '-style',
			$this->plugin_dir_url . 'build/adminFacing/Main.css',
			array( 'wp-components' ),
			$this->plugin_version
		);
	}
}