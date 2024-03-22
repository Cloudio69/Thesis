<?php

class Grammatura {

    public function get_grammature($id = null)
    {
        global $wpdb;

        if (!$id) {
            $query = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "thesis_grammature");
            return json_encode($query);
        } else {
            $query = $wpdb->get_results(
                $wpdb->prepare("SELECT * FROM {$wpdb->prefix}thesis_grammature WHERE id_grammatura = {$id}")
            );
            return json_encode($query);
        }
    }
}