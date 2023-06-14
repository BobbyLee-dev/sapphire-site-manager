<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wp.bobbylee.com
 * @since      1.0.0
 *
 * @package    Sapphire_Site_Manager
 * @subpackage Sapphire_Site_Manager/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Sapphire_Site_Manager
 * @subpackage Sapphire_Site_Manager/admin
 * @author     Bobby Lee <bobbylee.dev@gmail.com>
 */
class Sapphire_Site_Manager_Admin {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @param string $plugin_name The name of this plugin.
     * @param string $version The version of this plugin.
     *
     * @since    1.0.0
     */
    public function __construct( $plugin_name, $version ) {

        $this->plugin_name = $plugin_name;
        $this->version     = $version;

    }


    /**
     * Add Admin Page Menu Page
     *
     * @since 1.0.0
     */
    public function add_admin_menu() {

        // Top-level page
        // add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );

        add_menu_page(
            esc_html__( 'Sapphire Site Manager', 'sapphire-site-manager' ),
            esc_html__( 'Sapphire Site Manager', 'sapphire-site-manager' ),
            'manage_options',
            $this->plugin_name,
            array( $this, 'add_root_div' ),
            'dashicons-smiley',
            null
        );

        // Submenu Page
        // add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function)

        // add_submenu_page(
        // 	$this->plugin_name . '-dashboard',
        // 	esc_html__('Dashboard', 'sapphire-site-manager'),
        // 	esc_html__('Dashboard', 'sapphire-site-manager'),
        // 	'manage_options',
        // 	$this->plugin_name . '-dashboard',
        // 	array($this, 'add_setting_root_div'),
        // 	0
        // );

        // add_submenu_page(
        // 	$this->plugin_name . '-dashboard',
        // 	esc_html__('Todos', 'sapphire-site-manager'),
        // 	esc_html__('Todos', 'sapphire-site-manager'),
        // 	'manage_options',
        // 	$this->plugin_name . '-todos',
        // 	array($this, 'add_setting_root_div'),
        // 	1
        // );

    }

    /**
     * Add Root Div For React.
     *
     * @since    1.0.0
     */
    public function add_root_div() {
        echo '<div id="' . $this->plugin_name . '"></div>';
    }


    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        $version = $this->version;

        // Only run if is on a Sapphire Site Manager parent page.
        $screen              = get_current_screen();
        $admin_scripts_bases = array( 'toplevel_page_' . $this->plugin_name );
        if ( ! ( isset( $screen->base ) && in_array( $screen->base, $admin_scripts_bases ) ) ) {
            return;
        }

        wp_enqueue_style( $this->plugin_name . '-style',
            SAPPHIRE_SITE_MANAGER_URL . 'build/admin/Main.css',
            array( 'wp-components' ),
            $version );

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        // Only run if is on a Sapphire Site Manager parent page.
        $screen              = get_current_screen();
        $admin_scripts_bases = array( 'toplevel_page_' . $this->plugin_name );
        if ( ! ( isset( $screen->base ) && in_array( $screen->base, $admin_scripts_bases ) ) ) {
            return;
        }

        // Backbone JS Client - https://developer.wordpress.org/rest-api/using-the-rest-api/backbone-javascript-client/
//        wp_enqueue_script( 'wp-api' );

        // Scripts dependency files gets auto generated
        $deps_file = SAPPHIRE_SITE_MANAGER_PATH . 'build/admin/Main.asset.php';

        /*Fallback dependency array*/
        $dependency = [];
        $version    = $this->version;

        // Set dependency and version gets auto generated from js and built to build/admin/Main.asset.php
        if ( file_exists( $deps_file ) ) {
            $deps_file  = require( $deps_file );
            $dependency = $deps_file[ 'dependencies' ];
            $version    = $deps_file[ 'version' ];
        }

        wp_enqueue_script( $this->plugin_name,
            SAPPHIRE_SITE_MANAGER_URL . 'build/admin/Main.js',
            $dependency,
            $version,
            true );


        // Used to grab root id for render of page
        $localize = array(
            'version' => $this->version,
            'root_id' => $this->plugin_name,
        );
        wp_set_script_translations( $this->plugin_name, $this->plugin_name );
        wp_localize_script( $this->plugin_name, 'sapphireSiteManager', $localize );
    }


    /**
     * Register custom post types for Todos.
     *
     * Does not create front end pages.
     *
     * @since    1.0.0
     * @uses    register_post_type()
     */
    public static function new_cpt_todo() {

        $todoLabels = array(
            'name'               => esc_html__( 'To-dos', 'sapphire_site_manager' ),
            'singular_name'      => esc_html__( 'Todo', 'sapphire_site_manager' ),
            'archives'           => esc_html__( 'To-dos', 'sapphire_site_manager' ),
            'add_new'            => esc_html__( 'Add Todo', 'sapphire_site_manager' ),
            'add_new_item'       => esc_html__( 'Add Todo', 'sapphire_site_manager' ),
            'edit_item'          => esc_html__( 'Edit Todo', 'sapphire_site_manager' ),
            'new_item'           => esc_html__( 'New Todo', 'sapphire_site_manager' ),
            'view_item'          => esc_html__( 'View Todo', 'sapphire_site_manager' ),
            'search_items'       => esc_html__( 'Search To-dos', 'sapphire_site_manager' ),
            'not_found'          => esc_html__( 'No To-dos found', 'sapphire_site_manager' ),
            'not_found_in_trash' => esc_html__( 'No To-dos found in Trash', 'sapphire_site_manager' ),
        );

        $todoArgs = array(
            'labels'              => $todoLabels,
            'description'         => esc_html__( 'Sapphire To-dos - To-dos', 'sapphire_site_manager' ),
            'public'              => true,
            'exclude_from_search' => true,
            'publicly_queryable'  => false,
            'show_in_menu'        => 'sapphire-todos-settings',
            'show_in_nav_menus'   => false,
            'supports'            => array( 'title', 'editor', 'thumbnail' => false ),
            'show_in_rest'        => true,
            'pages'               => false,
            'has_archive'         => false,
        );

        register_post_type( 'sapphire_sm_todo', $todoArgs );

    }

}
