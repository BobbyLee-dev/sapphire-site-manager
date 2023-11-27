<?php

namespace SapphireSiteManager\AdminFacing\Styles\Style;

use SapphireSiteManager\AdminFacing\Styles\StyleInterface;
use SapphireSiteManager\Traits\PluginDirectoryUrlTrait;
use SapphireSiteManager\Traits\PluginSlugTrait;
use SapphireSiteManager\Traits\PluginVersionTrait;

/**
 * Register the main stylesheet for the adminFacing area.
 * /build/adminFacing/Main.css
 */
class MainStyle implements StyleInterface {
	use PluginSlugTrait;
	use PluginVersionTrait;
	use PluginDirectoryUrlTrait;

	/**
	 * @inheritDoc
	 *
	 * Only run if logged in.
	 */
	public function conditionals(): bool {

		if ( ! is_user_logged_in() ) {
			return false;
		}

		return true;
	}

	/**
	 * @inheritDoc
	 */
	public function handle(): string {
		return $this->plugin_slug() . '-style';
	}

	/**
	 * @inheritDoc
	 */
	public function src(): string {
		return $this->my_plugin_dir_url() . 'build/adminFacing/Main.css';
	}

	/**
	 * @inheritDoc
	 */
	public function dependencies(): array {
		return array( 'wp-components' );
	}

	/**
	 * @inheritDoc
	 */
	public function version(): string {
		return $this->plugin_version();
	}

	/**
	 * @inheritDoc
	 */
	public function media(): string {
		return 'all';
	}
}
