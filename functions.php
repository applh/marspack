<?php

function marspack_shortcode ($tabAttribute, $content = "")
{
    $tabAttribute = shortcode_atts([
        "custom"        => "",
        "custom1"       => "",
        "date"          => "",
        "menu"          => "",
        "button"        => "",
        "action"        => "",
        "table"         => "",
        "colSort"       => "id",
        "indexStart"    => "0",
        "nbLine"        => "100",
        "form"          => "",
        "agenda"        => "",
        "search"        => "",
        ], $tabAttribute);
        
    // CREATE LOCAL VARIABLES 
    extract($tabAttribute);
    
    // WARNING: PRIORITY BETWEEN SOME ATTRIBUTES

    // WARNING: MUST BE INSIDE THE LOOP
    if (!empty($form))
    {
        $template = "";
        if (!empty($custom))
        {
            $template = post_custom($custom);
        }
        if (!empty($table))
        {
            return marspack_table_form($table, $form, $template);
        }
    }
    
    // WARNING: MUST BE INSIDE THE LOOP
    if (!empty($table))
    {
        $template = "";
        if (!empty($custom))
        {
            $template = post_custom($custom);
        }
        return marspack_table_read($table, $colSort, $indexStart, $nbLine, $template);
    }

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

    
    if (!empty($agenda))
    {
        // BUILD THIS MONTH AGENDA
        $now = time();
        return mp_build_agenda($now);
    }

    if (!empty($search))
    {
        // https://codex.wordpress.org/Class_Reference/WP_Query
        $result = "";
        $args = [
            "post_type" => "page",
            "meta_key"  => $search,
            ];
        // The Query
        $query1 = new WP_Query( $args );
        
        // The Loop
        while ( $query1->have_posts() ) {
        	$query1->the_post();
        	$result .= '<div>' . post_custom($search) . '</div>';
        	$result .= '<div>' . get_the_permalink() . '</div>';
        	$result .= '<div>' . get_the_title() . '</div>';
        }
        
        /* Restore original Post Data 
         * NB: Because we are using new WP_Query we aren't stomping on the 
         * original $wp_query and it does not need to be reset with 
         * wp_reset_query(). We just need to set the post data back up with
         * wp_reset_postdata().
         */
        wp_reset_postdata();
        
        return $result;
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
function marspack_table_read ($table, $colSort="id", $indexStart=0, $nbLine=100, $template="")
{
    $result = "";
    
    $requestSQL = 
<<<CODESQL
SELECT * FROM `$table`
ORDER BY `$colSort` DESC
LIMIT $indexStart, $nbLine
;
CODESQL;
    
    global $wpdb;
    $tabResult = $wpdb->get_results($requestSQL, ARRAY_A);
    foreach($tabResult as $tabLine)
    {
        // id
        $lineClass = "$table";
        if (isset($tabLine["$colSort"]))
        {
            $idLine = $tabLine["$colSort"];
            $lineClass = "$table $table-$idLine";
        }
        
        if ($template == "")
        {
            $result .= '<ul class="' . $lineClass . '">';
            foreach($tabLine as $col => $val)
            {
                 $result .= 
<<<CODEHTML
<li class="$col">$val</li>
CODEHTML;

            }
            $result .= "</ul>";
        }
        else
        {
            $tabToken = [];
            foreach($tabLine as $col => $val)
            {
                $tabToken[] = ":$col";
            }
            $result .= str_replace($tabToken, array_values($tabLine), $template);
        }
    }
    
    return $result;
}

function marspack_table_form ($table, $form, $template)
{
    $result = "";
    
    // CONTROLLER
    $idForm = getInput("idForm");
    if ($idForm == "$form")
    {
        $tabCol = [];
        foreach($_REQUEST as $inputName => $inputval)
        {
            if (":" == $inputName[0])
            {
                $inputName = substr($inputName, 1);
                $tabCol[$inputName] = $inputval;
            }
        }
        // WARNING: SECURITY PROBLEMS
        $colNameList = implode("` , `", array_keys($tabCol));

        $colValList  = implode("' , '", array_values($tabCol));
        $requestSQL =
<<<CODESQL

INSERT INTO `$table`
( `$colNameList` )
VALUES
( '$colValList' )

CODESQL;

        global $wpdb;
        $wpdb->insert($table, $tabCol);
        

    }
    
    // VIEW
    $formEnd = 
<<<CODEHTML
<input type="hidden" name="idForm" value="$form">
    </form>
    <!-- HELLO -->
CODEHTML;
    // ADD idForm INPUT
    $result = str_replace("</form>", $formEnd, $template);
    
    return $result;
}

function mp_build_agenda ($now)
{
    $result = "";
    
    $tomorrow = (1+$d) * 3600 * 24 + $now;
    $curYear       = date("Y", $now);
    $curMonth      = date("m", $now);
    $nbDaysMonth   = date("t", $now);
    
    $day1          = date("w", strtotime("$curYear/$curMonth/01"));
    $timeStart     = strtotime("$curYear/$curMonth/01 -$day1 days");
    
    $result .= '<div class="mp_agenda">';
    
    $nbWeek = 5;
    for($d=1; $d <= 7 * $nbWeek; $d++) 
    {
        $curTime = $d * 3600 * 24 + $timeStart;
        $curDayMonth  = date("d", $curTime);
        $curDayWeek   = date("w", $curTime);
        
        $dayClass="item";
        if ($curTime < $now)
        {
            $dayClass="item past";
        }
        else
        {
            if ($curTime < $tomorrow)
            {
                $dayClass="item today";
            }
            $loopMonth    = date("m", $curTime);
            if ($loopMonth > $curMonth)
            {
                $dayClass="item nextM";
            }
            
        }
        $result .= 
<<<CODEHTML
<span class="$dayClass d$curDayWeek">$curDayMonth</span>
CODEHTML;
        
    }
    $result .= '</div>';
    
    return $result;
}

function mp_head ()
{
    echo '<style type="text/css">';
    require_once(__DIR__."/style.css");
    echo "</style>";
}
