<?php

class Angolo
{

    public function get_angoli($id = null)
    {
        global $wpdb;

        if (!$id) {
            $query = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "thesis_angoli");
            return json_encode($query);
        } else {
            $query = $wpdb->get_results(
                $wpdb->prepare("SELECT * FROM {$wpdb->prefix}thesis_angoli WHERE id_angolo = {$id}")
            );
            return json_encode($query);
        }
    }

    public function post_angolo($data)
    {
        global $wpdb;

        $wpdb->insert(
            $wpdb->prefix . "thesis_angoli",
            [
                'nome_angolo' => $data['nome'],
                'anteprima_angolo' => $data['immagine']
            ]
        );

        return json_encode(['status' => 'success', 'message' => 'Angolo aggiunto correttamente']);
    }

    public function update_angolo($data)
    {
        global $wpdb;

        $wpdb->update(
            $wpdb->prefix . "thesis_angoli",
            [
                'nome' => $data['nome'],
                'prezzo' => $data['prezzo'],
                'descrizione' => $data['descrizione'],
                'immagine' => $data['immagine']
            ],
            ['id_angolo' => $data['id']]
        );

        return json_encode(['status' => 'success', 'message' => 'Angolo modificato correttamente']);
    }

    public function delete_angolo($id)
    {
        global $wpdb;

        $wpdb->delete(
            $wpdb->prefix . "thesis_angoli",
            ['id_angolo' => $id],
            ['%d']
        );

        return json_encode(['status' => 'success', 'message' => 'Angolo eliminato correttamente']);
    }
}
