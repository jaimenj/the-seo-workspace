<?php

defined('ABSPATH') or die('No no no');
if (!current_user_can('administrator')) {
    wp_die(__('Sorry, you are not allowed to manage options for this site.'));
}

if(isset($_GET['id']) and !empty($_GET['id']) and is_numeric($_GET['id'])) {
    $current_editing_url = TheSeoWorkspaceDatabaseManager::get_instance()->get_url($_GET['id']);
}

?>
<div class="tsw-edition-zone">
    <h3>Editing <span class="tsw-edition-zone-site-home-url"></span></h3>
    <table class="form-table" role="presentation">
        <tbody>
            <tr>
                <th scope="row">
                    <label for="tsw-edition-zone-id">Id</label>
                </th>
                <td>
                    <input 
                    name="tsw-edition-zone-id" 
                    type="text" 
                    id="tsw-edition-zone-id" 
                    value="<?= $current_editing_url['id'] ?>"
                    class="regular-text"
                    disabled>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="tsw-edition-zone-home_url">Home URL</label>
                </th>
                <td>
                    <input 
                    name="tsw-edition-zone-home_url" 
                    type="text" 
                    id="tsw-edition-zone-home_url"
                    value="<?= $current_editing_url['home_url'] ?>"
                    class="regular-text">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="tsw-edition-zone-max_depth_allowed">Max depth allowed</label>
                </th>
                <td>
                    <input 
                    name="tsw-edition-zone-max_depth_allowed" 
                    type="text" 
                    id="tsw-edition-zone-max_depth_allowed" 
                    value="<?= $current_editing_url['max_depth_allowed'] ?>"
                    class="regular-text">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="tsw-edition-zone-max_urls_allowed">Max URLs allowed</label>
                </th>
                <td>
                    <input 
                    name="tsw-edition-zone-max_urls_allowed" 
                    type="text" 
                    id="tsw-edition-zone-max_urls_allowed" 
                    value="<?= $current_editing_url['max_urls_allowed'] ?>"
                    class="regular-text">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="tsw-edition-zone-max_secs_allowed">Max secs allowed</label>
                </th>
                <td>
                    <input 
                    name="tsw-edition-zone-max_secs_allowed" 
                    type="text" 
                    id="tsw-edition-zone-max_secs_allowed" 
                    value="<?= $current_editing_url['max_secs_allowed'] ?>"
                    class="regular-text">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="tsw-edition-zone_crawl_type">Crawl type</label>
                </th>
                <td>
                    <input 
                    name="tsw-edition-zone_crawl_type" 
                    type="text" 
                    id="tsw-edition-zone_crawl_type" 
                    value="<?= $current_editing_url['crawl_type'] ?>"
                    class="regular-text">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="tsw-edition-zone-web_ping_enabled">Web ping enabled</label>
                </th>
                <td>
                    <input 
                    name="tsw-edition-zone-web_ping_enabled" 
                    type="text" 
                    id="tsw-edition-zone-web_ping_enabled" 
                    value="<?= $current_editing_url['web_ping_enabled'] ?>"
                    class="regular-text">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="tsw-edition-zone_is_online">Is online</label>
                </th>
                <td>
                    <input 
                    name="tsw-edition-zone_is_online" 
                    type="text" 
                    id="tsw-edition-zone_is_online" 
                    value="<?= $current_editing_url['is_online'] ?>"
                    class="regular-text">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="tsw-edition-zone-emails_to_notify">Emails to notify</label>
                </th>
                <td>
                    <input 
                    name="tsw-edition-zone-emails_to_notify" 
                    type="text" 
                    id="tsw-edition-zone-emails_to_notify" 
                    value="<?= $current_editing_url['emails_to_notify'] ?>"
                    class="regular-text">
                </td>
            </tr>
        </tbody>
    </table>
    <button type="submit" name="tsw-submit-save-edition-zone" id="tsw-submit-save-edition-zone" class="button button-green button-save-edition-zone">Save the current site changes</button>
</div>