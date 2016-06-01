<?php

class MarsPack
{
    // PROPERTIES
    
    // METHODS
    function __construct ()
    {
        load_plugin_textdomain('marspack', false, basename( dirname( __FILE__ ) ) . '/languages' );
        
        $this->installShortcode();
        $this->installAdmin();
    }
    
    function installShortcode ()
    {
        add_shortcode('pack', 'marspack_shortcode');
    }
    
    function installAdmin ()
    {
        add_action('admin_menu', 'marspack_menu');

    }
}