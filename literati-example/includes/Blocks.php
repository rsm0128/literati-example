<?php
/**
 * Block class file.
 *
 * @package Literati\Example
 */

namespace Literati\Example;

/**
 * Blocks class.
 */
class Blocks {
	/**
	 * Init
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'register_blocks' ) );
	}

	/**
	 * Register the Blocks
	 */
	public static function register_blocks() {
		// Register the Carousel.
		register_block_type( LITERATI_EXAMPLE_ABSPATH . 'blocks/carousel/build' );
	}
}
