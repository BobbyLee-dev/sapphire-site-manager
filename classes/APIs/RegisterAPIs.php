<?php
declare( strict_types=1 );

namespace SapphireSiteManager\APIs;

use SapphireSiteManager\CPTs\CTPs\ToDo;
use SapphireSiteManager\CPTs\RegisterCPT;

/**
 * The main Plugin class.
 */
class RegisterAPIs {
	/**
	 * Register the APIs and endpoints for the plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		$this->define_todo_api();
	}

	/**
	 * Define the Custom Post Types for the plugin
	 *
	 * Uses the RegisterCPT class in order to create the CPTs.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_todo_api(): void {
		add_action(
			'rest_api_init',
			function () {
				new TodoAPI();
			}
		);
	}
}
