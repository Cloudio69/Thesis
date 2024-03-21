<?php

include_once THESIS_DIR . "app/includes/models/rilegature.php";
include_once THESIS_DIR . "app/includes/models/variants.php";
include_once THESIS_DIR . "app/includes/models/char-colors.php";

add_action('wp_ajax_post_rilegature', 'ajax_post_rilegature');
add_action('wp_ajax_get_rilegature', 'ajax_get_rilegature');
add_action('wp_ajax_delete_rilegatura', 'ajax_delete_rilegatura');
add_action('wp_ajax_update_rilegatura', 'ajax_update_rilegatura');

add_action('wp_ajax_post_variante', 'ajax_post_variante');
add_action('wp_ajax_get_varianti', 'ajax_get_varianti');
add_action('wp_ajax_delete_variante', 'ajax_delete_variante');
add_action('wp_ajax_update_variante', 'ajax_update_variante');

add_action('wp_ajax_get_char_colors', 'ajax_get_char_colors');

function ajax_post_rilegature()
{
    $data = $_POST['data'];

    if (empty($data['nome_rilegatura']) || empty($data['desc_rilegatura']) || empty($data['url_rilegatura']))
        return wp_send_json_error("Errore: alcuni campi sono vuoti" . var_dump($data), 400);

    try {
        $rilegatura = new Rilegatura;
        $query = $rilegatura->create_rilegatura(
            sanitize_text_field($data['nome_rilegatura']),
            sanitize_text_field($data['desc_rilegatura']),
            sanitize_text_field($data['url_rilegatura'])
        );
        wp_send_json_success(json_encode(array("id_query" => $query, "message" => "Inserito correttamente")), 200);
    } catch (Exception $e) {
        wp_send_json_error("Errore nella richiesta: {$e}", 500);
    }
}

function ajax_get_rilegature()
{
    try {
        $rilegatura = new Rilegatura;
        $query = $rilegatura->get_rilegature();
        wp_send_json_success(json_encode(array("results" => $query, "message" => "Query effettuata.")), 200);
    } catch (Exception $e) {
        wp_send_json_error("Errore nella richiesta: {$e}", 500);
    }
}

function ajax_delete_rilegatura()
{
    $data = $_POST['data'];

    $id = $data['id_rilegatura'];

    try {
        $rilegatura = new Rilegatura;
        $query = $rilegatura->delete_rilegatura($id);
        wp_send_json_success(json_encode(array("results" => $query, "message" => "Query effettuata.")), 200);
    } catch (Exception $e) {
        wp_send_json_error("Errore nella richiesta: {$e}", 500);
    }
}

function ajax_update_rilegatura()
{
    $data = $_POST['data'];

    $id = $data['id_rilegatura'];

    try {
        $rilegatura = new Rilegatura;
        $query = $rilegatura->update_rilegatura(
            $id,
            sanitize_text_field($data['nome_rilegatura']),
            sanitize_text_field($data['desc_rilegatura']),
            sanitize_text_field($data['url_rilegatura'])
        );
        wp_send_json_success(json_encode(array("results" => $query, "message" => "Aggiornato con successo.")), 200);
    } catch (Exception $e) {
        wp_send_json_error("Errore nella richiesta: {$e}", 500);
    }
}

function ajax_get_varianti()
{
    try {
        $varianti = new Variante;
        $query = $varianti->get_varianti();
        wp_send_json_success(json_encode(array("results" => $query, "message" => "Query effettuata.")), 200);
    } catch (Exception $e) {
        wp_send_json_error("Errore nella richiesta: {$e}", 500);
    }
}

function ajax_post_variante()
{

    $data = $_POST['data'];

    try {
        $varianti = new Variante;
        $query = $varianti->create_variante(
            sanitize_text_field($data['id_rilegatura']),
            sanitize_text_field($data['nome_variante']),
            sanitize_text_field($data['codice_colore']),
            sanitize_text_field($data['url_variante'])
        );
        wp_send_json_success(json_encode(array("results" => $query, "message" => "Query effettuata.")), 200);
    } catch (Exception $e) {
        wp_send_json_error("Errore nella richiesta: {$e}", 500);
    }
}

function ajax_delete_variante()
{
    $data = $_POST['data'];

    $id = $data['id_variazione'];

    try {
        $variante = new Variante;
        $query = $variante->delete_variante($id);
        wp_send_json_success(json_encode(array("results" => $query, "message" => "Query effettuata.")), 200);
    } catch (Exception $e) {
        wp_send_json_error("Errore nella richiesta: {$e}", 500);
    }
}

function ajax_update_variante()
{
    $data = $_POST['data'];

    $id = $data['id_variante'];

    try {
        $variante = new Variante;
        $query = $variante->update_variante(
            $id,
            sanitize_text_field($data['nome_variante']),
            sanitize_text_field($data['codice_colore']),
            sanitize_text_field($data['url_variante'])
        );
        wp_send_json_success(json_encode(array("results" => $query, "message" => "Aggiornato con successo.")), 200);
    } catch (Exception $e) {
        wp_send_json_error("Errore nella richiesta: {$e}", 500);
    }
}


function ajax_get_char_colors()
{
    try {
        $colori = new CharColors;
        $query = $colori->get_char_colors();
        wp_send_json_success(json_encode(array("results" => $query, "message" => "Query effettuata.")), 200);
    } catch (Exception $e) {
        wp_send_json_error("Errore nella richiesta: {$e}", 500);
    }
}
