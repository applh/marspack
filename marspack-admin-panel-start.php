<?php

global $wpdb;

if (!is_object($wpdb)) exit;

// GET THE LIST OF DB TABLES
$tabTable = $wpdb->get_results( 'SHOW TABLES', ARRAY_N);
foreach($tabTable as $tabTable2)
{
    $tabDbTable[] = $tabTable2[0];
}

foreach ($tabDbTable as $table) 
{
    echo '<h4 class="actTable" data-table="' . $table . '">' . $table . '</h4>';
    // http://dev.mysql.com/doc/refman/5.7/en/show-columns.html
    $tabDesc = $wpdb->get_results( "SHOW FULL COLUMNS FROM `$table`");
    //print_r($tabDesc);
    echo '<div class="box ' . $table. '"><table><tbody>';
    foreach($tabDesc as $objField)
    {
        $colName     = $objField->Field;
        $colType     = $objField->Type;
        $colComment  = $objField->Comment;
        echo
<<<CODEHTML
<tr>
    <td>$colName</td>
    <td>$colType</td>
    <td>$colComment</td>
</tr>
CODEHTML;
    }
    echo "</tbody></table></div>";
}
