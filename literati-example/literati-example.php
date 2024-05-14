<?php
/**
 * Plugin Name: Literati Example
 * Plugin URI: https://github.com/literatibooks/literati-wp-example
 * Description:
 * Version: 1.0.0
 * Author: Literati
 * Author URI: https://literati.com/
 * Text Domain: literati-example
 *
 * @package Literati\Example
 */

use Literati\Example\Plugin;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

add_action(
	'plugins_loaded',
	function () {
		if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
			include __DIR__ . '/vendor/autoload.php';
		}

		literati_example();
	},
	9
);

/**
 * Returns the main instance of the plugin to prevent the need to use globals.
 */
function literati_example() {
	return Plugin::instance();
}
