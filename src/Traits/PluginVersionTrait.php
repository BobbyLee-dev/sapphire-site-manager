<?php
declare( strict_types=1 );

namespace SapphireSiteManager\Traits;

/**
 * Trait that defines the plugin version.
 */
trait PluginVersionTrait {
	/**
	 * Defines the plugin version.
	 */
	private function plugin_version(): string {
		return SAPPHIRE_SITE_MANAGER_VERSION;
	}
}
