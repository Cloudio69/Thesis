<?php

class Variante
{
    public function get_varianti($id = null)
    {
        global $wpdb;
        if (!$id) {
            $query = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "thesis_rilegature INNER JOIN " . $wpdb->prefix . "thesis_variazioni USING(id_rilegatura)");
            return json_encode($query);
        }
    }
    public function create_variante($id_rilegatura, $nome_variante, $codice_colore, $anteprima_variante)
    {
        global $wpdb;

        try {
            $data = array(
                'id_rilegatura' => $id_rilegatura,
                "codice_colore" => $codice_colore,
                'nome_variante' => $nome_variante,
                "anteprima_variante" => $anteprima_variante
            );

            $format = array("%d", "%s", "%s", "%s");

            $wpdb->insert($wpdb->prefix . 'thesis_variazioni', $data, $format);

            return json_encode($wpdb->insert_id);
        } catch (Exception $e) {
            return json_encode(array("errore" => $e));
        }
    }
    public function delete_variante($id_variante)
    {
        global $wpdb;

        try {
            $wpdb->delete(
                $wpdb->prefix . 'thesis_variazioni',
                array('id_variante' => $id_variante),
                array('%d')
            );

            return json_encode($wpdb->insert_id);
        } catch (Exception $e) {
            return json_encode(array("errore" => $e));
        }
    }

    public function update_variante($id_variante, $nome_variante, $codice_colore, $anteprima_variante)
    {
        global $wpdb;

        try {

            $format = array("%s", "%s", "%s");

            $data = array(
                'nome_variante' => $nome_variante,
                "codice_colore" => $codice_colore,
                "anteprima_variante" => $anteprima_variante
            );

            $wpdb->update(
                $wpdb->prefix . 'thesis_variazioni',
                $data,
                array('id_variante' => $id_variante),
                $format,
                array('%d'),
            );

            return json_encode($wpdb->insert_id);
        } catch (Exception $e) {
            return json_encode(array("errore" => $e));
        }
    }
}