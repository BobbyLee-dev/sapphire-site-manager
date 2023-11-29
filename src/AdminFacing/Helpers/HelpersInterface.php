<?php

namespace SapphireSiteManager\AdminFacing\Helpers;

/**
 * Interface for helpers so they can be run automatically.
 */
interface HelpersInterface {

	/**
	 * The method that will be called automaticlly within Helpers.
	 *
	 * @return void
	 */
	public function run(): void;
}
