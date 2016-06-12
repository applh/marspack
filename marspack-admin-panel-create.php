<?php

global $wpdb;

if (!is_object($wpdb)) exit;

$requestDB = get_option("marspackDB", "");

$idForm = getInput("idForm");
if ($idForm == "createDB")
{
   $requestDB = getInput("requestDB");

    // SAVE THE CONTENT
    update_option("marspackDB", $requestDB);

}
?>
<h3>CREATE A NEW TABLE</h3>
<div>
    <form>
        <br>
        <textarea name="requestDB" rows="10" cols="80"><?php echo $requestDB; ?></textarea>
        <br>
        <button>CREATE NEW TABLE</button>
        <input type="hidden" name="idForm" value="createDB">
        <div class="feedback">
            <?php echo $createDBfeedback?>
        </div>
    </form>
</div>