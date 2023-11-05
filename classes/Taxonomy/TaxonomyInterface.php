<?php
declare( strict_types=1 );

namespace SapphireSiteManager\Taxonomy;

/**
 * Register the Status taxonomy used in the To-do CPT.
 */
interface TaxonomyInterface {
	/**
	 * Taxonomy Slug.
	 *
	 * @return string
	 */
	public function slug(): string;

	/**
	 * Object Type or array of object types with which the taxonomy should
	 * be associated. What post types will it be used in.
	 *
	 * @return array
	 */
	public function associated_post_types(): array;

	/**
	 * Default terms for the Taxonomy.
	 *
	 * @return array
	 */
	public function default_terms(): array;

	/**
	 * Default selected term for the Taxonomy.
	 * Must not match any default terms.
	 *
	 * @return string
	 */
	public function default_selected_term(): string;

	/**
	 * If the Taxonomy will be radio buttons.
	 *
	 * @return bool
	 */
	public function use_radio_buttons(): bool;

	/**
	 * For register_taxonomy $args
	 *
	 * @see https://developer.wordpress.org/reference/functions/register_taxonomy/
	 *
	 * @return array
	 */
	public function args(): array;

	/**
	 * For register_taxonomy $args['labels'].
	 *
	 * @return array
	 */
	public function labels(): array;
}
