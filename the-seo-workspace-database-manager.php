<?php

defined('ABSPATH') or die('No no no');

class TheSeoWorkspaceDatabaseManager
{
    private static $instance;

    private $current_version = 1;

    public static function get_instance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct()
    {
        $this->update_if_needed();
    }

    public function create_initial_tables()
    {
        global $wpdb;

        $sql = 'CREATE TABLE '.$wpdb->prefix.'the_seo_workspace ('
            .'id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,'
            .'home_url VARCHAR(512) NOT NULL,'
            .'max_depth_allowed INTEGER NOT NULL,'
            .'max_urls_allowed INTEGER NOT NULL,'
            .'max_sec_allowed INTEGER NOT NULL,'
            .'crawl_type VARCHAR(16) NOT NULL,'
            .'web_ping_enabled BOOLEAN NOT NULL,'
            .'is_online BOOLEAN NOT NULL,'
            .'emails_to_notify VARCHAR(256) NOT NULL'
            .');';
        $wpdb->get_results($sql);

        update_option('tsw_db_version', 1);
    }

    public function remove_tables()
    {
        global $wpdb;

        $sql = 'DROP TABLE '.$wpdb->prefix.'the_seo_workspace;';
        $wpdb->get_results($sql);
    }

    public function update_if_needed()
    {
        global $wpdb;
        $db_version = get_option('tsw_db_version');

        /*/ Updates for v2..
        if ($db_version < $this->current_version
        and 2 > $db_version) {
            $sql = 'alter table '.$wpdb->prefix.'the_seo_workspace_url_number
            add constraint fk_number_to_entity foreign key (id_url)
            references '.$wpdb->prefix.'the_seo_workspace_url_entity(id)
            on delete cascade;';
            $wpdb->get_results($sql);

            ++$db_version;
        }*/

        update_option('tsw_db_version', $this->current_version);
    }
}
