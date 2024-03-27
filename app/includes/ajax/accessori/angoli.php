<?php

include_once THESIS_DIR . "app/includes/models/angoli.php";

add_action('wp_ajax_post_angoli', 'ajax_post_angoli');
add_action('wp_ajax_get_angoli', 'ajax_get_angoli');
add_action('wp_ajax_delete_angolo', 'ajax_delete_angolo');


function ajax_post_angoli()
{
}

function ajax_get_angoli()
{
    try {
        $angolo = new Angolo;
        $query = $angolo->get_angoli();
        wp_send_json_success(json_encode(array("results" => $query, "message" => "Query effettuata.")), 200);
    } catch (Exception $e) {
        wp_send_json_error("Errore nella richiesta: {$e}", 500);
    }
}

function ajax_delete_angolo()
{
}
