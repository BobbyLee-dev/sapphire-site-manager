<?php
declare( strict_types=1 );

namespace SapphireSiteManager\Taxonomy;

use WP_Error;

/**
 * Register Taxonomies for the plugin
 */
class RegisterTaxonomies {
	/**
	 * Array for Taxonomies
	 *
	 * @var TaxonomyInterface[] $taxonomys
	 */
	private array $taxonomies = [];

	private array $prevent_term_creation = [];

	/**
	 * Initialize the class and set its properties.
	 */
	public function __construct() {
		$this->get_taxonomies();
		$this->register_taxonomies();
		$this->add_radio_box();
	}

	/**
	 * Get the Taxonomies
	 */
	public function get_taxonomies(): void {
		foreach ( glob( __DIR__ . DIRECTORY_SEPARATOR . 'Taxonomies' . DIRECTORY_SEPARATOR . '*.php' ) as $path ) {
			if ( ! str_contains( $path, 'index.php' ) ) {
				$taxonomy_name = 'SapphireSiteManager\Taxonomy\Taxonomies\\' . wp_basename( $path, '.php' );
				if ( class_exists( $taxonomy_name ) ) {
					$this->taxonomies[] = new $taxonomy_name();
				}
			}
		}
	}

	/**
	 * Registers the Taxonomies
	 *
	 * @return void
	 */
	public function register_taxonomies(): void {
		add_action(
			'init',
			function () {
				foreach ( $this->taxonomies as $single_taxonomy ) {

					$taxonomy_slug       = $single_taxonomy->slug();
					$default_terms       = $single_taxonomy->default_terms();
					$allow_term_creation = $single_taxonomy->allow_term_creation();

					if ( $allow_term_creation === false ) {
						$this->prevent_term_creation[] = [
							'taxonomy'      => $taxonomy_slug,
							'default_terms' => $default_terms
						];
					}

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
		);

		add_filter(
			'pre_insert_term',
			function ( $term, $taxonomy ) {

				foreach ( $this->prevent_term_creation as $tax_array ) {
					if ( $tax_array['taxonomy'] === $taxonomy && ! in_array( $term, $tax_array['default_terms'] ) ) {
						return new WP_Error( 'term_not_allowed', __( 'Sorry, you can only use predefined terms for this taxonomy.' ) );
					}
				}

				return $term;
			},
			10, 2
		);
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

	/**
	 * Add Radio Boxes
	 *
	 * @return void
	 */
	public function add_radio_box(): void {
		add_action(
			'rest_prepare_taxonomy',
			function ( $response, $taxonomy, $request ) {
				foreach ( $this->taxonomies as $single_taxonomy ) {
					$taxonomy_slug     = $single_taxonomy->slug();
					$use_radio_buttons = $single_taxonomy->use_radio_buttons();
					$default_term      = $single_taxonomy->default_selected_term();

					if ( $use_radio_buttons ) {
						$create_taxonomy_radio_buttons = new TaxonomyRadioBox( $taxonomy_slug, $single_taxonomy->associated_post_types(), $default_term );
						$create_taxonomy_radio_buttons->add_radio_box();
					}
				}

				return $response;
			},
			10, 3
		);
	}
}
