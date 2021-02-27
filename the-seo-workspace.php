<?php
/**
 * Plugin Name: The SEO Workspace
 * Plugin URI: https://jnjsite.com/the-seo-workspace-for-wordpress/
 * License: GPLv2 or later
 * Description: A SEO workspace.
 * Version: 0.1
 * Author: Jaime Niñoles
 * Author URI: https://jnjsite.com/.
 */
defined('ABSPATH') or die('No no no');
define('TSW_PATH', plugin_dir_path(__FILE__));

include_once TSW_PATH.'the-seo-workspace-database-manager.php';
include_once TSW_PATH.'the-seo-workspace-backend-controller.php';
include_once TSW_PATH.'the-seo-workspace-ajax-controller.php';

class TheSeoWorkspace
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
        // Activation and deactivation..
        register_activation_hook(__FILE__, [$this, 'activation']);
        register_deactivation_hook(__FILE__, [$this, 'deactivation']);

        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_css_js']);

        TheSeoWorkspaceDatabaseManager::get_instance();
        TheSeoWorkspaceBackendController::get_instance();
        TheSeoWorkspaceAjaxController::get_instance();
    }

    public function activation()
    {
        register_setting('tsw_options_group', 'tsw_db_version');
        register_setting('tsw_options_group', 'tsw_quantity_per_batch');
        register_setting('tsw_options_group', 'tsw_time_between_batches');

        add_option('tsw_db_version', 0);
        add_option('tsw_quantity_per_batch', '2');
        add_option('tsw_time_between_batches', '30');

        TheSeoWorkspaceDatabaseManager::get_instance()->create_initial_tables();
    }

    public function deactivation()
    {
        TheSeoWorkspaceDatabaseManager::get_instance()->remove_tables();

        unregister_setting('tsw_options_group', 'tsw_db_version');
        unregister_setting('tsw_options_group', 'tsw_quantity_per_batch');
        unregister_setting('tsw_options_group', 'tsw_time_between_batches');
    }

    public function uninstall()
    {
        delete_option('tsw_db_version');
        delete_option('tsw_quantity_per_batch');
        delete_option('tsw_time_between_batches');
    }

    /**
     * It adds assets only for the backend..
     */
    public function enqueue_admin_css_js()
    {
        if (isset($_GET['page']) and 'the-seo-workspace' == $_GET['page']) {
            wp_enqueue_style('tsw_style_datatables', plugin_dir_url(__FILE__).'lib/datatables.min.css', false, '0.1');
            wp_enqueue_style('tsw_custom_style', plugin_dir_url(__FILE__).'lib/tsw.min.css', false, '0.1.4');

            wp_enqueue_script('tsw_script_pdfmake', plugin_dir_url(__FILE__).'lib/pdfmake.min.js', [], '0.1');
            wp_enqueue_script('tsw_script_vfs_fonts', plugin_dir_url(__FILE__).'lib/vfs_fonts.js', [], '0.1');
            wp_enqueue_script('tsw_script_datatables', plugin_dir_url(__FILE__).'lib/datatables.min.js', [], '0.1');
            wp_enqueue_script('tsw_script_chart', plugin_dir_url(__FILE__).'lib/Chart.min.js', [], '0.1');
            wp_enqueue_script('tsw_custom_script', plugin_dir_url(__FILE__).'lib/tsw.min.js', [], '0.1.4');
        }
    }
}

// Do all..
TheSeoWorkspace::get_instance();
