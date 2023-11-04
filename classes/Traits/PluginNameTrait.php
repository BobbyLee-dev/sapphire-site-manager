<?php
declare( strict_types=1 );

namespace SapphireSiteManager\Traits;

/**
 * Trait that defines the plugin name.
 */
trait PluginNameTrait {
	/**
	 * Defines the plugin name.
	 *
	 * @var string $plugin_name The name of this plugin.
	 */
	protected string $plugin_name = SAPPHIRE_SITE_MANAGER_NAME;
}
