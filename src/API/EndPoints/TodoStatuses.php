<?php
declare( strict_types=1 );

namespace SapphireSiteManager\API\EndPoints;

use WP_Error;
use WP_Term;

/**
 * Setup and get Todo Statuses.
 */
class TodoStatuses {

	private $status_icon = '';


	/**
	 * Get todo statuses.
	 *
	 * @return WP_Term|int[]|string[]|WP_Error
	 */
	public function get_statuses(): WP_Term|WP_Error|array {
		$statuses = get_terms(
			array(
				'taxonomy'   => 'sapphire_todo_status',
				'hide_empty' => false,
				'orderby'    => 'term_order',
			)
		);

		if ( is_array( $statuses ) ) {
			foreach ( $statuses as $status ) {
				$status->lol = 'lol hi';
			}
		} else {
			$statuses = [];
		}

		return $statuses;
	}
}
