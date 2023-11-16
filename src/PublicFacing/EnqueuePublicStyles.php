<?php
declare( strict_types=1 );

namespace SapphireSiteManager\PublicFacing;

use SapphireSiteManager\Traits\PluginNameTrait;
use SapphireSiteManager\Traits\PluginVersionTrait;

/**
 * Enqueues public facing styles.
 */
class EnqueuePublicStyles {
	use PluginNameTrait;
	use PluginVersionTrait;

	/**
	 * Initialize the class and set its properties.
	 */
	public function __construct() {
		$this->enqueue_scripts();
	}

	/**
	 * Register the stylesheets for the publicFacing area.
	 */
	public function enqueue_scripts(): void {
		wp_enqueue_style(
			$this->plugin_name(),
			plugin_dir_url( __FILE__ ) . 'css/sapphire-site-manager-public.css',
			array(),
			$this->plugin_version(),
			'all'
		);
	}
}
