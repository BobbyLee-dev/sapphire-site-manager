<?php
declare( strict_types=1 );

namespace SapphireSiteManager\PublicFacing;

use SapphireSiteManager\Traits\PluginNameTrait;
use SapphireSiteManager\Traits\PluginVersionTrait;

/**
 * The PublicFacing-facing functionality of the plugin.
 */
class PublicFacing {
	use PluginNameTrait;
	use PluginVersionTrait;

	/**
	 * Initialize the class and set its properties.
	 */
	public function __construct() {
		$this->enqueue_styles();
		$this->enqueue_scripts();
	}

	/**
	 * Register the stylesheets for the PublicFacing side of the site.
	 */
	public function enqueue_styles(): void {
		add_action(
			'wp_enqueue_styles',
			function () {
				new EnqueuePublicStyles( $this->plugin_name(), $this->plugin_version() );
			}
		);
	}

	/**
	 * Register the JavaScript for the PublicFacing side of the site.
	 */
	public function enqueue_scripts(): void {
		add_action(
			'wp_enqueue_scripts',
			function () {
				new EnqueuePublicScripts( $this->plugin_name, $this->plugin_version );
			}
		);
	}
}
