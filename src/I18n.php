<?php
declare( strict_types=1 );

namespace SapphireSiteManager;

use SapphireSiteManager\Traits\PluginNameTrait;

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 */
class I18n {
	use PluginNameTrait;

	/**
	 * Initialize the class and set its properties.
	 */
	public function __construct() {
		$this->load_plugin_textdomain();
	}

	/**
	 * Load the plugin text domain for translation.
	 */
	public function load_plugin_textdomain(): void {
		add_action(
			'plugins_loaded',
			function () {
				load_plugin_textdomain(
					$this->plugin_name(),
					false,
					dirname( plugin_basename( __FILE__ ), 2 ) . '/languages/'
				);
			}
		);
	}
}
