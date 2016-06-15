<?php

class MarsPack
{
    // PROPERTIES
    
    // METHODS
    function __construct ()
    {
        
        $this->installShortcode();
        $this->installAdmin();
    }
    
    function installShortcode ()
    {
        add_shortcode('pack', 'marspack_shortcode');
        add_action('wp_head', 'mp_head');
    }
    
    function installAdmin ()
    {
        add_action('admin_init',        'marspack_admin_init');
        add_action('plugins_loaded',    'marspack_plugins_loaded');
        add_action('admin_menu',        'marspack_admin_menu');
        add_action('admin_head',        'marspack_admin_head' );
    }
}