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
    }
    
    function installAdmin ()
    {
        add_action('admin_init',        'marspack_admin_init');
        add_action('plugins_loaded',    'marspack_plugins_loaded');
        add_action('admin_menu',        'marspack_admin_menu');

    }
}