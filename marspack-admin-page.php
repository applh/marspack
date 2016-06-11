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
/* global jQuery */
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
        <button class="actStart"><?php _e('show tables', 'marspack'); ?></button>
    </div>
    <div>
        <button class="actCreate"><?php _e('create table', 'marspack'); ?></button>
    </div>
    <div class="marsScreen">
        <button class="actClose"><?php _e('close', 'marspack'); ?></button>
        <div class="contentStart contentBox">
<pre>
<?php require_once(__DIR__."/marspack-admin-panel-start.php"); ?>    
</pre>            
        </div>
        <div class="contentCreate contentBox">
<pre>
<?php require_once(__DIR__."/marspack-admin-panel-create.php"); ?>    
</pre>            
        </div>
    </div>
    <script type="text/javascript">
/* global jQuery */
jQuery(function(){
    jQuery(".marsScreen").fadeOut();
    jQuery("div.box").hide();
    
    jQuery(".database .actStart").on("click", function(){
        jQuery(".marsScreen .contentBox").hide();
        jQuery(".marsScreen .contentStart").show();

        jQuery(".marsScreen").fadeIn();
    });
    jQuery(".database .actCreate").on("click", function(){
        jQuery(".marsScreen .contentBox").hide();
        jQuery(".marsScreen .contentCreate").show();

        jQuery(".marsScreen").fadeIn();
    });
    jQuery(".database .actClose").on("click", function(){
        jQuery(".marsScreen").fadeOut();
    });
    jQuery(".database .actTable").on("click", function(){
        var table = jQuery(this).attr("data-table");
        jQuery("div.box."+table).slideToggle();
    });
});    

    </script>

</section>