<?php

defined('ABSPATH') or die('No no no');
if (!current_user_can('administrator')) {
    wp_die(__('Sorry, you are not allowed to manage options for this site.'));
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
                    value="" 
                    class="regular-text">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="tsw-edition-zone-home-url">Home URL</label>
                </th>
                <td>
                    <input 
                    name="tsw-edition-zone-home-url" 
                    type="text" 
                    id="tsw-edition-zone-home-url" 
                    value="" 
                    class="regular-text">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="tsw-edition-zone-max-depth-allowed">Max depth allowed</label>
                </th>
                <td>
                    <input 
                    name="tsw-edition-zone-max-depth-allowed" 
                    type="text" 
                    id="tsw-edition-zone-max-depth-allowed" 
                    value="" 
                    class="regular-text">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="tsw-edition-zone-max-urls-allowed">Max URLs allowed</label>
                </th>
                <td>
                    <input 
                    name="tsw-edition-zone-max-urls-allowed" 
                    type="text" 
                    id="tsw-edition-zone-max-urls-allowed" 
                    value="" 
                    class="regular-text">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="tsw-edition-zone-max-secs-allowed">Max secs allowed</label>
                </th>
                <td>
                    <input 
                    name="tsw-edition-zone-max-secs-allowed" 
                    type="text" 
                    id="tsw-edition-zone-max-secs-allowed" 
                    value="" 
                    class="regular-text">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="tsw-edition-zone-crawl-type">Crawl type</label>
                </th>
                <td>
                    <input 
                    name="tsw-edition-zone-crawl-type" 
                    type="text" 
                    id="tsw-edition-zone-crawl-type" 
                    value="" 
                    class="regular-text">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="tsw-edition-zone-web-ping-enabled">Web ping enabled</label>
                </th>
                <td>
                    <input 
                    name="tsw-edition-zone-web-ping-enabled" 
                    type="text" 
                    id="tsw-edition-zone-web-ping-enabled" 
                    value="" 
                    class="regular-text">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="tsw-edition-zone-is-online">Is online</label>
                </th>
                <td>
                    <input 
                    name="tsw-edition-zone-is-online" 
                    type="text" 
                    id="tsw-edition-zone-is-online" 
                    value="" 
                    class="regular-text">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="tsw-edition-zone-emails-to-notify">Emails to notify</label>
                </th>
                <td>
                    <input 
                    name="tsw-edition-zone-zone-emails-to-notify" 
                    type="text" 
                    id="tsw-edition-zone-emails-to-notify" 
                    value="" 
                    class="regular-text">
                </td>
            </tr>
        </tbody>
    </table>
</div>