<?php

namespace SapphireSiteManager\AdminFacing\Styles;

interface StyleInterface {

	/**
	 * Add any needed conditionals needed to run the style.
	 *
	 * @return bool
	 */
	public function conditionals(): bool;

	/**
	 * Style handle.
	 *
	 * @see https://developer.wordpress.org/reference/functions/wp_enqueue_style/
	 * @return string
	 */
	public function handle(): string;

	/**
	 * Style src.
	 *
	 * @see https://developer.wordpress.org/reference/functions/wp_enqueue_style/
	 * @return string
	 */
	public function src(): string;

	/**
	 * Style dependencies.
	 *
	 * @see https://developer.wordpress.org/reference/functions/wp_enqueue_style/
	 * @return string[]
	 */
	public function dependencies(): array;

	/**
	 * Style version
	 *
	 * @see https://developer.wordpress.org/reference/functions/wp_enqueue_style/
	 * @return string
	 */
	public function version(): string;

	/**
	 * Style media
	 * Accepts media types like 'all', 'print' and 'screen',
	 * or media queries like '(orientation: portrait)' and '(max-width: 640px)'.
	 *
	 * @see https://developer.wordpress.org/reference/functions/wp_enqueue_style/
	 * @return string
	 */
	public function media(): string;

}
