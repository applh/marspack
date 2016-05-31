<?php

class MarsPack
{
    // PROPERTIES
    
    // METHODS
    function __construct ()
    {
        $this->installShortcode();
    }
    
    function installShortcode ()
    {
        add_shortcode('pack', 'marspack_shortcode');
    }
}