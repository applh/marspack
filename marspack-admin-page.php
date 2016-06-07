<?php 
    if (!function_exists('do_action')) exit;
    
    $txtIntro =
<<<CODEHTML
Welcome on <strong>MarsPack</strong>!

This plugin is under development. Thanks for your patience.
CODEHTML;

$marspackOption = get_option("marspack", "");

// FORM MANAGEMENT
$idForm = getInput("idForm");
if ($idForm == "instructions")
{
    $marspackOption = getInput("instructions");
    
    // SAVE THE CONTENT
    update_option("marspack", $marspackOption);
    
    setVar("instructionsFeedback    ", "under construction...");
}
?>
<section>
    <h3><?php _e('Mars Pack Admin', 'marspack'); ?></h3>
    <pre><?php _e($txtIntro, 'marspack'); ?></pre>
</section>
<section class="instructions">
    <h3><?php _e('Enter your instructions', 'marspack'); ?></h3>
    <div class="panel">
<form>
    <textarea name="instructions" cols="80" rows="16" required><?php echo $marspackOption; ?></textarea>
    <input type="hidden" name="page" value="marspack">
    <input type="hidden" name="idForm" value="instructions">
    <div>
        <button type="submit">ACTIVATE</button>
    </div>
    <div class="feedback">
        <?php echoVar("instructionsFeedback"); ?>
    </div>
</form>
    </div>
    <script type="text/javascript">
    jQuery(function(){
        jQuery(".instructions h3").on("click", function(){
           jQuery(".instructions .panel").slideToggle(); 
        });
    });    
    </script>
</section>


<section class="database">
    <h3><?php _e('Database', 'marspack'); ?></h3>
    <div>
        <button class="actStart">START</button>
    </div>
    <div class="marsScreen" style="z-index:999999;position:fixed;top:0;left:0;width:100%;height:100%;background-color:rgba(0,0,0,0.9);overflow:scroll;color:#ffffff;padding:1em;">
        <button class="actClose">CLOSE</button>
        <div>
<pre>
    
<?php
global $wpdb;
// GET THE LIST OF DB TABLES
$tabTable = $wpdb->get_results( 'SHOW TABLES', ARRAY_N);
foreach($tabTable as $tabTable2)
{
    $tabDbTable[] = $tabTable2[0];
}

foreach ($tabDbTable as $table) 
{
    echo "<h4>$table</h4>";
    // http://dev.mysql.com/doc/refman/5.7/en/show-columns.html
    $tabDesc = $wpdb->get_results( "SHOW FULL COLUMNS FROM `$table`");
    print_r($tabDesc);
}
?>
</pre>            
        </div>
    </div>
    <script type="text/javascript">
    jQuery(function(){
        jQuery(".marsScreen").fadeOut();
        jQuery(".database .actStart").on("click", function(){
            jQuery(".marsScreen").fadeIn();
        });
        jQuery(".database .actClose").on("click", function(){
            jQuery(".marsScreen").fadeOut();
        });
    });    
    </script>

</section>