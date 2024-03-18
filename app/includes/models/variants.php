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
    public function create_variante($id_copertina, $nome_variante, $codice_colore, $anteprima_variante)
    {
        global $wpdb;

        try {
            $data = array(
                'id_copertina' => $id_copertina,
                "codice_colore" => $codice_colore,
                'nome_variazione' => $nome_variante,
                "anteprima_variazione" => $anteprima_variante
            );

            $format = array("%d", "%s", "%s", "%s");

            $wpdb->insert($wpdb->prefix . 'thesis_variations', $data, $format);

            return json_encode($wpdb->insert_id);
        } catch (Exception $e) {
            return json_encode(array("errore" => $e));
        }
    }
}


$variationsDb = new Variante;
