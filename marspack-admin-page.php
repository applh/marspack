<?php 
    if (!function_exists('do_action')) exit;
    
    $txtIntro =
<<<CODEHTML
Welcome on <strong>MarsPack</strong>!

This plugin is under development. Thanks for your patience.
CODEHTML;

?>
<section>
    <h3><?php _e('Mars Pack Admin', 'marspack'); ?></h3>
    <pre><?php _e($txtIntro, 'marspack'); ?></pre>
</section>
<section>
    <h3><?php _e('Enter your instructions', 'marspack'); ?></h3>
    <form>
        <textarea name="instructions" cols="80" rows="16" required></textarea>
        <input type="hidden" name="page" value="marspack">
        <div>
            <button type="submit">ACTIVATE</button>
        </div>
        <div>
            
        </div>
    </form>
</section>