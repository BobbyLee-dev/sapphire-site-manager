<?php
declare( strict_types=1 );

namespace SapphireSiteManager\CPTs;

/**
 * Register CPTs for the plugin
 */
class RegisterCPT {
	/**
	 * Array for CPTs
	 *
	 * @var CPTInterface[] $cpts
	 */
	private array $cpts = [];

	/**
	 * Add new CPT
	 *
	 * @param CPTInterface $cpt CPT that implements CPTInterface.
	 *
	 * @return RegisterCPT $this
	 */
	public function add( CPTInterface $cpt ): RegisterCPT {
		$this->cpts[] = $cpt;

		return $this;
	}

	/**
	 * Registers all the CPTs that implement CPTInterface
	 *
	 * @return void
	 */
	public function register(): void {
		foreach ( $this->cpts as $single_cpt ) {
			register_post_type(
				$single_cpt->slug(),
				$this->prep_args( $single_cpt )
			);
		}
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
