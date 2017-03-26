<?php
/**
 * This is a composer bootstrapping file that will only be included if composer 
 * is used to autoload classes. If you are not using composer, include 
 * bootstrap.php instead.
 */

// Prevent direct file access
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Prevent loading the library more than once
 */
if( defined( 'WP_ADMIN_NOTIFICATION' ) ) return;
define( 'WP_ADMIN_NOTIFICATION', true );

require_once 'functions.php';
