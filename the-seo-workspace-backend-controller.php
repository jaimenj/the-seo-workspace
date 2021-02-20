<?php

defined('ABSPATH') or die('No no no');

class TheSeoWorkspaceBackendController
{
    private static $instance;

    public static function get_instance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct()
    {
        add_action('admin_menu', [$this, 'add_admin_page']);
    }

    public function add_admin_page()
    {
        $page_title = 'The SEO Workspace';
        $menu_title = $page_title;
        $capability = 'administrator';
        $menu_slug = 'the-seo-workspace';
        $function = [$this, 'tsw_main_admin_controller'];
        $position = null;

        add_management_page($page_title, $menu_title, $capability, $menu_slug, $function, $position);
    }

    public function tsw_main_admin_controller()
    {
        $submitting = false;
        foreach ($_REQUEST as $key => $value) {
            if (preg_match('/submit/', $key)) {
                $submitting = true;
            }
        }

        // Security control
        if ($submitting) {
            if (!isset($_REQUEST['tsw_nonce'])) {
                $tswSms = '<div id="message" class="notice notice-error is-dismissible"><p>ERROR: nonce field is missing.</p></div>';
            } elseif (!wp_verify_nonce($_REQUEST['tsw_nonce'], 'tsw')) {
                $tswSms = '<div id="message" class="notice notice-error is-dismissible"><p>ERROR: invalid nonce specified.</p></div>';
            } else {
                /*
                 * Handling actions..
                 */
                if (isset($_REQUEST['tsw-submit'])) {
                    $tswSms = $this->_save_main_configs();
                } elseif (isset($_REQUEST['tsw-submit-add-home-url'])) {
                    $tswSms = $this->_add_home_url();
                } elseif (isset($_REQUEST['tsw-submit-save-edition-zone'])) {
                    $tswSms = $this->_save_edition_zone();
                } else {
                    $tswSms = '<div id="message" class="notice notice-success is-dismissible"><p>Cannot understand submitting!</p></div>';
                }
            }
        }

        // Main options..
        $quantity_per_batch = get_option('tsw_quantity_per_batch');
        $time_between_batches = get_option('tsw_time_between_batches');
        $current_columns_to_show = get_option('tsw_current_columns_to_show');
        $tsw_db_version = get_option('tsw_db_version');

        include TSW_PATH.'view/main.php';
    }

    private function _save_edition_zone()
    {
        TheSeoWorkspaceDatabaseManager::get_instance()->update_url(intval($_GET['edit-id']), [
            'home_url' => sanitize_text_field($_POST['home_url']),
            'max_depth_allowed' => $_POST['max_depth_allowed'],
            'max_urls_allowed' => $_POST['max_urls_allowed'],
            'max_secs_allowed' => $_POST['max_secs_allowed'],
            'crawl_type' => sanitize_text_field($_POST['crawl_type']),
            'web_ping_enabled' => (boolval($_POST['web_ping_enabled']) ? 1 : 0),
            'is_online' => (boolval($_POST['is_online']) ? 1 : 0),
            'emails_to_notify' => sanitize_text_field($_POST['emails_to_notify']),
        ]);

        return '<div id="message" class="notice notice-success is-dismissible"><p>Site data saved!</p></div>';
    }

    private function _save_main_configs()
    {
        update_option('tsw_quantity_per_batch', intval($_REQUEST['quantity_per_batch']));
        update_option('tsw_time_between_batches', intval($_REQUEST['time_between_batches']));

        return '<div id="message" class="notice notice-success is-dismissible"><p>Main options saved!</p></div>';
    }

    private function _add_home_url()
    {
        $user = wp_get_current_user();
        
        $new_home_url = sanitize_text_field($_REQUEST['txt-add-home-url']);
        TheSeoWorkspaceDatabaseManager::get_instance()->add_url([
            'home_url' => $new_home_url,
            'max_depth_allowed' => 2,
            'max_urls_allowed' => 3,
            'max_secs_allowed' => 30,
            'crawl_type' => 'in-width',
            'web_ping_enabled' => 1,
            'is_online' => 0,
            'emails_to_notify' => $user->user_email,
        ]);

        return  '<div id="message" class="notice notice-success is-dismissible"><p>New home URL saved!</p></div>';
    }
}
