<?php
declare( strict_types=1 );

namespace SapphireSiteManager\Traits;

/**
 * Trait that defines the plugin slug.
 */
trait PluginSlugTrait {
	/**
	 * Defines the plugin name.
	 */
	private function plugin_slug(): string {
		return SAPPHIRE_SITE_MANAGER_SLUG;
	}
}
