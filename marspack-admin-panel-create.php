<?php

global $wpdb;

if (!is_object($wpdb)) exit;

?>
<h3>CREATE A NEW TABLE</h3>
<div>
    <form>
        <input type="text" name="tableName" placeholder="TABLE NAME" required/>
        <br>
        <textarea name="commands" rows="10" cols="80"></textarea>
        <br>
        <button>CREATE NEW TABLE</button>    
    </form>
</div>