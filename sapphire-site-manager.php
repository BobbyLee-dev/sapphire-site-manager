<?php
declare( strict_types=1 );

/**
 * Plugin Name:       Sapphire Site Manager
 * Plugin URI:        https://sapphiresitemanager.com
 * Description:       Site manager for WordPress.
 * Version:           1.0.0
 * Author:            Bobby Lee
 * Author URI:        https://sapphiresitemanager.com
 * Text Domain:       sapphire-site-manager
 * Domain Path:       /languages
 * Requires PHP: 8.0
 *
 * Copyright (c) 2023 Sapphire Studios. All rights reserved.
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * **********************************************************************
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * **********************************************************************
 */

use SapphireSiteManager\SapphireSiteManager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'SAPPHIRE_SITE_MANAGER_VERSION', '1.0.0' );
define( 'SAPPHIRE_SITE_MANAGER_URL', plugin_dir_url( __FILE__ ) );
define( 'SAPPHIRE_SITE_MANAGER_PATH', plugin_dir_path( __FILE__ ) );
define( 'SAPPHIRE_SITE_MANAGER_PHP_VERSION', '8.0' );

require __DIR__ . '/vendor/autoload.php';

$sapphire_site_manager_init = new SapphireSiteManager();
$sapphire_site_manager_init->run();
