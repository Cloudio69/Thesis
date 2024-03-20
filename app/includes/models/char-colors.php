<?php

class CharColors
{

    public function get_char_colors($id = null)
    {
        global $wpdb;

        if (!$id) {
            $query = $wpdb->get_results(
                "SELECT tc.id_copertina, tc.nome_copertina, tv.id_variazione, tv.nome_variazione, tv.codice_colore, 
                tcc.id_colore_carattere, tcc.nome_colore, tcc.hex_colore FROM " .
                    $wpdb->prefix . "thesis_variations tv INNER JOIN " .
                    $wpdb->prefix . "thesis_copertine tc USING(id_copertina) INNER JOIN " .
                    $wpdb->prefix . "thesis_variations_chars tcc USING(id_variazione)"
            );
            return json_encode($query);
        }
    }
}
