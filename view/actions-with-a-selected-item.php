<?php

defined('ABSPATH') or die('No no no');
if (!current_user_can('administrator')) {
    wp_die(__('Sorry, you are not allowed to manage options for this site.'));
}


if(isset($_GET['select-id']) and !empty($_GET['select-id']) and is_numeric($_GET['select-id'])) {
    $current_selected_url = TheSeoWorkspaceDatabaseManager::get_instance()->get_url(intval($_GET['select-id']));
}

?>
<div class="tsw-actions-zone">
    <h3>Selected <span class="tsw-actions-zone-site-home-url"></span></h3>
</div>