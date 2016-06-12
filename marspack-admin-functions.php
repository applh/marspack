<?php
    
if (!function_exists('do_action')) exit;

function marspack_shortcode_col ($tabAttribute, $content = "")
{
    $tabAttribute = shortcode_atts([
        "table"   => "",
        "name"    => "",
        "type"    => "text",
        "comment" => "",
        "action"  => "",
        "after"  => "",
        ], $tabAttribute);
        
    extract($tabAttribute);
    
    if ( ($table != "") && ($name != ""))
    {
        if ($action == "drop")
        {
            $requestSQL = 
<<<CODESQL

ALTER TABLE `$table` 
DROP COLUMN  `$name`
;

CODESQL;
            
        }
        else
        {
            switch ($type)
            {
                case "int":
                case "number":
                case "boolean":
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
            
            $afterCol = " ";
            if ($after != "")
            {
                $afterCol = "AFTER `$after` ";
            }
            // TODO: IMPROVE
            $comment = $type;
            
            if ($action == "modify")
            {
                // ALTER TABLE  `hello2` ADD  `email` TEXT NOT NULL ;
                $requestSQL = 
<<<CODESQL

ALTER TABLE `$table` 
MODIFY  `$name` $colType 
NOT NULL
COMMENT '$comment'
$afterCol
;

CODESQL;
                
            }
            else
            {
                // ALTER TABLE  `hello2` ADD  `email` TEXT NOT NULL ;
                $requestSQL = 
<<<CODESQL

ALTER TABLE `$table` 
ADD COLUMN `$name` $colType 
NOT NULL
COMMENT '$comment'
$afterCol
;

CODESQL;
                
            }
        }
        
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
        "action"  => "",
        ], $tabAttribute);
    extract($tabAttribute); 
    
    if ($name != "")
    {
        
        if ($action == "create")
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
AUTO_INCREMENT=1 
;

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
        
        if ($action == "drop")
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

        if ($action == "insert")
        {
            
            if ($content != "")
            {
                // COMPLETE THE SHORTCODE WITH TABLE NAME
                $content = str_replace("[col ", '[col table="' . $name . '" ', $content);
                
                // PROCESS THE COLUMNS
                add_shortcode("col", "marspack_shortcode_col_insert");
                $listColVal = do_shortcode($content);
            }

            // REMOVE EXTRA ,
            $listColVal = trim($listColVal);
            $listColVal = trim($listColVal, ",");
            
            $requestSQL = 
<<<CODESQL

INSERT INTO  `$name`
SET
$listColVal
CODESQL;

            // EXECUTE THE REQUEST SQL
            // https://codex.wordpress.org/Class_Reference/wpdb
            global $wpdb;
            $wpdb->query($requestSQL);
            
            echo $requestSQL;
            setVar("createDbFeedback", $requestSQL);
        }


    }
    else
    {
        setVar("createDbFeedback", "missing name");
    }
    
    return "";
}

function marspack_shortcode_col_insert ($tabAttribute, $content = "")
{
    $result = "";
    
    $tabAttribute = shortcode_atts([
        "table"   => "",
        "name"    => "",
        "type"    => "text",
        "comment" => "",
        "action"  => "",
        "after"   => "",
        ], $tabAttribute);
        
    extract($tabAttribute);
    
    if ($name != "")
    {
       $result = 
<<<CODESQL

`$name`  = '$content',

CODESQL;

    }
    
    return $result;
}
