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
    public function delete_variante($id_variazione)
    {
        global $wpdb;

        try {
            $wpdb->delete(
                $wpdb->prefix . 'thesis_variations',
                array('id_variazione' => $id_variazione),
                array('%d')
            );

            return json_encode($wpdb->insert_id);
        } catch (Exception $e) {
            return json_encode(array("errore" => $e));
        }
    }

    public function update_variante($id_variazione, $nome_variante, $codice_colore, $anteprima_variante)
    {
        global $wpdb;

        try {

            $format = array("%s", "%s", "%s");

            $data = array(
                'nome_variazione' => $nome_variante,
                "codice_colore" => $codice_colore,
                "anteprima_variazione" => $anteprima_variante
            );

            $wpdb->update(
                $wpdb->prefix . 'thesis_variations',
                $data,
                array('id_variazione' => $id_variazione),
                $format,
                array('%d'),
            );

            return json_encode($wpdb->insert_id);
        } catch (Exception $e) {
            return json_encode(array("errore" => $e));
        }
    }
}


$variationsDb = new Variante;
