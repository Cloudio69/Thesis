<?php

class Angolo
{

    public function get_angoli($id = null)
    {
        global $wpdb;

        if (!$id) {
            $query = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "thesis_angoli");
            return json_encode($query);
        } else {
            $query = $wpdb->get_results(
                $wpdb->prepare("SELECT * FROM {$wpdb->prefix}thesis_angoli WHERE id_angolo = {$id}")
            );
            return json_encode($query);
        }
    }
}
