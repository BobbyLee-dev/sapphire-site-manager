<?php
declare( strict_types=1 );

namespace SapphireSiteManager\admin;

/**
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @subpackage Sapphire_Site_Manager/admin
 * @author     Bobby Lee <bobbylee.dev@gmail.com>
 * @package    Sapphire_Site_Manager
 */
class AdminFacing {
	/**
	 * The ID of this plugin.
	 *
	 * @since 1.0.0
	 * @var   string $plugin_name The ID of this plugin.
	 */
	private string $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @var   string $version The current version of this plugin.
	 * @since 1.0.0
	 */
	private string $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of this plug in.
	 * @param string $version The version of this plugin.
	 *
	 * @version 1.0.0
	 */
	public function __construct( string $plugin_name, string $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register custom post types for Todos.
	 *
	 * Does not create front end pages.
	 *
	 * @return void
	 * @uses   register_post_type()
	 * @since  1.0.0
	 */
	public function new_cpt_todo(): void {
		$todo_labels = array(
			'name'               => esc_html__( 'To-dos', 'sapphire-site-manager' ),
			'singular_name'      => esc_html__( 'Todo', 'sapphire-site-manager' ),
			'archives'           => esc_html__( 'To-dos', 'sapphire-site-manager' ),
			'add_new'            => esc_html__( 'Add Todo', 'sapphire-site-manager' ),
			'add_new_item'       => esc_html__( 'Add Todo', 'sapphire-site-manager' ),
			'edit_item'          => esc_html__( 'Edit Todo', 'sapphire-site-manager' ),
			'new_item'           => esc_html__( 'New Todo', 'sapphire-site-manager' ),
			'view_item'          => esc_html__( 'View Todo', 'sapphire-site-manager' ),
			'search_items'       => esc_html__( 'Search To-dos', 'sapphire-site-manager' ),
			'not_found'          => esc_html__( 'No To-dos found', 'sapphire-site-manager' ),
			'not_found_in_trash' => esc_html__( 'No To-dos found in Trash', 'sapphire-site-manager' ),
		);

		$todo_args = array(
			'labels'              => $todo_labels,
			'description'         => esc_html__( 'Sapphire To-dos - To-dos', 'sapphire-site-manager' ),
			'public'              => true,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'show_in_menu'        => 'sapphire-todos-settings',
			'show_in_nav_menus'   => false,
			'supports'            => array(
				'title',
				'editor',
				'thumbnail' => false,
				'revisions',
			),
			'taxonomies'          => array(
				'sapphire_todo_status',
				'sapphire_todo_priority',
			),
			'can_export'          => true,
			'show_in_rest'        => true,
			'pages'               => false,
			'has_archive'         => false,
		);

		register_post_type( 'sapphire_sm_todo', $todo_args );
	}

	/**
	 * Register custom taxomony for todo statuses.
	 *
	 * Not publicly visible
	 *
	 * @since 1.0.0
	 * @uses  register_taxonomy()
	 */
	public static function create_todo_taxonomies(): void {
		$todo_status_labels = array(
			'name'                       => _x( 'Status', 'Taxonomy General Name', 'sapphire-site-manager' ),
			'singular_name'              => _x( 'Status', 'Taxonomy Singular Name', 'sapphire-site-manager' ),
			'menu_name'                  => __( 'Status', 'sapphire-site-manager' ),
			'all_items'                  => __( 'All Statuses', 'sapphire-site-manager' ),
			'parent_item'                => __( 'Parent Status', 'sapphire-site-manager' ),
			'parent_item_colon'          => __( 'Parent Status:', 'sapphire-site-manager' ),
			'new_item_name'              => __( 'New Status Name', 'sapphire-site-manager' ),
			'add_new_item'               => __( 'Add New Status', 'sapphire-site-manager' ),
			'edit_item'                  => __( 'Edit Status', 'sapphire-site-manager' ),
			'update_item'                => __( 'Update Status', 'sapphire-site-manager' ),
			'view_item'                  => __( 'View Status', 'sapphire-site-manager' ),
			'separate_items_with_commas' => __( 'Separate Statuses with commas', 'sapphire-site-manager' ),
			'add_or_remove_items'        => __( 'Add or remove Status', 'sapphire-site-manager' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'sapphire-site-manager' ),
			'popular_items'              => __( 'Popular Items', 'sapphire-site-manager' ),
			'search_items'               => __( 'Search Statuses', 'sapphire-site-manager' ),
			'not_found'                  => __( 'Not Found', 'sapphire-site-manager' ),
			'no_terms'                   => __( 'No Statuses', 'sapphire-site-manager' ),
			'items_list'                 => __( 'Status list', 'sapphire-site-manager' ),
			'items_list_navigation'      => __( 'Statuses list navigation', 'sapphire-site-manager' ),
		);
		$todo_status_args   = array(
			'labels'             => $todo_status_labels,
			'hierarchical'       => true,
			'public'             => false,
			'show_ui'            => true,
			'show_admin_column'  => true,
			'show_in_nav_menus'  => false,
			'query_var'          => true,
			'show_in_rest'       => true,
			'show_in_quick_edit' => false,
			'meta_box_cb'        => false,
		);
		register_taxonomy( 'sapphire_todo_status', array( 'sapphire_sm_todo' ), $todo_status_args );

		$terms = array(
			'In Progress',
			'Dependency',
			'Completed',
		);

		foreach ( $terms as $term ) {
			wp_insert_term( $term, 'sapphire_todo_status' );
		}

		$todo_priority_labels = array(
			'name'                       => _x( 'Priority', 'Taxonomy General Name', 'sapphire-site-manager' ),
			'singular_name'              => _x( 'Priority', 'Taxonomy Singular Name', 'sapphire-site-manager' ),
			'menu_name'                  => __( 'Priority', 'sapphire-site-manager' ),
			'all_items'                  => __( 'All Priorities', 'sapphire-site-manager' ),
			'parent_item'                => __( 'Parent Priority', 'sapphire-site-manager' ),
			'parent_item_colon'          => __( 'Parent Priority:', 'sapphire-site-manager' ),
			'new_item_name'              => __( 'New Priority Name', 'sapphire-site-manager' ),
			'add_new_item'               => __( 'Add New Priority', 'sapphire-site-manager' ),
			'edit_item'                  => __( 'Edit Priority', 'sapphire-site-manager' ),
			'update_item'                => __( 'Update Priority', 'sapphire-site-manager' ),
			'view_item'                  => __( 'View Priority', 'sapphire-site-manager' ),
			'separate_items_with_commas' => __( 'Separate Priorities with commas', 'sapphire-site-manager' ),
			'add_or_remove_items'        => __( 'Add or remove Priority', 'sapphire-site-manager' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'sapphire-site-manager' ),
			'popular_items'              => __( 'Popular Items', 'sapphire-site-manager' ),
			'search_items'               => __( 'Search Priorities', 'sapphire-site-manager' ),
			'not_found'                  => __( 'Not Found', 'sapphire-site-manager' ),
			'no_terms'                   => __( 'No Priorities', 'sapphire-site-manager' ),
			'items_list'                 => __( 'Priority list', 'sapphire-site-manager' ),
			'items_list_navigation'      => __( 'Priorities list navigation', 'sapphire-site-manager' ),
		);

		$todo_priority_args = array(
			'labels'            => $todo_priority_labels,
			'hierarchical'      => true,
			'public'            => false,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => false,
			'query_var'         => true,
			'show_in_rest'      => true,
		);

		register_taxonomy( 'sapphire_todo_priority', array( 'sapphire_sm_todo' ), $todo_priority_args );

		$terms = array(
			'Low',
			'Medium',
			'High',
			'ASAP',
			'High',
		);

		foreach ( $terms as $term ) {
			wp_insert_term( $term, 'sapphire_todo_priority' );
		}
	}//end create_todo_taxonomies()

	/**
	 * Add AdminFacing Page Menu Page
	 *
	 * @since 1.0.0
	 */
	public function add_admin_menu(): void {
		add_menu_page(
			esc_html__( 'Sapphire Site Manager', 'sapphire-site-manager' ),
			esc_html__( 'Sapphire Site Manager', 'sapphire-site-manager' ),
			'manage_options',
			$this->plugin_name,
			array(
				$this,
				'add_root_div',
			),
			'dashicons-smiley',
			null
		);
	}

	/**
	 * Add Root Div For React.
	 *
	 * @since 1.0.0
	 */
	public function add_root_div(): void {
		echo '<div id="' . esc_html( $this->plugin_name ) . '"></div>';
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_styles() {
		$version = $this->version;

		// Only run if is on a Sapphire Site Manager parent page.
		$screen              = get_current_screen();
		$admin_scripts_bases = array( 'toplevel_page_' . $this->plugin_name );
		if ( ! ( isset( $screen->base ) && in_array( $screen->base, $admin_scripts_bases, true ) ) ) {
			return;
		}

		wp_enqueue_style(
			$this->plugin_name . '-style',
			SAPPHIRE_SITE_MANAGER_URL . 'build/admin/Main.css',
			array( 'wp-components' ),
			$version
		);
	}//end enqueue_styles()

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_scripts() {
		// Only run if is on a Sapphire Site Manager parent page.
		$screen              = get_current_screen();
		$admin_scripts_bases = array( 'toplevel_page_' . $this->plugin_name );
		if ( ! ( isset( $screen->base ) && in_array( $screen->base, $admin_scripts_bases, true ) ) ) {
			return;
		}

		// Backbone JS Client - https://developer.wordpress.org/rest-api/using-the-rest-api/backbone-javascript-client/
		// wp_enqueue_script( 'wp-api' );
		// Scripts dependency files gets auto generated.
		$deps_file = SAPPHIRE_SITE_MANAGER_PATH . 'build/admin/Main.asset.php';

		// Fallback dependency array.
		$dependency = array();
		$version    = $this->version;

		// Set dependency and version gets auto generated from js and built to build/admin/Main.asset.php.
		if ( file_exists( $deps_file ) === true ) {
			$deps_file  = include $deps_file;
			$dependency = $deps_file['dependencies'];
			$version    = $deps_file['version'];
		}

		wp_enqueue_script(
			$this->plugin_name,
			SAPPHIRE_SITE_MANAGER_URL . 'build/admin/Main.js',
			$dependency,
			$version,
			true
		);

		// Used to grab root id for render of page.
		$localize = array(
			'version' => $this->version,
			'root_id' => $this->plugin_name,
		);
		wp_set_script_translations( $this->plugin_name, $this->plugin_name );
		wp_localize_script( $this->plugin_name, 'sapphireSiteManager', $localize );
	}//end enqueue_scripts()
}//end class
