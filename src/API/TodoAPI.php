<?php
declare( strict_types=1 );

namespace SapphireSiteManager\API;

use SapphireSiteManager\API\EndPoints\TodoStatuses;
use stdClass;
use WP_Post;
use WP_Query;
use WP_REST_Request;

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

	private $statuses = [];
	private $rest_api_statuses = [];

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->statuses = get_terms(
			array(
				'taxonomy'   => 'sapphire_todo_status',
				'hide_empty' => false,
				'orderby'    => 'term_order',
			)
		);
		$this->prepare_rest_api_statuses();

		$this->register_todo_endpoints();
	}

	public function prepare_rest_api_statuses() {
		foreach ( $this->statuses as $status ) {
			$status_to_prepare         = $status;
			$status_to_prepare->bobby  = 'bobby yo';
			$this->rest_api_statuses[] = $status_to_prepare;
		}
	}

	/**
	 * Custom routes for to-dos
	 *
	 * @since    1.0.0
	 * @uses    register_rest_route()
	 */
	public function register_todo_endpoints(): void {
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
	 * @return array
	 * @since 1.0.0
	 * @uses WP_Query
	 */
	public static function get_todos(): array {
		$args = array(
			'post_type'      => 'sapphire-sm-todo',
			'posts_per_page' => - 1,
			'order'          => 'ASC',
			//'post_status'    => array(
			//	'publish',
			//	'pending',
			//	'draft',
			//	'private',
			//	'inherit',
			//),
		);

		$query = new WP_Query( $args );

		$todos_array = [];
		foreach ( $query->posts as $todo ) {

			$todo_properties = new stdClass();
			if ( $todo instanceof WP_Post ) {
				$todos_properties = get_object_vars( $todo );
				foreach ( $todos_properties as $property => $value ) {
					$todo_properties->$property = $value;
				}
			}

			$status_terms                   = wp_get_post_terms( $todo->ID, array( 'sapphire_todo_status' ) );
			$priority_terms                 = wp_get_post_terms( $todo->ID, array( 'sapphire_todo_priority' ) );
			$todo_properties->status        = ! empty( $status_terms ) ? $status_terms[0]->slug : 'not-started';
			$todo_properties->status_name   = ! empty( $status_terms ) ? $status_terms[0]->name : 'Not Started';
			$todo_properties->priority      = ! empty( $priority_terms ) ? $priority_terms[0]->slug : 'not-set';
			$todo_properties->priority_name = ! empty( $priority_terms ) ? $priority_terms[0]->name : 'Not Set';

			$todos_array[] = $todo_properties;
		}

		wp_reset_postdata();

		return array(
			'all_todos'  => $todos_array,
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
		);
	}

	/**
	 * Get single todo
	 *
	 * @param WP_REST_Request $request // Incoming request.
	 *
	 * @returns Object
	 * @uses get_post()
	 * @since 1.0.
	 */
	public static function get_todo( WP_REST_Request $request ): object {
		$post_id = $request['id'];
		if ( ! empty( $post_id ) ) {
			$single_todo            = get_post( $post_id );
			$single_todo_properties = new stdClass();
			if ( $single_todo instanceof WP_Post ) {
				$todos_properties = get_object_vars( $single_todo );
				foreach ( $todos_properties as $property => $value ) {
					$single_todo_properties->$property = $value;
				}
			}

			$single_status_terms                         = wp_get_post_terms( $single_todo->ID, array( 'sapphire_todo_status' ) );
			$single_priority_terms                       = wp_get_post_terms( $single_todo->ID, array( 'sapphire_todo_priority' ) );
			$single_todo_properties->status              = ! empty( $single_status_terms ) ? $single_status_terms[0]->slug : 'not-started';
			$single_todo_properties->status_name         = ! empty( $single_status_terms ) ? $single_status_terms[0]->name : 'Not Started';
			$single_todo_properties->priority            = ! empty( $single_priority_terms ) ? $single_priority_terms[0]->slug : 'not-set';
			$single_todo_properties->priority_name       = ! empty( $single_priority_terms ) ? $single_priority_terms[0]->name : 'Not Set';
			$single_todo_properties->author_display_name = get_the_author_meta( 'display_name', $single_todo->post_author );
			$single_todo_properties->author_avatar_url   = get_avatar( $single_todo->post_author, 100, '', '', array( 'force_default' => true, 'default' => 'mystery' ) );
			$prep_statuses                               = new TodoStatuses();
			$statuses                                    = $prep_statuses->get_statuses();


			$single_todo_properties->statuses = $statuses;
			$single_todo_properties->priority = get_terms(
				array(
					'taxonomy'   => 'sapphire_todo_status',
					'hide_empty' => false,
					'orderby'    => 'term_order',
				)
			);


			return $single_todo_properties;


		} else {
			return 'Post not found';
		}
	}
}
