<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://wp.bobbylee.com
 * @since      1.0.0
 *
 * @package    Sapphire_Site_Manager
 * @subpackage Sapphire_Site_Manager/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Sapphire_Site_Manager
 * @subpackage Sapphire_Site_Manager/includes
 * @author     Bobby Lee <bobbylee.dev@gmail.com>
 */
class Sapphire_Site_Manager {

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Sapphire_Site_Manager_Loader $loader Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $plugin_name The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $version The current version of the plugin.
     */
    protected $version;

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

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_tax_radio_hooks();
        $this->define_public_hooks();
        $this->define_api_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Sapphire_Site_Manager_Loader. Orchestrates the hooks of the plugin.
     * - Sapphire_Site_Manager_i18n. Defines internationalization functionality.
     * - Sapphire_Site_Manager_Admin. Defines all hooks for the admin area.
     * - Sapphire_Site_Manager_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies() {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sapphire-site-manager-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sapphire-site-manager-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-sapphire-site-manager-admin.php';

        /**
         * The class responsible for converting custom taxonomy to radio buttons.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class_sapphire_site_manager_radio_taxonomy.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-sapphire-site-manager-public.php';

        /**
         * The class responsible for defining To-do endpoints/extensions
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'api/class-sapphire-site-manager-todo-api.php';

        $this->loader = new Sapphire_Site_Manager_Loader();

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
    private function set_locale() {

        $plugin_i18n = new Sapphire_Site_Manager_i18n();

        $this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

    }

    /**
     * Register all the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks() {

        $plugin_admin = new Sapphire_Site_Manager_Admin( $this->get_plugin_name(), $this->get_version() );
        $this->loader->add_action( 'admin_menu', $plugin_admin, 'add_admin_menu' );
        $this->loader->add_action( 'init', $plugin_admin, 'new_cpt_todo' );
        $this->loader->add_action( 'init', $plugin_admin, 'create_status_taxonomy' );

        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

    }

    /**
     * Register hooks for converting custom taxonomy to radio buttons
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_tax_radio_hooks() {

        $plugin_radio_taxonomy = new Sapphire_site_manager_radio_taxonomy( 'sapphire_todo_status', 'sapphire_sm_todo' );

        $this->loader->add_action( 'add_meta_boxes', $plugin_radio_taxonomy, 'add_radio_box' );

    }

    /**
     * Register all the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks() {

        $plugin_public = new Sapphire_Site_Manager_Public( $this->get_plugin_name(), $this->get_version() );

        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

    }

    /**
     * Register all the hooks related to the REST endpoints
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_api_hooks() {

        $plugin_api = new Sapphire_Site_Manager_Rest_Api( $this->get_plugin_name(), $this->get_version() );

        $this->loader->add_action( 'rest_api_init', $plugin_api, 'ssm_todo_routes' );


    }

    /**
     * Run the loader to execute all the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run() {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @return    string    The name of the plugin.
     * @since     1.0.0
     */
    public function get_plugin_name() {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @return    Sapphire_Site_Manager_Loader    Orchestrates the hooks of the plugin.
     * @since     1.0.0
     */
    public function get_loader() {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @return    string    The version number of the plugin.
     * @since     1.0.0
     */
    public function get_version() {
        return $this->version;
    }

}
