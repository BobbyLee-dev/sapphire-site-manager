<?php
declare( strict_types=1 );

namespace SapphireSiteManager\CPT;

interface CPTInterface {
	/**
	 * CPT Slug.
	 *
	 * @return string
	 */
	public function slug(): string;

	/**
	 * Register_post_type $args
	 *
	 * @see https://developer.wordpress.org/reference/functions/register_post_type/
	 *
	 * @return (string|int|bool)[]
	 */
	public function args(): array;

	/**
	 * Register_post_type $args['labels'].
	 *
	 * @return string[]
	 */
	public function labels(): array;
}
