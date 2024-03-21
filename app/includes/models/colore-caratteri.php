<?php

class CharColors
{

    public function get_char_colors($id = null)
    {
        global $wpdb;

        if (!$id) {
            $query = $wpdb->get_results(
                "SELECT * FROM " . $wpdb->prefix ."thesis_colori_carattere"
            );
            return json_encode($query);
        }
    }
}
