<?php

global $wpdb;

if (!is_object($wpdb)) exit;

$requestDb          = "";
$createDbFeedback   = "";
$idForm             = getInput("idForm");

if ($idForm == "createDb")
{
   $requestDb = getInput("requestDb");
   $requestDb = stripslashes($requestDb);
   
    // SAVE THE CONTENT
    update_option("marspackDb", $requestDb);
        
    add_shortcode('table', 'marspack_shortcode_table');

}
else
{
    $requestDb          = get_option("marspackDb", "");
}
?>
<h3>CREATE A NEW TABLE</h3>
<div>
    <form method="POST">
        <br>
        <textarea name="requestDb" rows="10" cols="80"><?php echo $requestDb; ?></textarea>
        <br>
        <button><?php _e('Save and Create', 'marspack'); ?></button>
        <input type="hidden" name="idForm" value="createDb">
        <div class="feedback">
<?php echo $createDbFeedback; ?>
        </div>
    </form>
</div>