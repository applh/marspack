<?php
    
if (!function_exists('do_action')) exit;

function marspack_shortcode_table ($tabAttribute, $content = "")
{
    $tabAttribute = shortcode_atts([
        "name"    => "",
        ], $tabAttribute);
        
    if ($name != "")
    {
        $requestSQL = 
<<<CODESQL

CREATE TABLE `$name` IF NOT EXISTS;

CODESQL;
    }
}