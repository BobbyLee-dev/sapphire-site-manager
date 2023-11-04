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
	 * @var string $plugin_dir_url The url of this plugin.
	 */
	protected string $plugin_dir_url = SAPPHIRE_SITE_MANAGER_URL;
}
