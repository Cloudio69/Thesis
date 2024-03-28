<?php

class Rilegatura
{
    public function get_rilegature($id = null)
    {
        global $wpdb;

        if (!$id) {
            $query = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "thesis_rilegature");
            return json_encode($query);
        } else {
            $query = $wpdb->get_results(
                $wpdb->prepare("SELECT * FROM {$wpdb->prefix}thesis_rilegature WHERE id_rilegatura = {$id}")
            );
            return json_encode($query);
        }
    }

    public function create_rilegatura($nome_rilegatura, $descrizione_rilegatura, $anteprima_rilegatura, $prezzo_rilegatura, $angoli)
    {
        global $wpdb;

        try {
            $data = array(
                'nome_rilegatura' => $nome_rilegatura,
                "descrizione_rilegatura" => $descrizione_rilegatura,
                "anteprima_rilegatura" => $anteprima_rilegatura,
                "prezzo_rilegatura" => $prezzo_rilegatura,
                "angoli" => $angoli
            );

            $format = array("%s", "%s", "%s", "%f", "%d");

            $wpdb->insert($wpdb->prefix . 'thesis_rilegature', $data, $format);

            return json_encode(array($wpdb->insert_id, $data));
        } catch (Exception $e) {
            return json_encode(array("errore" => $e));
        }
    }

    public function delete_rilegatura($id_rilegatura)
    {
        global $wpdb;

        try {
            $wpdb->delete(
                $wpdb->prefix . 'thesis_rilegature',
                array('id_rilegatura' => $id_rilegatura),
                array('%d')
            );

            return json_encode($wpdb->insert_id);
        } catch (Exception $e) {
            return json_encode(array("errore" => $e));
        }
    }
    public function update_rilegatura($id_rilegatura, $nome_rilegatura, $descrizione_rilegatura, $anteprima_rilegatura, $prezzo_rilegatura, $angoli)
    {
        global $wpdb;

        try {

            $format = array("%s", "%s", "%s");

            $data = array(
                'nome_rilegatura' => $nome_rilegatura,
                "descrizione_rilegatura" => $descrizione_rilegatura,
                "anteprima_rilegatura" => $anteprima_rilegatura,
                "prezzo_rilegatura" => $prezzo_rilegatura,
                "angoli" => $angoli
            );

            $wpdb->update(
                $wpdb->prefix . 'thesis_rilegature',
                $data,
                array('id_rilegatura' => $id_rilegatura),
                $format,
                array('%d'),
            );

            return json_encode($wpdb->insert_id);
        } catch (Exception $e) {
            return json_encode(array("errore" => $e));
        }
    }

    public function get_full_data_rilegature()
    {
        global $wpdb;
        // Rilegature
        $query = $wpdb->get_results("SELECT * FROM ". $wpdb->prefix ."thesis_rilegature INNER JOIN ". $wpdb->prefix ."thesis_variazioni USING (id_rilegatura)");
        return json_encode($query);
    }
}
