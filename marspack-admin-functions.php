<?php
    
if (!function_exists('do_action')) exit;

function marspack_shortcode_table ($tabAttribute, $content = "")
{
    print_r($tabAttribute);
    
    $tabAttribute = shortcode_atts([
        "name"    => "",
        ], $tabAttribute);
    extract($tabAttribute);    
    if ($name != "")
    {
        $requestSQL = 
<<<CODESQL

CREATE TABLE IF NOT EXISTS `$name`
(
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) 
ENGINE=InnoDB 
DEFAULT CHARSET=utf8mb4 
COLLATE=utf8mb4_unicode_ci 
AUTO_INCREMENT=1 ;

CODESQL;

        // EXECUTE THE REQUEST SQL
        // https://codex.wordpress.org/Class_Reference/wpdb
        global $wpdb;
        $wpdb->query($requestSQL);
        
        echo $requestSQL;
        
        setVar("createDbFeedback", $requestSQL);
    }
    else
    {
        setVar("createDbFeedback", "missing name");

    }
}

function marspack_shortcode_drop ($tabAttribute, $content = "")
{
    print_r($tabAttribute);
    
    $tabAttribute = shortcode_atts([
        "name"    => "",
        ], $tabAttribute);
    extract($tabAttribute);    
    if ($name != "")
    {
        $requestSQL = 
<<<CODESQL

DROP TABLE `$name`;

CODESQL;

        // EXECUTE THE REQUEST SQL
        // https://codex.wordpress.org/Class_Reference/wpdb
        global $wpdb;
        $wpdb->query($requestSQL);
        
        echo $requestSQL;
        
        setVar("createDbFeedback", $requestSQL);
    }
    else
    {
        setVar("createDbFeedback", "missing name");

    }
}