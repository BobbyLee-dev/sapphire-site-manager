<?php
declare( strict_types=1 );

namespace SapphireSiteManager;

use SapphireSiteManager\AdminFacing\AdminFacing;
use SapphireSiteManager\PublicFacing\PublicFacing;
use SapphireSiteManager\APIs\RegisterAPIs;
use SapphireSiteManager\CPTs\CTPs\ToDo;
use SapphireSiteManager\CPTs\RegisterCPT;
use SapphireSiteManager\Taxonomies\RegisterTaxonomy;
use SapphireSiteManager\Taxonomies\Taxonomies\Priority;
use SapphireSiteManager\Taxonomies\Taxonomies\Status;
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
		$this->define_apis();
		$this->define_cpts();
		$this->define_taxonomies();
		new AdminFacing();
		new PublicFacing();
		new I18n();
	}

	/**
	 * Define the Custom Post Types for the plugin
	 * Uses the RegisterCPT class in order to create the CPTs.
	 */
	private function define_cpts(): void {

		$sapphire_cpts = new RegisterCPT();
		$sapphire_cpts
			->add( new ToDo() );

		add_action( 'init', [ $sapphire_cpts, 'register' ] );
	}

	/**
	 * Define the Taxonomies for the plugin
	 * Uses the RegisterTaxonomy class in order to create the Taxonomies.
	 */
	private function define_taxonomies(): void {

		$sapphire_taxonomies = new RegisterTaxonomy();
		$sapphire_taxonomies
			->add( new Status() )
			->add( new Priority() );

		add_action( 'init', [ $sapphire_taxonomies, 'register' ] );
		add_action( 'rest_prepare_taxonomy', [ $sapphire_taxonomies, 'add_radio_box' ] );
	}

	/**
	 * Register all the apis for the plugin.
	 */
	private function define_apis(): void {
		new RegisterAPIs();
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
