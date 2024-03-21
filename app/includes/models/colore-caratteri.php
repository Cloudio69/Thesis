<?php

class CharColors
{

    public function get_char_colors($id = null)
    {
        global $wpdb;

        if (!$id) {
            $query = $wpdb->get_results(
                "SELECT * FROM " . $wpdb->prefix . "thesis_colori_carattere"
            );
            return json_encode($query);
        }
    }

    public function post_char_colors($nome_colore, $hex_colore)
    {
        global $wpdb;

        try {
            $data = array(
                'nome_colore' => $nome_colore,
                "hex_colore" => $hex_colore
            );

            $format = array("%s", "%s");

            $wpdb->insert($wpdb->prefix . 'thesis_colori_carattere', $data, $format);

            return json_encode(array($wpdb->insert_id, $data));
        } catch (Exception $e) {
            return json_encode(array("errore" => $e));
        }
    }
    public function delete_char_colors($id)
    {
        global $wpdb;

        try {
            $data = array('id_colore_carattere' => $id);
            $format = array("%d");

            $wpdb->delete($wpdb->prefix . 'thesis_colori_carattere', $data, $format);

            return json_encode($data);
        } catch (Exception $e) {
            return json_encode(array("errore" => $e));
        }
    }
}
