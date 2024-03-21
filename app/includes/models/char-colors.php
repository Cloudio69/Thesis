<?php

class CharColors
{

    public function get_char_colors($id = null)
    {
        global $wpdb;

        if (!$id) {
            $query = $wpdb->get_results(
                "SELECT tc.id_rilegatura, tc.nome_rilegatura, tv.id_variazione, tv.nome_variazione, tv.codice_colore, 
                tcc.id_colore_carattere, tcc.nome_colore, tcc.hex_colore FROM " .
                    $wpdb->prefix . "thesis_variations tv INNER JOIN " .
                    $wpdb->prefix . "thesis_rilegature tc USING(id_rilegatura) INNER JOIN " .
                    $wpdb->prefix . "thesis_variations_chars tcc USING(id_variazione)"
            );
            return json_encode($query);
        }
    }
}
