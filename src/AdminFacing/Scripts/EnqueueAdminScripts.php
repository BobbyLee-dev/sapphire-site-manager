<?php
declare( strict_types=1 );

namespace SapphireSiteManager\AdminFacing\Scripts;

use SapphireSiteManager\Traits\PluginDirectoryPathTrait;
use SapphireSiteManager\Traits\PluginDirectoryUrlTrait;
use SapphireSiteManager\Traits\PluginSlugTrait;
use SapphireSiteManager\Traits\PluginVersionTrait;

/**
 * Enqueue the scripts for the adminFacing area.
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

		// Enqueue Scripts.
		foreach ( glob( dirname( __DIR__, 1 ) . DIRECTORY_SEPARATOR . 'Scripts' . DIRECTORY_SEPARATOR . 'Script' . DIRECTORY_SEPARATOR . '*.php' ) as $path ) {
			$script_name = 'SapphireSiteManager\AdminFacing\Scripts\Script\\' . wp_basename( $path, '.php' );
			if ( class_exists( $script_name ) ) {
				$create_script = new $script_name();
				if ( $create_script->conditionals() ) {
					wp_enqueue_script(
						$create_script->handle(),
						$create_script->src(),
						$create_script->dependencies(),
						$create_script->version(),
						$create_script->args()
					);

					wp_set_script_translations( $create_script->handle(), $this->plugin_slug() );
				}
			}
		}

		// Localize Scripts.
		foreach ( glob( dirname( __DIR__, 1 ) . DIRECTORY_SEPARATOR . 'Scripts' . DIRECTORY_SEPARATOR . 'LocalizeScript' . DIRECTORY_SEPARATOR . '*.php' ) as $path ) {
			$localize_script_name = 'SapphireSiteManager\AdminFacing\Scripts\LocalizeScript\\' . wp_basename( $path, '.php' );
			if ( class_exists( $localize_script_name ) ) {
				$create_localize_script = new $localize_script_name();
				if ( $create_localize_script->conditionals() ) {
					wp_localize_script(
						$create_localize_script->handle(),
						$create_localize_script->object_name(),
						$create_localize_script->l10n_data(),
					);
				}
			}
		}
	}
}
