<?php
/**
 * This file is used to manually include all required PHP files. If you are 
 * using composer as your dependency manager, you do not need to include this 
 * file as composer will include all neccessary files automatically.
 */

// Prevent direct file access
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Load module functions. If this amarkal module has not been loaded, 
 * functions.php will not return false.
 */
if(false !== (require_once 'functions.php'))
{
    // Load required classes if not using composer
    require_once 'Notifications.php';
}