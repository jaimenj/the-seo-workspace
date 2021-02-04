<?php

defined('ABSPATH') or die('No no no');
if (!current_user_can('administrator')) {
    wp_die(__('Sorry, you are not allowed to manage options for this site.'));
}

?>
<div class="tsw-actions-zone">
    <h3>Selected <span class="tsw-actions-zone-site-home-url"></span></h3>
</div>