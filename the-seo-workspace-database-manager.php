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
            .'max_secs_allowed INTEGER NOT NULL,'
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

    /**
     * Receive data in format:
     *   'column' => 'value'
     *   ...
     */
    public function add_url($data)
    {
        global $wpdb;

        $sql = 'INSERT INTO '.$wpdb->prefix.'the_seo_workspace (';
        $keys = $values = [];
        foreach ($data as $key => $value) {
            $keys[] = $key;
        }
        $sql .= implode(', ', $keys).') VALUES (';
        foreach ($data as $key => $value) {
            if (is_bool($value) or is_numeric($value)) {
                $values[] = $value;
            } else {
                $values[] = "'".$value."'";
            }
        }
        $sql .= implode(', ', $values).');';

        $wpdb->get_results($sql);
    }

    public function get_url($id)
    {
        global $wpdb;

        $sql = 'SELECT * FROM '.$wpdb->prefix.'the_seo_workspace WHERE id = '.$id;

        return (array) $wpdb->get_results($sql)[0];
    }

    public function update_url($id, $data)
    {
        global $wpdb;

        $sql = 'UPDATE '.$wpdb->prefix.'the_seo_workspace SET ';
        $key_values = [];
        foreach ($data as $key => $value) {
            if (is_bool($value) or is_numeric($value)) {
                $key_values[] = $key.' = '.$value;
            } else {
                $key_values[] = $key." = '".$value."'";
            }
        }
        $sql .= implode(',', $key_values).' WHERE id = '.$id.';';

        $wpdb->get_results($sql);
    }

    public function remove_url($id)
    {
        global $wpdb;

        $sql = 'DELETE FROM '.$wpdb->prefix.'the_seo_workspace WHERE id = '.$id.';';

        $wpdb->get_results($sql);
    }

    public function reset_queue_of_site($id)
    {
        global $wpdb;

        // Get site..
        $sql = 'SELECT * FROM '.$wpdb->prefix.'the_seo_workspace WHERE id = '.$id.';';
        $site = $wpdb->get_results($sql)[0];

        // Remove queue..
        $wpdb->get_results(
            'DELETE FROM '.$wpdb->prefix.'the_seo_machine_queue '
            ."WHERE url LIKE '%".$site->home_url."%';"
        );
    }

    public function remove_data_of_site($id)
    {
        global $wpdb;

        // Get site..
        $sql = 'SELECT * FROM '.$wpdb->prefix.'the_seo_workspace WHERE id = '.$id.';';
        $site = $wpdb->get_results($sql)[0];

        // Find URLs..
        $sql = "SELECT * FROM ".$wpdb->prefix."the_seo_machine_url_entity WHERE url LIKE '%".$site->home_url."%';";
        $urls = $wpdb->get_results($sql);
        foreach ($urls as $url) {
            // Remove URL data..
            $wpdb->get_results(
                'DELETE FROM '.$wpdb->prefix.'the_seo_machine_url_string '
                .'WHERE id_url = '.$url->id.';'
            );
            $wpdb->get_results(
                'DELETE FROM '.$wpdb->prefix.'the_seo_machine_url_text '
                .'WHERE id_url = '.$url->id.';'
            );
            $wpdb->get_results(
                'DELETE FROM '.$wpdb->prefix.'the_seo_machine_url_number '
                .'WHERE id_url = '.$url->id.';'
            );
            $wpdb->get_results(
                'DELETE FROM '.$wpdb->prefix.'the_seo_machine_url_entity '
                .'WHERE id = '.$url->id.';'
            );
        }
    }
}
