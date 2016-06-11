<?php

global $wpdb;

if (!is_object($wpdb)) exit;

?>
<h3>CREATE A NEW TABLE</h3>
<div>
    <form>
        <input type="text" name="tableName" placeholder="TABLE NAME" required/>
        <button>CREATE NEW TABLE</button>    
    </form>
</div>