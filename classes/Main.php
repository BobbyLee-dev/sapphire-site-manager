<?php
declare( strict_types=1 );

namespace SapphireSiteManager;

use SapphireSiteManager\AdminFacing\AdminFacing;
use SapphireSiteManager\PublicFacing\PublicFacing;
use SapphireSiteManager\APIs\RegisterAPIs;
use SapphireSiteManager\CPT\RegisterCPTs;
use SapphireSiteManager\Taxonomy\RegisterTaxonomies;
use SapphireSiteManager\Traits\PluginNameTrait;
use SapphireSiteManager\Traits\PluginVersionTrait;

/**
 * The main Plugin class.
 */
class Main {
	use PluginNameTrait;
	use PluginVersionTrait;

	/**
	 * Define the core functionality of the plugin.
	 */
	public function __construct() {
		$this->define_activation_hook();
		$this->define_deactivation_hook();
		new AdminFacing();
		new PublicFacing();
		new RegisterCPTs();
		new RegisterTaxonomies();
		new RegisterAPIs();
		new I18n();
	}

	/**
	 * Register the activation hook.
	 */
	private function define_activation_hook(): void {
		register_activation_hook(
			__FILE__,
			function () {
				Activator::activate();
			}
		);
	}

	/**
	 * Register the deactivation hook.
	 */
	private function define_deactivation_hook(): void {
		register_deactivation_hook(
			__FILE__,
			function () {
				Deactivator::deactivate();
			}
		);
	}
}
