<?php

class Segnalibro {

    public function get_segnalibri($id = null)
    {
        global $wpdb;

        if (!$id) {
            $query = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "thesis_segnalibri");
            return json_encode($query);
        } else {
            $query = $wpdb->get_results(
                $wpdb->prepare("SELECT * FROM {$wpdb->prefix}thesis_segnalibri WHERE id_segnalibro = {$id}")
            );
            return json_encode($query);
        }
    }
}