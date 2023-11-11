<?php
declare( strict_types=1 );

namespace SapphireSiteManager\Traits;

/**
 * Trait that defines the plugin path.
 */
trait PluginDirectoryPathTrait {
	/**
	 * Defines the plugin directory path.
	 *
	 * @var string $plugin_dir_path The directory path of this plugin.
	 */
	protected string $plugin_dir_path = SAPPHIRE_SITE_MANAGER_PATH;
}
