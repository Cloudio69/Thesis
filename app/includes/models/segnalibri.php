<?php

/**
 * Classe Segnalibro
 * 
 * Questa classe contiene i metodi per la gestione dei segnalibri delle tesi
 * 
 * @package Thesis
 * @subpackage Includes/Models
 */

class Segnalibro {

    public function get_segnalibri($id = null)
    {
        global $wpdb;

        if (!$id) {
            $query = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "thesis_segnalibri");
            return json_encode($query);
        } else {
            $query = $wpdb->get_results(
                $wpdb->prepare("SELECT * FROM {$wpdb->prefix}thesis_segnalibri WHERE id_segnalibro = {$id}")
            );
            return json_encode($query);
        }
    }

    public function post_segnalibro($data)
    {
        global $wpdb;

        $wpdb->insert(
            $wpdb->prefix . "thesis_segnalibri",
            [
                'nome_segnalibro' => $data['nome'],
                'anteprima_segnalibro' => $data['immagine']
            ]
        );

        return json_encode(['status' => 'success', 'message' => 'Segnalibro aggiunto correttamente']);
    }

    public function update_segnalibro($data)
    {
        global $wpdb;

        $wpdb->update(
            $wpdb->prefix . "thesis_segnalibri",
            [
                'nome_segnalibro' => $data['nome'],
                'anteprima_segnalibro' => $data['immagine']
            ],
            ['id_segnalibro' => $data['id']]
        );

        return json_encode(['status' => 'success', 'message' => 'Segnalibro modificato correttamente']);
    }

    public function delete_segnalibro($id)
    {
        global $wpdb;

        $wpdb->delete(
            $wpdb->prefix . "thesis_segnalibri",
            ['id_segnalibro' => $id],
            ['%d']
        );

        return json_encode(['status' => 'success', 'message' => 'Segnalibro eliminato correttamente']);
    }
}