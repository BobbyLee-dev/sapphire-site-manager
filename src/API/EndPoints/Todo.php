<?php

namespace SapphireSiteManager\API\EndPoints;

use SapphireSiteManager\API\APIInterface;

class Todo implements APIInterface {

	/**
	 * @var string
	 */
	private string $route = '';

	/**
	 * Register the route and setup callback for a single todo.
	 * The route created is:
	 * wp-json/sapphire-site-manager/v1/todo/todoID
	 *
	 * @inheritDoc
	 */
	public function register_route(): void {
		register_rest_route(
			'sapphire-site-manager/v1',
			'/todo/(?P<id>[\d]+)',
			array(
				'methods'             => 'GET',
				'callback'            => array( __CLASS__, 'get_todo' ),
				'permission_callback' => '__return_true',
			)
		);
	}
}
