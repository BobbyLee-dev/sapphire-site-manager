<?php
declare( strict_types=1 );

namespace SapphireSiteManager\Taxonomy;

/**
 * Creates Taxonomy and converts to radio box
 */
class TaxonomyRadioBox {

	/**
	 * The post types that the plugin will use.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var array $post_types
	 */
	public array $post_types;

	/**
	 * The slug for a Taxonomy.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var string $slug
	 */
	public string $slug = '';

	/**
	 * The Taxonomy object.
	 *
	 * @var object $taxonomy
	 */
	public object $taxonomy;

	/**
	 * The new metabox title.
	 *
	 * @var string $metabox_title
	 */
	public string $metabox_title = '';

	/**
	 * Metabox priority. (vertical placement).
	 *
	 * 'high', 'core', 'default' or 'low'
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var string $priority
	 */
	public string $priority = 'high';

	/**
	 * Metabox position. (column placement).
	 *
	 * 'normal', 'advanced', or 'side'
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var string $context
	 */
	public string $context = 'side';

	/**
	 * Set to true to hide "None" option & force a term selection.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var bool $force_selection
	 */
	public bool $force_selection = false;

	/**
	 * Set to default selection for radio box.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var string $default_selection
	 */
	public string $default_selection = '';

	/**
	 * Defines custom taxonomies.
	 *
	 * @param string $tax_slug Taxonomy slug.
	 * @param array $post_types post-types to display custom metabox.
	 * @param string $default_selection the default radio box selection.
	 */
	public function __construct( string $tax_slug, array $post_types = array(), string $default_selection = '' ) {
		$this->slug              = $tax_slug;
		$this->post_types        = $post_types;
		$this->default_selection = $default_selection;
	}

	/**
	 * Removes and replaces the built-in taxonomy metabox with our own.
	 */
	public function add_radio_box(): void {
		foreach ( $this->post_types() as $key => $cpt ) {
			remove_meta_box( $this->slug . 'div', $cpt, 'side' );
			add_meta_box(
				$this->slug . '_radio',
				$this->metabox_title(),
				array(
					$this,
					'radio_box',
				),
				$cpt,
				$this->context,
				$this->priority
			);
		}
	}

	/**
	 * Gets the taxonomy's associated post_types
	 *
	 * @return array Taxonomy's associated post_types
	 */
	public function post_types() {
		$this->post_types = ! empty( $this->post_types ) ? $this->post_types : $this->taxonomy()->object_type;

		return $this->post_types;
	}

	/**
	 * Gets the taxonomy object from the slug
	 *
	 * @return object Taxonomy object
	 */
	public function taxonomy() {
		$this->taxonomy = ! empty( $this->taxonomy ) ? $this->taxonomy : get_taxonomy( $this->slug );

		return $this->taxonomy;
	}

	/**
	 * Gets the metabox title from the taxonomy object's labels (or uses the passed in title)
	 *
	 * @return string Metabox title
	 */
	public function metabox_title(): string {
		$this->metabox_title = ! empty( $this->metabox_title ) ? $this->metabox_title : $this->taxonomy()->labels->name;

		return $this->metabox_title;
	}

	/**
	 * Displays our taxonomy radio box metabox
	 */
	public function radio_box() {
		// uses same noncename as default box so no save_post hook needed.
		wp_nonce_field( 'taxonomy_' . $this->slug, 'taxonomy_noncename' );
		// get terms associated with this post.
		$names = wp_get_object_terms( get_the_ID(), $this->slug );
		// get all terms in this taxonomy.
		$terms = (array) get_terms(
			array(
				'taxonomy'   => $this->slug,
				'hide_empty' => false,
			)
		);
		// filter the ids out of the terms.
		$existing = ( ! is_wp_error( $names ) && ! empty( $names ) )
			? (array) wp_list_pluck( $names, 'term_id' )
			: array();
		// Check if taxonomy is hierarchical.
		// Terms are saved differently between types.
		$h = $this->taxonomy()->hierarchical;
		// default value.
		$default_val = $h ? 0 : '';
		// input name.
		$name = $h ? 'tax_input[' . $this->slug . '][]' : 'tax_input[' . $this->slug . ']';
		echo '<div style="margin-bottom: 5px;">
         <ul id="' . esc_html( $this->slug ) . '_taxradiolist" data-wp-lists="list:' . esc_html( $this->slug ) . '_tax" class="categorychecklist form-no-clear">';
		// If 'category,' force a selection, or force_selection is true.
		if ( $this->slug !== 'category' && ! $this->force_selection && $this->default_selection ) {
			// our radio for selecting none.
			echo '<li id="' . esc_html( $this->slug ) . '_tax-0"><label><input value="' . esc_html( $default_val ) . '" type="radio" name="' . esc_html( $name ) . '" id="in-' . esc_html( $this->slug ) . '_tax-0" ';
			checked( empty( $existing ) );
			echo '> ' . esc_html( $this->default_selection ) . '</label></li>';
		}
		// loop our terms and check if they're associated with this post.
		foreach ( $terms as $term ) {
			$val = $h ? $term->term_id : $term->slug;
			echo '<li id="' . esc_html( $this->slug ) . '_tax-' . esc_html( strval( $term->term_id ) ) . '"><label><input value="' . esc_html( $val ) . '" type="radio" name="' . esc_html( $name ) . '" id="in-' . esc_html( $this->slug ) . '_tax-' . esc_html( strval( $term->term_id ) ) . '" ';
			// if so, they get "checked".
			checked( ! empty( $existing ) && in_array( $term->term_id, $existing, true ) );
			echo '> ' . esc_html( $term->name ) . '</label></li>';
		}
		echo '</ul></div>';
	}
}
