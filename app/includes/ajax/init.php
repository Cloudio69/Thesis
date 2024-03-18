<?php

include_once THESIS_DIR . "app/includes/models/copertine.php";
include_once THESIS_DIR . "app/includes/models/variants.php";

add_action('wp_ajax_post_copertine', 'ajax_post_copertine');
add_action('wp_ajax_get_copertine', 'ajax_get_copertine');
add_action('wp_ajax_delete_copertina', 'ajax_delete_copertina');
add_action('wp_ajax_update_copertina', 'ajax_update_copertina');

add_action('wp_ajax_post_variante', 'ajax_post_variante');
add_action('wp_ajax_get_varianti', 'ajax_get_varianti');
add_action('wp_ajax_delete_variante', 'ajax_delete_variante');
add_action('wp_ajax_update_variante', 'ajax_update_variante');

function ajax_post_copertine()
{
    $data = $_POST['data'];

    if (empty($data['nome_copertina']) || empty($data['desc_copertina']) || empty($data['url_copertina']))
        return wp_send_json_error("Errore: alcuni campi sono vuoti" . var_dump($data), 400);

    try {
        $copertina = new Copertina;
        $query = $copertina->create_copertina(
            sanitize_text_field($data['nome_copertina']),
            sanitize_text_field($data['desc_copertina']),
            sanitize_text_field($data['url_copertina'])
        );
        wp_send_json_success(json_encode(array("id_query" => $query, "message" => "Inserito correttamente")), 200);
    } catch (Exception $e) {
        wp_send_json_error("Errore nella richiesta: {$e}", 500);
    }
}

function ajax_get_copertine()
{
    try {
        $copertina = new Copertina;
        $query = $copertina->get_copertine();
        wp_send_json_success(json_encode(array("results" => $query, "message" => "Query effettuata.")), 200);
    } catch (Exception $e) {
        wp_send_json_error("Errore nella richiesta: {$e}", 500);
    }
}

function ajax_delete_copertina()
{
    $data = $_POST['data'];

    $id = $data['id_copertina'];

    try {
        $copertina = new Copertina;
        $query = $copertina->delete_copertina($id);
        wp_send_json_success(json_encode(array("results" => $query, "message" => "Query effettuata.")), 200);
    } catch (Exception $e) {
        wp_send_json_error("Errore nella richiesta: {$e}", 500);
    }
}

function ajax_update_copertina()
{
    $data = $_POST['data'];

    $id = $data['id_copertina'];

    try {
        $copertina = new Copertina;
        $query = $copertina->update_copertina(
            $id,
            sanitize_text_field($data['nome_copertina']),
            sanitize_text_field($data['desc_copertina']),
            sanitize_text_field($data['url_copertina'])
        );
        wp_send_json_success(json_encode(array("results" => $query, "message" => "Aggiornato con successo.")), 200);
    } catch (Exception $e) {
        wp_send_json_error("Errore nella richiesta: {$e}", 500);
    }
}
