<?php
declare( strict_types=1 );

namespace SapphireSiteManager\Taxonomies;

/**
 * Register Taxonomies for the plugin
 */
class RegisterTaxonomy {
	/**
	 * Array for Taxonomies
	 *
	 * @var TaxonomyInterface[] $taxonomys
	 */
	private array $taxonomies = [];

	/**
	 * Add new Taxonomy
	 *
	 * @param TaxonomyInterface $taxonomy - Taxonomy that implements TaxonomyInterface.
	 *
	 * @return RegisterTaxonomy $this
	 */
	public function add( TaxonomyInterface $taxonomy ): RegisterTaxonomy {
		$this->taxonomies[] = $taxonomy;

		return $this;
	}

	/**
	 * Registers the Taxonomies
	 *
	 * @return void
	 */
	public function register(): void {
		foreach ( $this->taxonomies as $single_taxonomy ) {
			$taxonomy_slug = $single_taxonomy->slug();
			$default_terms = $single_taxonomy->default_terms();
			register_taxonomy(
				$taxonomy_slug,
				$single_taxonomy->associated_post_types(),
				$this->prep_args( $single_taxonomy )
			);

			foreach ( $default_terms as $term ) {
				wp_insert_term( $term, $taxonomy_slug );
			}
		}
	}

	/**
	 * Add Radio Boxes
	 *
	 * @return void
	 */
	public function add_radio_box(): void {
		foreach ( $this->taxonomies as $single_taxonomy ) {
			$taxonomy_slug     = $single_taxonomy->slug();
			$use_radio_buttons = $single_taxonomy->use_radio_buttons();
			$default_term      = $single_taxonomy->default_selected_term();
			if ( $use_radio_buttons ) {
				$create_taxonomy_radio_buttons = new TaxonomyRadioBox( $taxonomy_slug, $single_taxonomy->associated_post_types(), $default_term );
				$create_taxonomy_radio_buttons->add_radio_box();
			}
		}
	}

	/**
	 * Organizes and checks the Taxonomy args
	 *
	 * @param TaxonomyInterface $taxonomy for single taxonomy.
	 *
	 * @return array
	 */
	private function prep_args( TaxonomyInterface $taxonomy ): array {
		$args = $taxonomy->args();

		if ( ! empty( $taxonomy->labels() ) ) {
			$args['labels'] = $taxonomy->labels();

			return $args;
		}

		return $args;
	}
}
