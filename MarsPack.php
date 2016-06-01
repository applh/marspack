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
        add_action('admin_init', 'marspack_admin_init');
        add_action('admin_menu', 'marspack_menu');

    }
}