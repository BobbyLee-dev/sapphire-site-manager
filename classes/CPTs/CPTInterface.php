<?php
declare( strict_types=1 );

namespace SapphireSiteManager\CPTs;

interface CPTInterface {
	/**
	 * CPT Slug.
	 *
	 * @return string
	 */
	public function slug(): string;

	/**
	 * Optional: register_post_type $args
	 *
	 * @see https://developer.wordpress.org/reference/functions/register_post_type/
	 *
	 * @return array
	 */
	public function args(): array;

	/**
	 * Optional: register_post_type $args['labels']. If empty, will use name().
	 *
	 * @return array
	 */
	public function labels(): array;
}
