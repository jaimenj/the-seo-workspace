<?php

defined('ABSPATH') or die('No no no');
if (!current_user_can('administrator')) {
    wp_die(__('Sorry, you are not allowed to manage options for this site.'));
}

?>

<style>hr{margin-top: 30px;}</style>

<form method="post" enctype="multipart/form-data" action="<?php
echo $_SERVER['REQUEST_URI'];
?>"
id="tsw_form"
name="tsw_form"
data-tsw_ajax_url="<?= admin_url('admin-ajax.php') ?>">

    <div class="wrap tsw-wrap">
        <span style="float: right">
            Support the project, please donate <a href="https://paypal.me/jaimeninoles" target="_blank"><b>here</b></a>.<br>
            Need help? Ask <a href="https://jnjsite.com/the-seo-workspace-for-wordpress/" target="_blank"><b>here</b></a>.
        </span>

        <h1><a href="?page=the-seo-workspace"><span class="dashicons dashicons-performance tsw-icon"></span> The SEO Workspace</a></h1>

        <?php
        if (isset($tswSms)) {
            echo $tswSms;
        }
        settings_fields('tsw_options_group');
        do_settings_sections('tsw_options_group');
        wp_nonce_field('tsw', 'tsw_nonce');
        ?>
        <input type="hidden" id="tsw_path" value="<?= strtok($_SERVER["REQUEST_URI"], '?'); ?>">

        <div class="tsw-header-actions-container">
            <div class="tsw-header-actions-container-left">
                <input type="submit" name="tsw-submit" id="tsw-submit" class="button button-green tsw-btn-submit" value="Save this configs">

                <label for="quantity_per_batch">Quantity per Batch</label>
                <select name="quantity_per_batch" id="quantity_per_batch">
                    <option value="1"<?= (1 == $quantity_per_batch ? ' selected' : ''); ?>>1</option>
                    <option value="2"<?= (2 == $quantity_per_batch ? ' selected' : ''); ?>>2</option>
                    <option value="3"<?= (3 == $quantity_per_batch ? ' selected' : ''); ?>>3</option>
                    <option value="4"<?= (4 == $quantity_per_batch ? ' selected' : ''); ?>>4</option>
                    <option value="5"<?= (5 == $quantity_per_batch ? ' selected' : ''); ?>>5</option>
                    <option value="6"<?= (6 == $quantity_per_batch ? ' selected' : ''); ?>>6</option>
                    <option value="7"<?= (7 == $quantity_per_batch ? ' selected' : ''); ?>>7</option>
                    <option value="8"<?= (8 == $quantity_per_batch ? ' selected' : ''); ?>>8</option>
                    <option value="9"<?= (9 == $quantity_per_batch ? ' selected' : ''); ?>>9</option>
                    <option value="10"<?= (10 == $quantity_per_batch ? ' selected' : ''); ?>>10</option>
                </select>

                <label for="time_between_batches">Time between Batches</label>
                <select name="time_between_batches" id="time_between_batches">
                    <option value="1"<?= (1 == $time_between_batches ? ' selected' : ''); ?>>1s</option>
                    <option value="5"<?= (5 == $time_between_batches ? ' selected' : ''); ?>>5s</option>
                    <option value="10"<?= (10 == $time_between_batches ? ' selected' : ''); ?>>10s</option>
                    <option value="30"<?= (30 == $time_between_batches ? ' selected' : ''); ?>>30s</option>
                    <option value="60"<?= (60 == $time_between_batches ? ' selected' : ''); ?>>60s</option>
                    <option value="120"<?= (120 == $time_between_batches ? ' selected' : ''); ?>>120s</option>
                </select>
            </div>
            <div class="tsw-header-actions-container-right">
                <input type="text" name="txt-add-home-url" placeholder="Add a new home URL..">
                <button type="submit" name="tsw-submit-add-home-url" id="tsw-submit-add-home-url" class="button button-green button-add-home-url">Add home URL</button>
            </div>
        </div>

        <?php

        if (isset($_GET['select-id'])) {
            include TSW_PATH.'view/actions-with-a-selected-item.php';
        }
        if (isset($_GET['edit-id'])) {
            if(isset($_GET['edit-id']) and !empty($_GET['edit-id']) and is_numeric($_GET['edit-id'])) {
                $current_editing_url = TheSeoWorkspaceDatabaseManager::get_instance()->get_url(intval($_GET['edit-id']));
            }

            if (!empty($current_editing_url)) {
                include TSW_PATH.'view/edition-of-a-selected-item.php';
            }
        }

        ?>

        <div class="table-responsive" id="tsw-datatable-container">
            <h2>All the sites under the SEO study</h2>
            <table 
            class="records_list table table-striped table-bordered table-hover" 
            id="tsw-datatable" 
            width="100%">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Home URL</th>
                        <th>Main info</th>
                        <th>Is online</th>
                        <th>Emails to notify</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th class="filterme">Filter..</th>
                        <th class="filterme">Filter..</th>
                        <th></th>
                        <th class="filterme">Filter..</th>
                        <th class="filterme">Filter..</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        
    </div>
</form>

<hr>
<p>Current DB version: <?= $tsw_db_version ?></p>
<p>This plugin uses the awesome Datatables, you can find it here: <a href="https://www.datatables.net/" target="_blank">https://www.datatables.net/</a></p>
<script>
    let weAreInTheSeoWorkspace = true
</script>