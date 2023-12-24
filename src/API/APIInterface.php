<?php

namespace SapphireSiteManager\API;

/**
 * Register and create custom APIs
 * Uses register_rest_route() - https://developer.wordpress.org/reference/functions/register_rest_route/
 */
interface APIInterface {


	/**
	 * Register the API route and setup callback.
	 *
	 * @return void
	 * @uses    register_rest_route()
	 */
	public function register_route(): void;

}
