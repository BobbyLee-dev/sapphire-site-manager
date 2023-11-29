<?php

namespace SapphireSiteManager\AdminFacing\Helpers;

use SapphireSiteManager\Traits\PluginSlugTrait;

/**
 * Hide admin notices.
 */
class HideAdminNotices implements HelpersInterface {
	use PluginSlugTrait;

	/**
	 * Hook to use for finding admin notices.
	 *
	 * @var string
	 */
	private string $hook;

	/**
	 * Slug of the admin screen to remove notices on.
	 *
	 * @var string
	 */
	private string $admin_screen;

	/**
	 * Setup class properties.
	 */
	public function __construct() {
		$this->hook         = 'admin_notices';
		$this->admin_screen = 'toplevel_page_' . $this->plugin_slug();
	}

	/**
	 * Find and hide admin notices on the plugin admin page.
	 *
	 * @return void
	 */
	public function run(): void {

		add_action(
			'admin_head',
			function () {
				if ( get_current_screen()?->base !== $this->admin_screen ) {
					return;
				}

				global $wp_filter;

				$admin_notice_callbacks = $wp_filter[ $this->hook ]?->callbacks;

				if ( $admin_notice_callbacks ) {
					foreach ( $admin_notice_callbacks as $priority => $notice ) {
						foreach ( $notice as $name => $callback ) {
							remove_action( $this->hook, $name, $priority );
						}
					}
				}
			}
		);
	}
}
