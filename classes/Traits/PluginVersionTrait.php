<?php
declare( strict_types=1 );

namespace SapphireSiteManager\Traits;

/**
 * Trait that defines the plugin version.
 */
trait PluginVersionTrait {
	/**
	 * Defines the plugin version.
	 *
	 * @var string $plugin_version The version of this plugin.
	 */
	protected string $plugin_version = SAPPHIRE_SITE_MANAGER_VERSION;
}
