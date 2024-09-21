<?php

/**
 * Classe Grammatura
 * 
 * Questa classe contiene i metodi per la gestione delle grammature  delle pagine
 * 
 * @package Thesis
 * @subpackage Includes/Models
 * 
 * 
 */

class Grammatura {

    public function get_grammature($id = null)
    {
        global $wpdb;

        if (!$id) {
            $query = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "thesis_grammature");
            return json_encode($query);
        } else {
            $query = $wpdb->get_results(
                $wpdb->prepare("SELECT * FROM {$wpdb->prefix}thesis_grammature WHERE id_grammatura = {$id}")
            );
            return json_encode($query);
        }
    }

    public function post_grammatura($data)
    {
        global $wpdb;

        $wpdb->insert(
            $wpdb->prefix . "thesis_grammature",
            [
                'nome_grammatura' => $data['nome'],
                'prezzo_grammatura' => $data['prezzo'],
            ]
        );

        return json_encode(['status' => 'success', 'message' => 'Grammatura aggiunta correttamente']);
    }

    public function update_grammatura($data)
    {
        global $wpdb;

        $wpdb->update(
            $wpdb->prefix . "thesis_grammature",
            [
                'nome_grammatura' => $data['nome'],
                'prezzo_grammatura' => $data['prezzo'],
            ],
            ['id_grammatura' => $data['id']]
        );

        return json_encode(['status' => 'success', 'message' => 'Grammatura modificata correttamente']);
    }

    public function delete_grammatura($id)
    {
        global $wpdb;

        $wpdb->delete(
            $wpdb->prefix . "thesis_grammature",
            ['id_grammatura' => $id],
            ['%d']
        );

        return json_encode(['status' => 'success', 'message' => 'Grammatura eliminata correttamente']);
    }
}