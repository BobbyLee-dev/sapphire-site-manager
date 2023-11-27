<?php

namespace SapphireSiteManager\AdminFacing\Scripts;

interface LocalizeScriptInterface {

	/**
	 * Add any needed conditionals needed to run the script.
	 *
	 * @return bool
	 */
	public function conditionals(): bool;

	/**
	 * Script handle.
	 *
	 * @see https://developer.wordpress.org/reference/functions/wp_localize_script/
	 * @return string
	 */
	public function handle(): string;

	/**
	 * Object name.
	 *
	 * @see https://developer.wordpress.org/reference/functions/wp_localize_script/
	 * @return string
	 */
	public function object_name(): string;

	/**
	 * The data - $l10n
	 *
	 * @see https://developer.wordpress.org/reference/functions/wp_localize_script/
	 * @return array<string, mixed>
	 */
	public function l10n_data(): array;

}
