<?php

include_once THESIS_DIR . "app/includes/ajax/accessori/angoli.php";
include_once THESIS_DIR . "app/includes/ajax/accessori/segnalibri.php";
include_once THESIS_DIR . "app/includes/ajax/accessori/grammature.php";

include_once THESIS_DIR . "app/includes/models/rilegature.php";
include_once THESIS_DIR . "app/includes/models/variazioni.php";
include_once THESIS_DIR . "app/includes/models/colore-caratteri.php";

add_action('wp_ajax_post_rilegature', 'ajax_post_rilegature');
add_action('wp_ajax_get_rilegature', 'ajax_get_rilegature');
add_action('wp_ajax_delete_rilegatura', 'ajax_delete_rilegatura');
add_action('wp_ajax_update_rilegatura', 'ajax_update_rilegatura');

add_action('wp_ajax_post_variante', 'ajax_post_variante');
add_action('wp_ajax_get_varianti', 'ajax_get_varianti');
add_action('wp_ajax_delete_variante', 'ajax_delete_variante');
add_action('wp_ajax_update_variante', 'ajax_update_variante');

add_action('wp_ajax_get_char_colors', 'ajax_get_char_colors');
add_action('wp_ajax_post_char_colors', 'ajax_post_char_colors');
add_action('wp_ajax_delete_char_colors', 'ajax_delete_char_colors');

add_action('wp_ajax_get_char_assoc', 'ajax_get_char_assoc');
add_action('wp_ajax_delete_char_assoc', "ajax_delete_char_assoc");
add_action('wp_ajax_post_color_assoc', "ajax_post_color_assoc");

function ajax_post_rilegature()
{
    $data = $_POST['data'];

    try {
        $rilegatura = new Rilegatura;
        $query = $rilegatura->create_rilegatura(
            $data['nome_rilegatura'],
            $data['desc_rilegatura'],
            sanitize_text_field($data['url_rilegatura']),
            sanitize_text_field($data['prezzo_rilegatura']),
            sanitize_text_field($data['angoli'])
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
            $data['nome_rilegatura'],
            $data['desc_rilegatura'],
            sanitize_text_field($data['url_rilegatura']),
            sanitize_text_field($data['prezzo_rilegatura']),
            $data['angoli']
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

    $id = $data['id_variante'];

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

function ajax_post_char_colors()
{
    $data = $_POST['data'];

    try {
        $charcolors = new CharColors;
        $query = $charcolors->post_char_colors(
            sanitize_text_field($data['nome_colore']),
            sanitize_text_field($data['hex_colore']),
        );
        wp_send_json_success(json_encode(array("results" => $query, "message" => "Inserito con successo.")), 200);
    } catch (Exception $e) {
        wp_send_json_error("Errore nella richiesta: {$e}", 500);
    }
}

function ajax_delete_char_colors()
{
    $data = $_POST['data'];

    try {
        $charcolors = new CharColors;
        $query = $charcolors->delete_char_colors(
            $data['id_colore_carattere']
        );
        wp_send_json_success(json_encode(array("results" => $query, "message" => "Query effettuata.")), 200);
    } catch (Exception $e) {
        wp_send_json_error("Errore nella richiesta: {$e}", 500);
    }
}


function ajax_get_char_assoc()
{
    try {
        $charcolors = new CharColors;
        $query = $charcolors->get_char_assoc();
        wp_send_json_success(json_encode(array("results" => $query, "message" => "Query effettuata.")), 200);
    } catch (Exception $e) {
        wp_send_json_error("Errore nella richiesta: {$e}", 500);
    }
}

function ajax_post_color_assoc()
{
    $data = $_POST['data'];

    try {
        $charcolors = new CharColors;
        $query = $charcolors->post_char_assoc(
            $data['id_rilegatura'],
            $data['id_colore_carattere']
        );
        wp_send_json_success(json_encode(array("results" => $query, "message" => "Query effettuata.")), 200);
    } catch (Exception $e) {
        wp_send_json_error("Errore nella richiesta: {$e}", 500);
    }
}

function ajax_delete_char_assoc()
{
    $data = $_POST['data'];

    try {
        $charcolors = new CharColors;
        $query = $charcolors->delete_char_assoc(
            $data['id_associazione']
        );
        wp_send_json_success(json_encode(array("results" => $query, "message" => "Query effettuata.")), 200);
    } catch (Exception $e) {
        wp_send_json_error("Errore nella richiesta: {$e}", 500);
    }
}
