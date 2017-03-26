<?php

namespace Amarkal\Admin;

class Notifications
{
    /**
     * @var Singleton The reference to *Singleton* instance of this class
     */
    private static $instance;

    private $notifications = array();

    private $dismissed_notices;

    /**
     * Returns the *Singleton* instance of this class.
     *
     * @return Singleton The *Singleton* instance.
     */
    public static function get_instance()
    {
        if( null === static::$instance ) 
        {
            static::$instance = new static();
        }
        return static::$instance;
    }

    public function init()
    {
        add_action( 'admin_notices', array( $this, 'render_notifications' ) );
        add_action( 'network_admin_notices', array( $this, 'render_network_notifications' ) );
        add_action( 'wp_ajax_dismiss_admin_notification', array( $this, 'dismiss_notification' ) );
        add_action( 'admin_footer', array( $this, 'render_script' ) ); // Must be hooked to a late action hook
        $this->dismissed_notices = get_site_option( 'amarkal_dismissed_notices', array() );
    }

    public function register_notification( $handle, $options )
    {
        if( !key_exists( $handle, $this->notifications ) )
        {
            $this->notifications[$handle] = $options;
        }
        else trigger_error( "The handle <strong>$handle</strong> has already been registered. Please choose a different handle for your notification." );
    }

    public function render_notifications()
    {
        foreach($this->notifications as $handle => $notification)
        {
            $this->render_notification( $handle, $notification );
        }
    }

    public function render_network_notifications()
    {
        foreach( $this->notifications as $handle => $notification )
        {
            if( $notification['network'] ) $this->render_notification( $handle, $notification );
        }
    }

    public function dismiss_notification()
    {
        $id = filter_input( INPUT_POST, 'id' );
        if( !in_array( $id, $this->dismissed_notices ) )
        {
            $this->dismissed_notices[] = $id;
            update_site_option( 'amarkal_dismissed_notices', $this->dismissed_notices);
        }
        wp_die();
    }

    public function render_script()
    {
        if( 0 === count( $this->notifications ) ) return;
        ?>
        <script>
        jQuery(document).ready(function($){
            $('.notice').on('click','.notice-dismiss',function(e){
                $.post(ajaxurl,{
                    action: 'dismiss_admin_notification',
                    id: $(this).parent().attr('id')
                });
            });
        });
        </script>
        <?php
    }

    private function render_notification( $id, $n )
    {
        if( in_array( $id, $this->dismissed_notices ) ) return;

        printf( 
            '<div id="%s" class="notice notice-%s %s%s"><p>%s</p></div>',
            $id,
            $n['type'], 
            $n['dismissible']?'is-dismissible ':'', 
            $n['class'], 
            $n['html'] 
        );
    }
}
