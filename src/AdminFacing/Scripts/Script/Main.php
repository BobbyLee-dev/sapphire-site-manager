<?php

namespace SapphireSiteManager\AdminFacing\Scripts\Script;

use SapphireSiteManager\AdminFacing\Scripts\ScriptInterface;
use SapphireSiteManager\Traits\PluginDirectoryPathTrait;
use SapphireSiteManager\Traits\PluginDirectoryUrlTrait;
use SapphireSiteManager\Traits\PluginSlugTrait;
use SapphireSiteManager\Traits\PluginVersionTrait;

/**
 * Register the main script for the adminFacing area.
 * /build/Dashboard/Main.js
 */
class Main implements ScriptInterface {
	use PluginSlugTrait;
	use PluginVersionTrait;
	use PluginDirectoryUrlTrait;
	use PluginDirectoryPathTrait;

	private string $dependencies_file;

	/**
	 */
	private array $dependencies;

	public function __construct() {
		$this->dependencies_file = $this->my_plugin_dir_path() . 'build/Dashboard/Main.asset.php';

		if ( file_exists( $this->dependencies_file ) === true ) {
			$this->dependencies = include $this->dependencies_file;
		} else {
			$this->dependencies = array();
		}

	}

	/**
	 * Only run if is on a Sapphire Site Manager parent page.
	 *
	 * @inheritDoc
	 */
	public function conditionals(): bool {
		$screen              = get_current_screen();
		$admin_scripts_bases = array( 'toplevel_page_' . $this->plugin_slug() );
		if ( ! ( isset( $screen->base ) && in_array( $screen->base, $admin_scripts_bases, true ) ) ) {
			return false;
		}

		return true;
	}

	/**
	 * @inheritDoc
	 */
	public function handle(): string {
		return $this->plugin_slug();
	}

	/**
	 * @inheritDoc
	 */
	public function src(): string {
		return $this->my_plugin_dir_url() . 'build/Dashboard/Main.js';
	}

	/**
	 * Get the dependencies from build/Dashboard/Main.asset.php
	 *
	 * @inheritDoc
	 */
	public function dependencies(): array {
		$dependency = array();

		if ( isset( $this->dependencies['dependencies'] ) ) {
			$dependency = $this->dependencies['dependencies'];
		}

		return $dependency;
	}

	/**
	 * @inheritDoc
	 */
	public function version(): string {
		$version = $this->plugin_version();

		if ( isset( $this->dependencies['version'] ) ) {
			$version = $this->dependencies['version'];
		}

		return $version;
	}

	/**
	 * @inheritDoc
	 */
	public function args(): array {
		return [ 'in_footer' => 'true' ];
	}
}
