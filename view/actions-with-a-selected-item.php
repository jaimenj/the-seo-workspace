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
    <h3>Selected <span class="tsw-actions-zone-site-home_url"><?= $current_selected_url['home_url'] ?></span></h3>
    <!-- --> 
    <input type="hidden" id="tsw-current-selected-id" value="<?= $current_selected_url['id'] ?>">
    <input type="hidden" id="tsw-current-selected-max_depth_allowed" value="<?= $current_selected_url['max_depth_allowed'] ?>">
    <input type="hidden" id="tsw-current-selected-max_urls_allowed" value="<?= $current_selected_url['max_urls_allowed'] ?>">
    <input type="hidden" id="tsw-current-selected-max_secs_allowed" value="<?= $current_selected_url['max_secs_allowed'] ?>">
    <input type="hidden" id="tsw-current-selected-crawl_type" value="<?= $current_selected_url['crawl_type'] ?>">
    <input type="hidden" id="tsw-current-selected-web_ping_enabled" value="<?= $current_selected_url['web_ping_enabled'] ?>">
    <!-- --> 
    <button type="button" class="tsw-btn-see-results">See results</button>
    <button type="button" name="tsw-btn-study-site" id="tsw-btn-study-site" class="tsw-btn-study-site">Study Site</button>
    <span id="tsw-box-study-site-status">Standby</span>
    * If you are studying the site and close the window, the study will stop.<br>
    <div class="tsw-progress-bar-border">
        <span class="tsw-progress-queue-text" id="tsw-progress-queue-text">Total 0%</span>
        <div class="tsw-progress-queue-content" id="tsw-progress-queue-content"></div>
    </div>
</div>