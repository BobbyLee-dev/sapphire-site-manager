<?php
declare( strict_types=1 );

namespace SapphireSiteManager\CPT;

use SapphireSiteManager\Traits\PluginDirectoryPathTrait;
use SapphireSiteManager\Traits\PluginDirectoryUrlTrait;

/**
 * Register CPTs for the plugin
 */
class RegisterCPTs {
	use PluginDirectoryUrlTrait;
	use PluginDirectoryPathTrait;

	/**
	 * Array for CPTs
	 *
	 * @var CPTInterface[] $cpts
	 */
	private array $cpts = [];

	/**
	 * Initialize the class and set its properties.
	 */
	public function __construct() {
		$this->register_cpts();
	}

	/**
	 * Registers all the CPTs that implement CPTInterface
	 *
	 * @return void
	 */
	public function register_cpts(): void {
		add_action(
			'init',
			function () {
				foreach ( glob( __DIR__ . DIRECTORY_SEPARATOR . 'CPTs' . DIRECTORY_SEPARATOR . '*.php' ) as $path ) {
					if ( ! str_contains( $path, 'index.php' ) ) {
						$cpt_name = 'SapphireSiteManager\CPT\CPTs\\' . wp_basename( $path, '.php' );
						if ( class_exists( $cpt_name ) ) {
							$create_cpt = new $cpt_name();
							register_post_type( $create_cpt->slug(), $this->prep_args( $create_cpt ) );
						}
					}
				}
			}
		);
	}

	/**
	 * Organizes and checks the CPT args
	 *
	 * @param CPTInterface $cpt Custom Post Type.
	 *
	 * @return array
	 */
	private function prep_args( CPTInterface $cpt ): array {
		$args = $cpt->args();

		if ( ! empty( $cpt->labels() ) ) {
			$args['labels'] = $cpt->labels();

			return $args;
		}

		return $args;
	}
}
