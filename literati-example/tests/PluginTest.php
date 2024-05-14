<?php
/**
 * PlugTest class file.
 *
 * @package Literati\Example\Tests
 */

namespace Literati\Example\Tests;

use Literati\Example\Plugin;
use WP_Mock\Tools\TestCase as TestCase;
use WP_Mock;

/**
 * PluginTest class definition.
 */
final class PluginTest extends TestCase {
	public function setUp(): void {
		WP_Mock::setUp();

		/** Setup mocks */
		WP_Mock::userFunction(
			'get_option',
			array(
				'return' => function ( $key ) {
					switch ( $key ) {
						case 'LITERATI_EXAMPLE_VERSION':
							return null;
					}
				},
			)
		);

		WP_Mock::userFunction(
			'remove_action',
			array(
				'return' => true,
			)
		);

		WP_Mock::userFunction(
			'has_action',
			array(
				'return' => true,
			)
		);

		WP_Mock::userFunction(
			'plugin_dir_path',
			array(
				'return' => function ( $dir ) {
					return $dir . '/../';
				},
			)
		);

		WP_Mock::userFunction(
			'trailingslashit',
			array(
				'return' => function ( $path ) {
					return rtrim( $path, '/' ) . '/';
				},
			)
		);
	}

	public function tearDown(): void {
		WP_Mock::tearDown();
	}

	public function test_happy() {
		$plugin = Plugin::instance();

		$this->assertSame( $plugin->get_plugin_version(), '1.0.0' );
		$this->assertSame( $plugin->is_plugin_initialized(), true );
	}

	public function test_it_is_a_singleton() {
		$a = Plugin::instance();
		$b = Plugin::instance();

		$this->assertSame( $a, $b );
	}

	public function test_actions() {
		$this->assertSame( true, has_action( 'init', array( 'Blocks', 'register_blocks' ) ) );
		$this->assertSame( true, has_action( 'init', array( 'PostTypes', 'register_post_type' ) ) );
		$this->assertSame( true, has_action( 'add_meta_boxes', array( 'PostTypes', 'add_meta_boxes' ) ) );
		$this->assertSame( true, has_action( 'save_post', array( 'PostTypes', 'save_metabox' ) ) );
	}
}
