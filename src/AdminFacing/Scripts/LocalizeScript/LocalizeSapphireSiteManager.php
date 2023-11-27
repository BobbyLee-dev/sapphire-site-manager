<?php

namespace SapphireSiteManager\AdminFacing\Scripts\LocalizeScript;

use SapphireSiteManager\AdminFacing\Scripts\LocalizeScriptInterface;
use SapphireSiteManager\Traits\PluginDirectoryPathTrait;
use SapphireSiteManager\Traits\PluginDirectoryUrlTrait;
use SapphireSiteManager\Traits\PluginSlugTrait;
use SapphireSiteManager\Traits\PluginVersionTrait;

/**
 * Localize/add plugin data for the adminFacing area.
 */
class LocalizeSapphireSiteManager implements LocalizeScriptInterface {
	use PluginSlugTrait;
	use PluginVersionTrait;
	use PluginDirectoryUrlTrait;
	use PluginDirectoryPathTrait;


	/**
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
	public function object_name(): string {
		return 'sapphireSiteManager';
	}

	/**
	 * @inheritDoc
	 */
	public function l10n_data(): array {
		return array(
			'version' => $this->plugin_version(),
			'root_id' => $this->plugin_slug(),
		);
	}

}
