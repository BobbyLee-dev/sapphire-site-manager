<?php
declare( strict_types=1 );

namespace SapphireSiteManager\Traits;

/**
 * Trait that defines the plugin path.
 */
trait PluginDirectoryPathTrait {
	/**
	 * Defines the plugin directory path.
	 */
	private function my_plugin_dir_path(): string {
		// @phpstan-ignore-next-line
		return SAPPHIRE_SITE_MANAGER_PATH;

	}
}
