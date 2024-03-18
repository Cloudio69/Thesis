<?php

class Variante
{
    public function get_varianti($id = null)
    {
        global $wpdb;
        if (!$id) {
            $query = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "thesis_copertine INNER JOIN " . $wpdb->prefix . "thesis_variations USING(id_copertina)");
            return json_encode($query);
        }
    }
}


$variationsDb = new Variante;
