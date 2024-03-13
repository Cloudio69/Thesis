<?php

require_once ABSPATH . 'wp-admin/includes/upgrade.php';

class ThesisDatabase
{
    public static function create_tables()
    {
        global $wpdb;

        $table_name = $wpdb->prefix . 'custom_table';
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            name tinytext NOT NULL,
            text text NOT NULL,
            url varchar(55) DEFAULT '' NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";

        dbDelta($sql);
    }

    public static function delete_tables()
    {
        global $wpdb;

        $table_name = $wpdb->prefix . 'custom_table';
        $wpdb->query("DROP TABLE IF EXISTS $table_name");
        error_log("Database dropped");
    }
}
