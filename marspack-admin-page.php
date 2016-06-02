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
</section>

<script type="text/javascript">
jQuery(function(){
    jQuery(".instructions h3").on("click", function(){
       jQuery(".instructions .panel").slideToggle(); 
    });
});    
</script>