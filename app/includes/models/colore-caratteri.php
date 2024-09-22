<?php

/**
 * Classe CharColors
 * 
 * Questa classe contiene i metodi per la gestione dei colori dei caratteri delle tesi
 * 
 * @package Thesis
 * @subpackage Includes/Models
 * 
 * 
 */

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

    public function get_char_assoc($id = null)
    {
        global $wpdb;

        if (!$id) {
            $query = $wpdb->get_results(
                "SELECT r.id_rilegatura, r.nome_rilegatura, tcc.id_colore_carattere, tcc.nome_colore, tcc.hex_colore, cca.id_associazione
                FROM " . $wpdb->prefix . "thesis_rilegature r
                JOIN " . $wpdb->prefix . "thesis_color_assoc cca ON r.id_rilegatura = cca.id_rilegatura
                JOIN " . $wpdb->prefix . "thesis_colori_carattere tcc ON cca.id_colore_carattere = tcc.id_colore_carattere;"
            );
            return json_encode($query);
        }
    }

    public function delete_char_assoc($id)
    {
        global $wpdb;

        try {
            $data = array('id_associazione' => $id);
            $format = array("%d");

            $wpdb->delete($wpdb->prefix . 'thesis_color_assoc', $data, $format);

            return json_encode($data);
        } catch (Exception $e) {
            return json_encode(array("errore" => $e));
        }
    }

    public function post_char_assoc($id_rilegatura, $id_colore_carattere)
    {
        global $wpdb;

        try {
            $data = array(
                'id_rilegatura' => $id_rilegatura,
                "id_colore_carattere" => $id_colore_carattere
            );

            $format = array("%d", "%d");

            $wpdb->insert($wpdb->prefix . 'thesis_color_assoc', $data, $format);

            return json_encode(array($wpdb->insert_id, $data));
        } catch (Exception $e) {
            return json_encode(array("errore" => $e));
        }
    }
}
