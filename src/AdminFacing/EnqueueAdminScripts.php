<?php
declare( strict_types=1 );

namespace SapphireSiteManager\AdminFacing;

use SapphireSiteManager\Traits\PluginDirectoryPathTrait;
use SapphireSiteManager\Traits\PluginDirectoryUrlTrait;
use SapphireSiteManager\Traits\PluginSlugTrait;
use SapphireSiteManager\Traits\PluginVersionTrait;

/**
 * Register the scripts for the adminFacing area.
 */
class EnqueueAdminScripts {
	use PluginSlugTrait;
	use PluginVersionTrait;
	use PluginDirectoryUrlTrait;
	use PluginDirectoryPathTrait;

	/**
	 * Initialize the class and set its properties.
	 */
	public function run(): void {
		add_action(
			'admin_enqueue_scripts',
			function () {
				$this->enqueue_admin_scripts();
			}
		);
	}

	/**
	 * Register the scripts for the adminFacing area.
	 */
	public function enqueue_admin_scripts(): void {
		// Only run if is on a Sapphire Site Manager parent page.
		$screen              = get_current_screen();
		$admin_scripts_bases = array( 'toplevel_page_' . $this->plugin_slug() );
		if ( ! ( isset( $screen->base ) && in_array( $screen->base, $admin_scripts_bases, true ) ) ) {
			return;
		}

		// Backbone JS Client - https://developer.wordpress.org/rest-api/using-the-rest-api/backbone-javascript-client/
		// wp_enqueue_script( 'wp-api' );
		// Scripts dependency files gets auto generated.
		$deps_file = $this->my_plugin_dir_path() . 'build/adminFacing/Main.asset.php';

		// Fallback dependency array.
		$dependency = array();
		$version    = $this->plugin_version();

		// Set dependency and version gets auto generated from js and built to build/adminFacing/Main.asset.php.
		if ( file_exists( $deps_file ) === true ) {
			$deps_file  = include $deps_file;
			$dependency = $deps_file['dependencies'];
			$version    = $deps_file['version'];
		}

		wp_enqueue_script(
			$this->plugin_slug(),
			$this->my_plugin_dir_url() . 'build/adminFacing/Main.js',
			$dependency,
			$version,
			true
		);

		// Used to grab root id for render of page.
		$localize = array(
			'version' => $this->plugin_version(),
			'root_id' => $this->plugin_slug(),
		);
		wp_set_script_translations( $this->plugin_slug(), $this->plugin_slug() );
		wp_localize_script( $this->plugin_slug(), 'sapphireSiteManager', $localize );
	}
}
