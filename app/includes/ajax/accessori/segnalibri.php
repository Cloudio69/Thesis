<?php

include_once THESIS_DIR . "app/includes/models/segnalibri.php";

add_action('wp_ajax_post_segnalibri', 'ajax_post_segnalibri');
add_action('wp_ajax_get_segnalibri', 'ajax_get_segnalibri');
add_action('wp_ajax_delete_segnalibro', 'ajax_delete_segnalibro');
add_action('wp_ajax_nopriv_get_segnalibri', 'ajax_get_segnalibri');


function ajax_post_segnalibri()
{
    try {
        $segnalibro = new Segnalibro;
        $data = $_POST['data'];
        $query = $segnalibro->post_segnalibro($data);
        wp_send_json_success(json_encode(array("results" => $query, "message" => "Query effettuata.")), 200);
    } catch (Exception $e) {
        wp_send_json_error("Errore nella richiesta: {$e}", 500);
    }
}

function ajax_get_segnalibri()
{
    try {
        $segnalibro = new Segnalibro;
        $query = $segnalibro->get_segnalibri();
        wp_send_json_success(json_encode(array("results" => $query, "message" => "Query effettuata.")), 200);
    } catch (Exception $e) {
        wp_send_json_error("Errore nella richiesta: {$e}", 500);
    }
}

function ajax_delete_segnalibro()
{
    try {
        $segnalibro = new Segnalibro;
        $data = $_POST['data'];
        $query = $segnalibro->delete_segnalibro($data['id']);
        wp_send_json_success(json_encode(array("results" => $query, "message" => "Query effettuata.")), 200);
    } catch (Exception $e) {
        wp_send_json_error("Errore nella richiesta: {$e}", 500);
    }
}
