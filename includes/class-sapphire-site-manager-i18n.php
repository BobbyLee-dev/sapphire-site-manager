<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://wp.bobbylee.com
 * @since      1.0.0
 *
 * @package    Sapphire_Site_Manager
 * @subpackage Sapphire_Site_Manager/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Sapphire_Site_Manager
 * @subpackage Sapphire_Site_Manager/includes
 * @author     Bobby Lee <bobbylee.dev@gmail.com>
 */
class Sapphire_Site_Manager_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'sapphire-site-manager',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
