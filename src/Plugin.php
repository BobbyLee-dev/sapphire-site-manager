<?php
declare( strict_types=1 );

namespace SapphireSiteManager;

use SapphireSiteManager\AdminFacing\AdminFacing;
use SapphireSiteManager\API\RegisterAPIs;
use SapphireSiteManager\CPT\RegisterCPTs;
use SapphireSiteManager\PublicFacing\PublicFacing;
use SapphireSiteManager\Taxonomy\RegisterTaxonomies;

/**
 * The main Plugin class.
 */
class Plugin {

	/**
	 * Start and run the plugin.
	 */
	public function run(): void {
		$this->define_activation_hook();
		$this->define_deactivation_hook();

		// Admin.
		$admin_facing = new AdminFacing();
		$admin_facing->run();

		// Public.
		new PublicFacing();

		// CPTs.
		new RegisterCPTs();

		// Taxonomies.
		new RegisterTaxonomies();

		// APIs.
		new RegisterAPIs();

		// I18n languages.
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
