<?php

class CharColors
{

    public function get_char_colors($id = null)
    {
        global $wpdb;

        if (!$id) {
            $query = $wpdb->get_results(
                "SELECT * FROM " .
                    $wpdb->prefix . "thesis_copertine INNER JOIN " .
                    $wpdb->prefix . "thesis_variations USING(id_copertina) INNER JOIN " .
                    $wpdb->prefix . "thesis_variations_chars USING(id_variazione)"
            );
            return json_encode($query);
        }
    }
}
