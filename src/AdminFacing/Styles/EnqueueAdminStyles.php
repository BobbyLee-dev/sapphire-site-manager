<?php
declare( strict_types=1 );

namespace SapphireSiteManager\AdminFacing\Styles;

use SapphireSiteManager\Traits\{PluginDirectoryUrlTrait, PluginSlugTrait, PluginVersionTrait};

/**
 * Register the stylesheets for the adminFacing area.
 *
 * @since 1.0.0
 */
class EnqueueAdminStyles {
	use PluginSlugTrait;
	use PluginVersionTrait;
	use PluginDirectoryUrlTrait;

	/**
	 * Setup action to enqueue the admin styles.
	 */
	public function run(): void {
		add_action(
			'admin_enqueue_scripts',
			function () {
				$this->enqueue_admin_styles();
			}
		);
	}

	/**
	 * Register the stylesheets for the adminFacing area.
	 */
	public function enqueue_admin_styles(): void {
		// Only run if is on a Sapphire Site Manager parent page.
		$screen              = get_current_screen();
		$admin_scripts_bases = array( 'toplevel_page_' . $this->plugin_slug() );
		if ( ! ( isset( $screen->base ) && in_array( $screen->base, $admin_scripts_bases, true ) ) ) {
			return;
		}

		wp_enqueue_style(
			$this->plugin_slug() . '-style',
			$this->my_plugin_dir_url() . 'build/adminFacing/Main.css',
			array( 'wp-components' ),
			$this->plugin_version()
		);
	}
}
