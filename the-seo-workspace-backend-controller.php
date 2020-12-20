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
        $page_title = 'SEO Workspace';
        $menu_title = $page_title;
        $capability = 'administrator';
        $menu_slug = 'the-seo-workspace';
        $function = [$this, 'tsw_main_admin_controller'];
        $icon_url = 'dashicons-performance';
        $position = null;

        add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position);
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

    private function _save_main_configs()
    {
        update_option('tsw_quantity_per_batch', intval($_REQUEST['quantity_per_batch']));
        update_option('tsw_time_between_batches', intval($_REQUEST['time_between_batches']));

        return '<div id="message" class="notice notice-success is-dismissible"><p>Main options saved!</p></div>';
    }
}
