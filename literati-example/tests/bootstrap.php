<?php
/**
 * Test bootstrap file.
 *
 * @package Literati\Example\Tests
 */

// First we need to load the composer autoloader, so we can use WP Mock.
require_once dirname( __DIR__ ) . '/vendor/autoload.php';

// Bootstrap WP_Mock to initialize built-in features.
WP_Mock::setUsePatchwork( true );
WP_Mock::bootstrap();
