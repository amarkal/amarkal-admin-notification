<?php
/**
 * WordPress Admin Notifications
 *
 * Add static/dismissible admin notifications to WordPress
 *
 * @package   amarkal-admin-notification
 * @author    Askupa Software <hello@askupasoftware.com>
 * @link      https://github.com/amarkal/amarkal-admin-notification
 * @copyright 2017 Askupa Software
 */

// Prevent direct file access
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Prevent loading the library more than once
 */
if( defined( 'AMARKAL_ADMIN_NOTIFICATION' ) ) return false;
define( 'AMARKAL_ADMIN_NOTIFICATION', true );

if(!function_exists('_amarkal_admin_notification_init'))
{
    /**
     * Initiate admin notifications
     */
    function _amarkal_admin_notification_init() 
    {
        $notifier = Amarkal\Admin\Notifications::get_instance();
        $notifier->init();
    }
    add_action( 'init', '_amarkal_admin_notification_init' );
}

if(!function_exists('amarkal_admin_notification'))
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
    function amarkal_admin_notification( $handle, $html, $type = 'success', $dismissible = false, $class = '', $network = false )
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

if(!function_exists('amarkal_reset_admin_notification'))
{
    /**
     * Reset a dismissed admin notification.
     * 
     * @param string $handle
     */
    function amarkal_reset_admin_notification( $handle )
    {
        $dismissed = get_site_option( 'amarkal_dismissed_notices', array() );
        $offset = 0;
        foreach($dismissed as $id)
        {
            if( $id === $handle ) break;
            $offset++;
        }
        array_splice( $dismissed, $offset, 1);
        update_site_option( 'amarkal_dismissed_notices', $dismissed );
    }
}

if(!function_exists('wp_admin_notification'))
{
    /**
     * @deprecated use amarkal_admin_notification instead
     */
    function wp_admin_notification( $handle, $html, $type = 'success', $dismissible = false, $class = '', $network = false )
    {
        trigger_error('<b>wp_admin_notification()</b> has been deprecated. Use <b>amarkal_admin_notification</b> instead.');
        amarkal_admin_notification( $handle, $html, $type, $dismissible, $class, $network );
    }
}

if(!function_exists('wp_reset_admin_notification'))
{
    /**
     * @deprecated use amarkal_reset_admin_notification instead
     */
    function wp_reset_admin_notification( $handle )
    {
        trigger_error('<b>wp_reset_admin_notification()</b> has been deprecated. Use <b>amarkal_reset_admin_notification</b> instead.');
        amarkal_reset_admin_notification( $handle );
    }
}