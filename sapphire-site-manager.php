<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wp.bobbylee.com
 * @since             1.0.0
 * @package           Sapphire_Site_Manager
 *
 * @wordpress-plugin
 * Plugin Name:       Sapphire Site Manager
 * Plugin URI:        https://wp.bobbylee.com
 * Description:       Site manager for WordPress.
 * Version:           1.0.0
 * Author:            Bobby Lee
 * Author URI:        https://wp.bobbylee.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       sapphire-site-manager
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Currently plugin version.
 * Use SemVer - https://semver.org
 * Update this for new versions.
 */
define( 'SAPPHIRE_SITE_MANAGER_VERSION', '1.0.0' );
define( 'SAPPHIRE_SITE_MANAGER_URL', plugin_dir_url( __FILE__ ) );
define( 'SAPPHIRE_SITE_MANAGER_PATH', plugin_dir_path( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-sapphire-site-manager-activator.php
 */
function activate_sapphire_site_manager() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-sapphire-site-manager-activator.php';
    Sapphire_Site_Manager_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-sapphire-site-manager-deactivator.php
 */
function deactivate_sapphire_site_manager() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-sapphire-site-manager-deactivator.php';
    Sapphire_Site_Manager_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_sapphire_site_manager' );
register_deactivation_hook( __FILE__, 'deactivate_sapphire_site_manager' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-sapphire-site-manager.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_sapphire_site_manager() {

    $plugin = new Sapphire_Site_Manager();
    $plugin->run();

}

run_sapphire_site_manager();
