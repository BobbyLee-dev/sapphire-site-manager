<?php
declare( strict_types=1 );

namespace SapphireSiteManager;

use WP_Query;

/**
 * API Endpoints and extensions for To-dos
 *
 * @since      1.0.0
 *
 * @package    Sapphire_Site_Manager
 * @subpackage Sapphire_Site_Manager/rest-api
 * @author     Bobby Lee <bobbylee.dev@gmail.com>
 */
class Api {

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
	 * Custom routes for to-dos
	 *
	 * @since    1.0.0
	 * @uses    register_rest_route()
	 */
	public static function ssm_todo_routes(): void {
		// all todos
		// wp-json/sapphire-site-manager/v1/todos.
		register_rest_route(
			'sapphire-site-manager/v1',
			'/todos',
			array(
				'methods'             => 'GET',
				'callback'            => array( __CLASS__, 'get_todos' ),
				'permission_callback' => '__return_true',
			)
		);

		// single todo
		// wp-json/sapphire-site-manager/v1/todo/todoID.
		register_rest_route(
			'sapphire-site-manager/v1',
			'/todo/(?P<id>[\d]+)',
			array(
				'methods'             => 'GET',
				'callback'            => array( __CLASS__, 'get_todo' ),
				'permission_callback' => '__return_true',
			)
		);
	}

	/**
	 * Get all todos
	 *
	 * @return WP_Query
	 * @since 1.0.0
	 * @uses WP_Query
	 */
	public static function get_todos(): array {
		$args = array(
			'post_type'      => 'sapphire_sm_todo',
			'posts_per_page' => - 1,
			'order'          => 'ASC',
			'post_status'    => array(
				'publish',
				'pending',
				'draft',
				'private',
				'inherit',
			),
		);

		$query = new \WP_Query( $args );

		foreach ( $query->posts as $todo ) {
			$status_terms        = wp_get_post_terms( $todo->ID, array( 'sapphire_todo_status' ) );
			$priority_terms      = wp_get_post_terms( $todo->ID, array( 'sapphire_todo_priority' ) );
			$todo->status        = ! empty( $status_terms ) ? $status_terms[0]->slug : 'not-started';
			$todo->status_name   = ! empty( $status_terms ) ? $status_terms[0]->name : 'Not Started';
			$todo->priority      = ! empty( $priority_terms ) ? $priority_terms[0]->slug : 'not-set';
			$todo->priority_name = ! empty( $priority_terms ) ? $priority_terms[0]->name : 'Not Set';
		}

		wp_reset_postdata();

		return array(
			'statuses'   => get_terms(
				array(
					'taxonomy'   => 'sapphire_todo_status',
					'hide_empty' => false,
					'orderby'    => 'term_order',
				)
			),
			'priorities' => get_terms(
				array(
					'taxonomy'   => 'sapphire_todo_status',
					'hide_empty' => false,
					'orderby'    => 'term_order',
				)
			),
			'all_todos'  => $query->posts,
		);
	}

	/**
	 * Get single todo
	 *
	 * @param array $request // Incoming request.
	 *
	 * @returns \WP_Post|string
	 * @uses get_post()
	 * @since 1.0.
	 */
	public static function get_todo( array $request ): \WP_Post|string {
		$post_id = $request['id'];
		if ( ! empty( $post_id ) ) {
			$todo = get_post( $post_id );

			return $todo;
		} else {
			return 'Post not found';
		}
	}
}
