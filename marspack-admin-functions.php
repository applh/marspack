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

CREATE TABLE IF NOT EXISTS `$name`;

CODESQL;

        // EXECUTE THE REQUEST SQL
        // https://codex.wordpress.org/Class_Reference/wpdb
        global $wpdb;
        $wpdb->query($requestSQL);
    }
}