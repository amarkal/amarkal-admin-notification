<?php
/**
 * This file is used to manually include all required PHP files. If you are 
 * using composer as your dependency manager, you do not need to include this 
 * file as composer will include all neccessary files automatically.
 */

// Prevent direct file access
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Prevent loading the library more than once
 */
if( defined( 'WP_ADMIN_NOTIFICATION' ) ) return;
define( 'WP_ADMIN_NOTIFICATION', true );

/**
 * Load required classes
 */
require_once 'Notifications.php';
require_once 'functions.php';