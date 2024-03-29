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
    <!-- --> 
    
    <div class="tsw-study-buttons">
        <button type="button" id="tsw-btn-study-site" class="tsw-btn-study-site">Study Site</button>
        <button type="button" id="tsw-btn-see-results" class="tsw-btn-see-results">See results</button>
        <button type="button" id="tsw-btn-reset-queue-of-site" class="tsw-btn-reset-queue-of-site">Reset queue</button>
        <button type="button" id="tsw-btn-remove-data-of-site" class="tsw-btn-remove-data-of-site">Remove data</button>
        <span id="tsw-box-study-site-status">Standby</span>
        * If you are studying the site and close the window, the study will stop.<br>
        <div class="tsw-progress-bar-border">
            <span class="tsw-progress-queue-text" id="tsw-progress-queue-text">Total 0%</span>
            <div class="tsw-progress-queue-content" id="tsw-progress-queue-content"></div>
        </div>
    </div>

    <div class="tsw-action-buttons">
        <a href="?page=the-seo-workspace&edit-id=<?= $current_selected_url['id'] ?>" class="button button-green tsw-btn-select-item">Edit</a>
        <button 
        type="submit" 
        name="tsw-submit-remove-item" 
        id="tsw-submit-remove-item" 
        class="button button-red tsw-submit-remove-item">Remove</button>
    </div>
</div>