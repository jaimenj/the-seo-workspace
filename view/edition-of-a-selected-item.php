<?php

defined('ABSPATH') or die('No no no');
if (!current_user_can('administrator')) {
    wp_die(__('Sorry, you are not allowed to manage options for this site.'));
}

?>
<div class="tsw-edition-zone">
    <h3>Editing <span class="site-home-url"><?= $current_editing_url['home_url'] ?></span></h3>
    <table class="form-table" role="presentation">
        <tbody>
            <tr>
                <th scope="row">
                    <label for="id">Id</label>
                </th>
                <td>
                    <input 
                    name="id" 
                    type="text" 
                    id="id" 
                    value="<?= $current_editing_url['id'] ?>"
                    class="regular-text"
                    disabled>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="home_url">Home URL</label>
                </th>
                <td>
                    <input 
                    name="home_url" 
                    type="text" 
                    id="home_url"
                    value="<?= $current_editing_url['home_url'] ?>"
                    class="regular-text">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="max_depth_allowed">Max depth allowed</label>
                </th>
                <td>
                    <input 
                    name="max_depth_allowed" 
                    type="text" 
                    id="max_depth_allowed" 
                    value="<?= $current_editing_url['max_depth_allowed'] ?>"
                    class="regular-text">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="max_urls_allowed">Max URLs allowed</label>
                </th>
                <td>
                    <input 
                    name="max_urls_allowed" 
                    type="text" 
                    id="max_urls_allowed" 
                    value="<?= $current_editing_url['max_urls_allowed'] ?>"
                    class="regular-text">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="max_secs_allowed">Max secs allowed</label>
                </th>
                <td>
                    <input 
                    name="max_secs_allowed" 
                    type="text" 
                    id="max_secs_allowed" 
                    value="<?= $current_editing_url['max_secs_allowed'] ?>"
                    class="regular-text">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="crawl_type">Crawl type</label>
                </th>
                <td>
                    <select name="crawl_type" id="crawl_type">
                        <option value="in-width"<?= ($current_editing_url['crawl_type'] == 'in-width' ? ' selected' : '') ?>>In width</option>
                        <option value="in-depth"<?= ($current_editing_url['crawl_type'] == 'in-depth' ? ' selected' : '') ?>>In depth</option>
                        <option value="random"<?= ($current_editing_url['crawl_type'] == 'random' ? ' selected' : '') ?>>Random</option>
                    </select>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="tsw-action-buttons">
        <a href="?page=the-seo-workspace&select-id=<?= $current_editing_url['id'] ?>" class="button button-green tsw-btn-select-item">Select</a>
        <button 
        type="submit" 
        name="tsw-submit-save-edition-zone" 
        id="tsw-submit-save-edition-zone" 
        class="button button-green button-save-edition-zone">Save the current site changes</button>
        <button 
        type="submit" 
        name="tsw-submit-remove-item" 
        id="tsw-submit-remove-item" 
        class="button button-red tsw-submit-remove-item">Remove</button>
    </div>
</div>