<?php

function marspack_shortcode ($tabAttribute, $content = "")
{
    $tabAttribute = shortcode_atts([
        "custom"    => "",
        "date"      => "",
        "menu"      => "",
        ], $tabAttribute);
        
    // CREATE LOCAL VARIABLES 
    extract($tabAttribute);
    
    if (!empty($custom))
    {
        return post_custom($custom);
    }
    
    if (!empty($menu))
    {
        // DEBUG
        $menu=trim($menu);
        $menuHtml = wp_nav_menu(array('menu' => $menu, 'echo' => false));    
        return $menuHtml;
    }

    if (!empty($date))
    {
        // DEBUG
        return date($date);
    }
}