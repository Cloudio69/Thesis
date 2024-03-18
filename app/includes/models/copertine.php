<?php

class Copertina
{
    public function get_copertine($id = null)
    {
        global $wpdb;

        if (!$id) {
            $query = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "thesis_copertine");
            return json_encode($query);
        } else {
            $query = $wpdb->get_results(
                $wpdb->prepare("SELECT * FROM {$wpdb->prefix}thesis_copertine WHERE id_copertina = {$id}")
            );
            return json_encode($query);
        }
    }

    public function create_copertina($nome_copertina, $descrizione_copertina, $anteprima_copertina)
    {
        global $wpdb;

        try {
            $data = array(
                'nome_copertina' => $nome_copertina,
                "descrizione_copertina" => $descrizione_copertina,
                "anteprima_copertina" => $anteprima_copertina
            );

            $format = array("%s", "%s", "%s");

            $wpdb->insert($wpdb->prefix . 'thesis_copertine', $data, $format);

            return json_encode($wpdb->insert_id);
        } catch (Exception $e) {
            return json_encode(array("errore" => $e));
        }
    }

    public function delete_copertina($id_copertina)
    {
        global $wpdb;

        try {
            $wpdb->delete(
                $wpdb->prefix . 'thesis_copertine',
                array('id_copertina' => $id_copertina),
                array('%d')
            );

            return json_encode($wpdb->insert_id);
        } catch (Exception $e) {
            return json_encode(array("errore" => $e));
        }
    }
    public function update_copertina($id_copertina, $nome_copertina, $descrizione_copertina, $anteprima_copertina)
    {
        global $wpdb;

        try {

            $format = array("%s", "%s", "%s");

            $data = array(
                'nome_copertina' => $nome_copertina,
                "descrizione_copertina" => $descrizione_copertina,
                "anteprima_copertina" => $anteprima_copertina
            );

            $wpdb->update(
                $wpdb->prefix . 'thesis_copertine',
                $data,
                array('id_copertina' => $id_copertina),
                $format,
                array('%d'),
            );

            return json_encode($wpdb->insert_id);
        } catch (Exception $e) {
            return json_encode(array("errore" => $e));
        }
    }
}


$copertineDb = new Copertina;
