<?php

/**
 * API Endpoints and extensions for To-dos
 *
 * @since      1.0.0
 *
 * @package    Sapphire_Site_Manager
 * @subpackage Sapphire_Site_Manager/rest-api
 * @author     Bobby Lee <bobbylee.dev@gmail.com>
 */

class Sapphire_Site_Manager_Rest_Api {

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
    public static function ssm_todo_routes() {

        // all todos
        // wp-json/sapphire-site-manager/v1/todos
        register_rest_route( 'sapphire-site-manager/v1', '/todos', array(
            'methods'             => 'GET',
            'callback'            => array( __CLASS__, 'get_todos' ),
            'permission_callback' => '__return_true',
        ) );

        // single todo
        // wp-json/sapphire-site-manager/v1/todo/todoID
        register_rest_route( 'sapphire-site-manager/v1', '/todo/(?P<id>[\d]+)', array(
            'methods'             => 'GET',
            'callback'            => array( __CLASS__, 'get_todo' ),
            'permission_callback' => '__return_true',
        ) );
    }

    /**
     * Get all todos
     *
     * @return WP_Query
     * @since 1.0.0
     * @uses WP_Query
     */
    public static function get_todos() {
        $args = array(
            'post_type'      => 'sapphire_sm_todo',
            'posts_per_page' => - 1,
        );


        $query = new WP_Query( $args );

        foreach ( $query->posts as $todo ) {
            $todo->test        = 'lol';
            $status_terms      = wp_get_post_terms( $todo->ID, array( 'sapphire_todo_status' ) );
            $todo->status      = ! empty( $status_terms ) ? $status_terms[ 0 ]->slug : 'sapphire-todo-status-not-started';
            $todo->status_name = ! empty( $status_terms ) ? $status_terms[ 0 ]->name : 'Not Started';

        }

        wp_reset_postdata();

        return $query->posts;
    }

    /**
     * Get all single todo
     *
     * @return To-do post
     * @since 1.0.
     * @uses get_post()
     */
    public static function get_todo( $request ) {
        $post_id = $request[ 'id' ];
        if ( ! empty( $post_id ) ) {
            return get_post( $post_id );
        } else {
            return "Post not found";
        }
    }

}
