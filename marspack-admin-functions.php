<?php
    
if (!function_exists('do_action')) exit;

function marspack_shortcode_col ($tabAttribute, $content = "")
{
    $tabAttribute = shortcode_atts([
        "table"   => "",
        "name"    => "",
        "type"    => "text",
        "comment" => "",
        ], $tabAttribute);
        
    extract($tabAttribute);
    
    print_r($tabAttribute);
    
    if ( ($table != "") && ($name != ""))
    {
        switch ($type)
        {
            case "int":
            case "number":
                $colType = "INT";
                break;
            case "decimal":
                $colType = "DECIMAL(12,2)";
                break;
            case "date":
                $colType = "DATETIME";
                break;
            default:
                $colType = "TEXT";
                break;
        }
        // TODO: IMPROVE
        $comment = $type;
        
        // ALTER TABLE  `hello2` ADD  `email` TEXT NOT NULL ;
        $requestSQL = 
<<<CODESQL

ALTER TABLE `$table` 
ADD  `$name` $colType 
NOT NULL 
COMMENT '$comment';

CODESQL;

        // EXECUTE THE REQUEST SQL
        // https://codex.wordpress.org/Class_Reference/wpdb
        global $wpdb;
        $wpdb->query($requestSQL);
        
    }
}

function marspack_shortcode_table ($tabAttribute, $content = "")
{
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
        
        if ($content != "")
        {
            // COMPLETE THE SHORTCODE WITH TABLE NAME
            $content = str_replace("[col ", '[col table="' . $name . '" ', $content);
            
            // PROCESS THE COLUMNS
            add_shortcode("col", "marspack_shortcode_col");
            do_shortcode($content);
        }
        
        setVar("createDbFeedback", $requestSQL);
    }
    else
    {
        setVar("createDbFeedback", "missing name");
    }
}

function marspack_shortcode_drop ($tabAttribute, $content = "")
{
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
        
        setVar("createDbFeedback", $requestSQL);
    }
    else
    {
        setVar("createDbFeedback", "missing name");

    }
}