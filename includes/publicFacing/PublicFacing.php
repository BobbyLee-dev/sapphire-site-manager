<?php
declare( strict_types=1 );

namespace SapphireSiteManager\publicFacing;

/**
 * The publicFacing-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the publicFacing-facing stylesheet and JavaScript.
 *
 * @package    Sapphire_Site_Manager
 * @subpackage Sapphire_Site_Manager/publicFacing
 * @author     Bobby Lee <bobbylee.dev@gmail.com>
 */
class PublicFacing {

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
	 * @param string $plugin_name The name of the plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the publicFacing-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Sapphire_Site_Manager_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sapphire_Site_Manager_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/sapphire-site-manager-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the publicFacing-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Sapphire_Site_Manager_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sapphire_Site_Manager_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/sapphire-site-manager-public.js', array( 'jquery' ), $this->version, false );
	}
}
