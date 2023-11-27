<?php

namespace SapphireSiteManager\AdminFacing\Scripts;

interface ScriptInterface {

	/**
	 * Add any needed conditionals needed to run the script.
	 *
	 * @return bool
	 */
	public function conditionals(): bool;

	/**
	 * Script handle.
	 *
	 * @see https://developer.wordpress.org/reference/functions/wp_enqueue_script/
	 * @return string
	 */
	public function handle(): string;

	/**
	 * Script src.
	 *
	 * @see https://developer.wordpress.org/reference/functions/wp_enqueue_script/
	 * @return string
	 */
	public function src(): string;

	/**
	 * Script dependencies.
	 *
	 * @see https://developer.wordpress.org/reference/functions/wp_enqueue_script/
	 * @return string[]
	 */
	public function dependencies(): array;

	/**
	 * Script version
	 *
	 * @see https://developer.wordpress.org/reference/functions/wp_enqueue_script/
	 * @return string
	 */
	public function version(): string;

	/**
	 * Script args.
	 * Strategy, in_footer
	 *
	 * @see https://developer.wordpress.org/reference/functions/wp_enqueue_script/
	 * @return string[]
	 */
	public function args(): array;
}
