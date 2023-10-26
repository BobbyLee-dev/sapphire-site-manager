<?php
declare( strict_types=1 );

namespace SapphireSiteManager;

use SapphireSiteManager\admin\AdminFacing;
use SapphireSiteManager\PublicFacing\PublicFacing;

/**
 * The main Plugin class.
 */
class SapphireSiteManager {
	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Loader $loader Maintains and registers all hooks for the plugin.
	 */
	protected Loader $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $plugin_name The string used to uniquely identify this plugin.
	 */
	protected string $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $version The current version of the plugin.
	 */
	protected string $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'SAPPHIRE_SITE_MANAGER_VERSION' ) ) {
			$this->version = SAPPHIRE_SITE_MANAGER_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'sapphire-site-manager';

		$this->loader = new Loader();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_tax_radio_hooks();
		$this->define_public_hooks();
		$this->define_api_hooks();
		$this->define_activation_hook();
		$this->define_deactivation_hook();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Sapphire_Site_Manager_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale(): void {
		$plugin_i18n = new I18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register all the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks(): void {
		$plugin_admin = new AdminFacing( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_admin_menu' );
		$this->loader->add_action( 'init', $plugin_admin, 'new_cpt_todo' );
		$this->loader->add_action( 'init', $plugin_admin, 'create_todo_taxonomies' );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @return    string    The name of the plugin.
	 * @since     1.0.0
	 */
	public function get_plugin_name(): string {
		return $this->plugin_name;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @return    string    The version number of the plugin.
	 * @since     1.0.0
	 */
	public function get_version(): string {
		return $this->version;
	}

	/**
	 * Register hooks for converting custom taxonomy to radio buttons
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_tax_radio_hooks(): void {
		$plugin_status_taxonomy   = new Taxonomy( 'sapphire_todo_status', array( 'sapphire_sm_todo' ), 'Not Started' );
		$plugin_priority_taxonomy = new Taxonomy( 'sapphire_todo_priority', array( 'sapphire_sm_todo' ), 'Not Set' );

		$this->loader->add_action( 'rest_prepare_taxonomy', $plugin_status_taxonomy, 'add_radio_box' );
		$this->loader->add_action( 'rest_prepare_taxonomy', $plugin_priority_taxonomy, 'add_radio_box' );
	}

	/**
	 * Register all the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks(): void {
		$plugin_public = new PublicFacing( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
	}

	/**
	 * Register all the hooks related to the REST endpoints
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_api_hooks(): void {
		$plugin_api = new Api( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'rest_api_init', $plugin_api, 'ssm_todo_routes' );
	}

	/**
	 * Register the activation hook.
	 *
	 * @return void
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
	 *
	 * @return void
	 */
	private function define_deactivation_hook(): void {
		register_deactivation_hook(
			__FILE__,
			function () {
				Deactivator::deactivate();
			}
		);
	}

	/**
	 * Run the loader to execute all the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run(): void {
		$this->loader->run();
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @return    Loader    Orchestrates the hooks of the plugin.
	 * @since     1.0.0
	 */
	public function get_loader(): Loader {
		return $this->loader;
	}
}
