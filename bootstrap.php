<?php
/**
 * WordPress Admin Notifications
 *
 * Add static/dismissible admin notifications to WordPress
 *
 * @package   wp-admin-notification
 * @author    Askupa Software <hello@askupasoftware.com>
 * @link      https://github.com/askupasoftware/wp-admin-notification
 * @copyright 2016 Askupa Software
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Prevent loading the library more than once
 */
if( defined( 'WP_ADMIN_NOTIFICATION' ) ) return;
define( 'WP_ADMIN_NOTIFICATION', true );

/**
 * Load required classes if not using composer
 */
if( !class_exists('Composer\\Autoload\\ClassLoader') )
{
    require_once 'Notifications.php';
}

/**
 * Initiate admin notifications
 */
if(!function_exists('_wp_admin_notification_init'))
{
    function _wp_admin_notification_init() 
    {
        $notifier = Amarkal\Admin\Notifications::get_instance();
        $notifier->init();
    }
    add_action( 'init', '_wp_admin_notification_init' );
}

if(!function_exists('wp_admin_notification'))
{
    /**
     * Register an admin notification.
     * 
     * @param type $handle
     * @param type $html
     * @param type $type
     * @param type $dismissible
     * @param type $class
     * @param type $network
     */
    function wp_admin_notification( $handle, $html, $type = 'success', $dismissible = false, $class = '', $network = false )
    {
        $notifier = Amarkal\Admin\Notifications::get_instance();
        $notifier->register_notification($handle, array(
            'dismissible'   => $dismissible,
            'class'         => $class,
            'type'          => $type,
            'html'          => $html,
            'network'       => $network
        ));
    }
}

if(!function_exists('wp_reset_admin_notification'))
{
    /**
     * Reset a dismissed admin notification.
     * 
     * @param string $handle
     */
    function wp_reset_admin_notification( $handle )
    {
        $dismissed = get_site_option( 'wp_dismissed_notices', array() );
        $offset = 0;
        foreach($dismissed as $id)
        {
            if( $id === $handle ) break;
            $offset++;
        }
        array_splice( $dismissed, $offset, 1);
        update_site_option( 'wp_dismissed_notices', $dismissed );
    }
}