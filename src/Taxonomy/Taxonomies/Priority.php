<?php
declare( strict_types=1 );

namespace SapphireSiteManager\Taxonomy\Taxonomies;

use SapphireSiteManager\Taxonomy\TaxonomyInterface;

/**
 * Register custom Taxonomy Priority for Todos.
 *
 * @since  1.0.0
 */
class Priority implements TaxonomyInterface {

	/**
	 * @inheritDoc
	 */
	public function slug(): string {
		return 'sapphire_todo_priority';
	}

	/**
	 * @inheritDoc
	 */
	public function associated_post_types(): array {
		return array( 'sapphire-sm-todo' );
	}

	/**
	 * @inheritDoc
	 */
	public function default_terms(): array {
		return array(
			'Low',
			'Medium',
			'High',
			'ASAP',
			'High',
		);
	}

	/**
	 * Default selected term for the Taxonomy.
	 * Must not match any default terms.
	 *
	 * @inheritDoc
	 */
	public function default_selected_term(): string {
		return 'Not Set';
	}

	/**
	 * @inheritDoc
	 */
	public function use_radio_buttons(): bool {
		return true;
	}

	/**
	 * @inheritDoc
	 */
	public function args(): array {
		return array(
			'hierarchical'      => true,
			'public'            => false,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => false,
			'query_var'         => true,
			'show_in_rest'      => true,
		);
	}

	/**
	 * @inheritDoc
	 */
	public function labels(): array {
		return array(
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
	}

	/**
	 * @inheritDoc
	 */
	public function allow_term_creation(): bool {
		return true;
	}
}
