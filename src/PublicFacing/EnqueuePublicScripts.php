<?php
declare( strict_types=1 );

namespace SapphireSiteManager\PublicFacing;

use SapphireSiteManager\Traits\PluginNameTrait;
use SapphireSiteManager\Traits\PluginVersionTrait;

/**
 * Enqueues public facing scripts.
 */
class EnqueuePublicScripts {
	use PluginNameTrait;
	use PluginVersionTrait;

	/**
	 * Initialize the class and set its properties.
	 */
	public function __construct() {
		$this->enqueue_scripts();
	}

	/**
	 * Register the scripts for the publicFacing area.
	 */
	public function enqueue_scripts(): void {
		wp_enqueue_script(
			$this->plugin_name,
			plugin_dir_url( __FILE__ ) . 'js/sapphire-site-manager-public.js',
			array(),
			$this->plugin_version,
			false
		);
	}
}
