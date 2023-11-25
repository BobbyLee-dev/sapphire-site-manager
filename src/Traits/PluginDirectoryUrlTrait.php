<?php
declare( strict_types=1 );

namespace SapphireSiteManager\Traits;

/**
 * Trait that defines the plugin url.
 */
trait PluginDirectoryUrlTrait {

	/**
	 * Defines the plugin directory url.
	 *
	 * @return non-empty-string
	 */
	private function my_plugin_dir_url(): string {
		// @phpstan-ignore-next-line
		return SAPPHIRE_SITE_MANAGER_URL;
	}
}
