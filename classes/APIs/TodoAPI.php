<?php
declare( strict_types=1 );

namespace SapphireSiteManager\APIs;

use WP_Query;

/**
 * API Endpoints for To-dos
 *
 * @since      1.0.0
 *
 * @package    Sapphire_Site_Manager
 * @subpackage Sapphire_Site_Manager/rest-api
 * @author     Bobby Lee <bobbylee.dev@gmail.com>
 */
class TodoAPI {
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		$this->register_todo_endpoints();
	}

	/**
	 * Custom routes for to-dos
	 *
	 * @since    1.0.0
	 * @uses    register_rest_route()
	 */
	public static function register_todo_endpoints(): void {
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
			'post_type'      => 'sapphire-sm-todo',
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
	 * @param \WP_REST_Request $request // Incoming request.
	 *
	 * @returns \WP_Post|string
	 * @uses get_post()
	 * @since 1.0.
	 */
	public static function get_todo( \WP_REST_Request $request ): \WP_Post|string {
		$post_id = $request['id'];
		if ( ! empty( $post_id ) ) {
			$todo = get_post( $post_id );

			return $todo;
		} else {
			return 'Post not found';
		}
	}
}