<?php

defined('ABSPATH') or die('No no no');

class TheSeoWorkspaceAjaxController
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
        add_action('wp_ajax_tsw_urls', [$this, 'tsw_urls']);
    }

    public function tsw_urls()
    {
        if (!current_user_can('administrator')) {
            wp_die(__('Sorry, you are not allowed to manage options for this site.'));
        }

        // Request data to the DB..
        global $wpdb;

        // Main query..
        $sql = 'SELECT * ';
        $sql_filtered = 'SELECT count(*) ';
        $from_sentence = ' FROM '.$wpdb->prefix.'the_seo_workspace ';
        $sql .= $from_sentence;
        $sql_filtered .= $from_sentence;

        // Where filtering..
        $where_clauses_or = [];
        $where_clauses_and = [];
        // ..main search..
        if (!empty($_POST['search']['value'])) {
            foreach ($_POST['columns'] as $column) {
                if ('id' == $column['name']) {
                    $where_clauses_or[] = sanitize_text_field($column['name']).' = '.floatval($_POST['search']['value']);
                } else {
                    $where_clauses_or[] = sanitize_text_field($column['name'])." LIKE '%".sanitize_text_field($_POST['search']['value'])."%'";
                }
            }
        }
        // ..column search..
        foreach ($_POST['columns'] as $column) {
            if (!empty($column['search']['value'])) {
                if ('id' == $column['name']) {
                    $where_clauses_and[] = sanitize_text_field($column['name']).' = '.floatval($column['search']['value']);
                } else {
                    $where_clauses_and[] = sanitize_text_field($column['name'])." LIKE '%".sanitize_text_field($column['search']['value'])."%'";
                }
            }
        }

        // Ordering data..
        $order_by_clauses = [];
        if (!empty($_POST['order'])) {
            foreach ($_POST['order'] as $order) {
                $order_by_clauses[] = sanitize_text_field($_POST['columns'][$order['column']]['name']).' '.sanitize_text_field($order['dir']);
            }
        }

        // Main results..
        $where_filtered = implode(' AND ', $where_clauses_and);
        if (empty($where_filtered)) {
            if (!empty($where_clauses_or)) {
                $where_filtered = implode(' OR ', $where_clauses_or);
            }
        } else {
            if (!empty($where_clauses_or)) {
                $where_filtered .= ' AND ('.implode(' OR ', $where_clauses_or).')';
            }
        }
        if (!empty($where_filtered)) {
            $sql .= ' WHERE '.$where_filtered;
            $sql_filtered .= ' WHERE '.$where_filtered;
        }
        if (!empty($order_by_clauses)) {
            $sql .= ' ORDER BY '.implode(', ', $order_by_clauses);
        }
        //var_dump($sql);
        $sql .= ' LIMIT '.intval($_POST['length']).' OFFSET '.intval($_POST['start']);
        $results = $wpdb->get_results($sql);

        // Totals..
        $sql_total = 'SELECT count(*) FROM '.$wpdb->prefix.'the_seo_workspace ';
        $records_total = $wpdb->get_var($sql_total);
        $records_total_filtered = $wpdb->get_var($sql_filtered);

        // Return data..
        $data = [];
        foreach ($results as $key => $value) {
            //var_dump($key); var_dump($value);
            $tempItem = [];
            foreach ($value as $valueKey => $valueValue) {
                $tempItem[] = $valueValue;
            }
            $data[] = [
                $value->id,
                $value->home_url,
                'Max depth allowed: '.$value->max_depth_allowed.'<br>'
                .'Max urls allowed: '.$value->max_urls_allowed.'<br>'
                .'Max secs allowed: '.$value->max_secs_allowed.'<br>'
                .'Crawl type: '.$value->crawl_type.'<br>'
                .'Web ping enabled: '.$value->web_ping_enabled,
                $value->is_online,
                $value->emails_to_notify,
                ''
            ];
        }
        header('Content-type: application/json');
        echo json_encode([
            'draw' => intval($_POST['draw']),
            'recordsTotal' => $records_total,
            'recordsFiltered' => $records_total_filtered,
            'data' => $data,
            'sql' => $sql,
            'sqlFiltered' => $sql_filtered,
        ]);

        wp_die();
    }
}
