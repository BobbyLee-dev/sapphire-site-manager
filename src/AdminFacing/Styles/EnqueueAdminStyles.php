<?php
declare( strict_types=1 );

namespace SapphireSiteManager\AdminFacing\Styles;

use SapphireSiteManager\Traits\{PluginDirectoryUrlTrait, PluginSlugTrait, PluginVersionTrait};

/**
 * Register the stylesheets for the adminFacing area.
 *
 * @since 1.0.0
 */
class EnqueueAdminStyles {
	use PluginSlugTrait;
	use PluginVersionTrait;
	use PluginDirectoryUrlTrait;

	/**
	 * Setup action to enqueue the admin styles.
	 */
	public function run(): void {
		add_action(
			'admin_enqueue_scripts',
			function () {
				$this->enqueue_admin_styles();
			}
		);
	}

	/**
	 * Register the stylesheets for the adminFacing area.
	 */
	public function enqueue_admin_styles(): void {
		foreach ( glob( dirname( __DIR__, 1 ) . DIRECTORY_SEPARATOR . 'Styles' . DIRECTORY_SEPARATOR . 'Style' . DIRECTORY_SEPARATOR . '*.php' ) as $path ) {
			$style_name = 'SapphireSiteManager\AdminFacing\Styles\Style\\' . wp_basename( $path, '.php' );
			if ( class_exists( $style_name ) ) {
				$create_style = new $style_name();
				if ( $create_style->conditionals() ) {
					wp_enqueue_style(
						$create_style->handle(),
						$create_style->src(),
						$create_style->dependencies(),
						$create_style->version(),
						$create_style->media()
					);
				}
			}
		}
	}
}
