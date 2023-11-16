<?php
declare( strict_types=1 );

namespace SapphireSiteManager\Traits;

/**
 * Trait that defines the plugin name.
 */
trait PluginNameTrait {
	/**
	 * Defines the plugin name.
	 */
	private function plugin_name(): string {
		return SAPPHIRE_SITE_MANAGER_NAME;
	}
}
