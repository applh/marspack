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
    // https://developer.wordpress.org/reference/functions/update_option/
    update_option("marspackDb", $requestDb);
        
    // https://developer.wordpress.org/reference/functions/add_shortcode/    
    add_shortcode("table", "marspack_shortcode_table");
    // https://developer.wordpress.org/reference/functions/do_shortcode/
    do_shortcode($requestDb);

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