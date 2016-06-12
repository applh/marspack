<?php

function marspack_shortcode ($tabAttribute, $content = "")
{
    $tabAttribute = shortcode_atts([
        "custom"    => "",
        "custom1"   => "",
        "date"      => "",
        "menu"      => "",
        "button"    => "",
        "action"    => "",
        "table"    => "",
        ], $tabAttribute);
        
    // CREATE LOCAL VARIABLES 
    extract($tabAttribute);
    
    if (!empty($custom))
    {
        return post_custom($custom);
    }

    if (!empty($custom1))
    {
        $value  = post_custom($custom1);
        $value1 = intval($value) + 1;
        $id = get_the_ID();
        update_post_meta($id, $custom1, $value1, $value);
        return "$value1";
    }

    if (!empty($button))
    {
        $value  = post_custom($button);
        // UPDATE +1 ONLY IF BUTTON PRESSED
        if ($button == getInput("button"))
        {
            $value1 = intval($value) + 1;
            $id = get_the_ID();
            update_post_meta($id, $button, $value1, $value);
        }
        else
        {
            $value1 = intval($value);
        }
        
        // WARNING: POSTS MUST HAVE PRETTY PERMALINKS
        $uri = $_SERVER["REQUEST_URI"];
        
        return 
<<<CODEHTML
<form action="$uri" method="POST">
    <input type="hidden" name="button" value="$button">
    <button><span class="counter">$value1</span><span class="$button"> $content</span></button>
</form>
CODEHTML;
    }
    
    if (!empty($menu))
    {
        // DEBUG
        $menu=trim($menu);
        $menuHtml = wp_nav_menu(array('menu' => $menu, 'echo' => false));    
        return $menuHtml;
    }

    if (!empty($table))
    {
        // DEBUG
        return marspack_table_read($table);
    }
    
    if (!empty($date))
    {
        // DEBUG
        return date($date);
    }
}


// ADMIN MENU
function marspack_admin_head ()
{
    echo '<style type="text/css">';
    require_once(__DIR__.'/admin.css');
    echo '</style>';
}

function marspack_admin_menu () {
    add_plugins_page(
        __('MarsPack Admin',    'marspack'), 
        __('MarsPack',          'marspack'), 
        'manage_options', 
        'marspack', 
        'marspack_admin_page');
}   

function marspack_admin_init ()
{
}

function marspack_plugins_loaded ()
{
    // LOAD THE TRANSLATION FILE
    load_plugin_textdomain('marspack', false, basename( __DIR__ ) . '/languages' );
}

function marspack_admin_page ()
{
    // BUILD THE PLUGIN ADMIN PAGE
    require_once(__DIR__."/marspack-admin-functions.php");
    require_once(__DIR__."/marspack-admin-page.php");
}


// FORM UTILS
function getInput ($name, $default="")
{
    $result = $default;
    
    if (isset($_REQUEST["$name"]))
    {
        $result = $_REQUEST["$name"];
    }
    elseif (isset($_COOKIE["$name"]))
    {
        $result = $_COOKIE["$name"];
    }
    
    $result = strip_tags($result);
    $result = trim($result);
    return $result;
}

function echoVar ($varName, $translate=false)
{
    if (isset($GLOBALS["$varName"]))
    {
        if ($translate)
        {
            _e($GLOBALS["$varName"], 'marspack');
        }
        else
        {
            echo $GLOBALS["$varName"];
        }
    }
}

function setVar ($varName, $varVal)
{
    $GLOBALS["$varName"] = $varVal;
}

// READ THE DB TABLE
function marspack_table_read ($table)
{
    $requestSQL = 
<<<CODESQL
SELECT * FROM `$table`
LIMIT 0, 100
;
CODESQL;
    
    global $wpdb;
    $tabResult = $wpdb->get_results($requestSQL, ARRAY_A);
    foreach($tabResult as $tabLigne)
    {
        echo '<ul class="' . $table . ' ">';
        foreach($tabLigne as $col => $val)
        {
            echo 
<<<CODEHTML
<li class="$col">$val</li>"
CODEHTML;

        }
        echo "</ul>";
    }
}