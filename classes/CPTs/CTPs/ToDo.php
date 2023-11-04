<?php
declare( strict_types=1 );

namespace SapphireSiteManager\CPTs\CTPs;

use SapphireSiteManager\CPTs\CPTInterface;

/**
 * Register custom post types for Todos.
 *
 * Does not create front end pages.
 *
 * @since  1.0.0
 */
class ToDo implements CPTInterface {
	/**
	 * @inheritDoc
	 */
	public function slug(): string {
		return 'sapphire-sm-todo';
	}

	/**
	 * @inheritDoc
	 */
	public function args(): array {
		return array(
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
	}

	/**
	 * @inheritDoc
	 */
	public function labels(): array {
		return array(
			'name'               => esc_html__( 'To-do', 'sapphire-site-manager' ),
			'singular_name'      => esc_html__( 'To-do', 'sapphire-site-manager' ),
			'archives'           => esc_html__( 'To-dos', 'sapphire-site-manager' ),
			'add_new'            => esc_html__( 'Add To-do', 'sapphire-site-manager' ),
			'add_new_item'       => esc_html__( 'Add To-do', 'sapphire-site-manager' ),
			'edit_item'          => esc_html__( 'Edit To-do', 'sapphire-site-manager' ),
			'new_item'           => esc_html__( 'New To-do', 'sapphire-site-manager' ),
			'view_item'          => esc_html__( 'View To-do', 'sapphire-site-manager' ),
			'search_items'       => esc_html__( 'Search To-dos', 'sapphire-site-manager' ),
			'not_found'          => esc_html__( 'No To-dos found', 'sapphire-site-manager' ),
			'not_found_in_trash' => esc_html__( 'No To-dos found in Trash', 'sapphire-site-manager' ),
		);
	}
}
