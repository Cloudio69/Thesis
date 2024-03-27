<?php

include_once THESIS_DIR . "app/includes/models/grammature.php";

add_action('wp_ajax_post_grammature', 'ajax_post_grammature');
add_action('wp_ajax_get_grammature', 'ajax_get_grammature');
add_action('wp_ajax_delete_grammatura', 'ajax_delete_grammatura');


function ajax_post_grammature()
{
}

function ajax_get_grammature()
{
    try {
        $grammatura = new Grammatura;
        $query = $grammatura->get_grammature();
        wp_send_json_success(json_encode(array("results" => $query, "message" => "Query effettuata.")), 200);
    } catch (Exception $e) {
        wp_send_json_error("Errore nella richiesta: {$e}", 500);
    }
}

function ajax_delete_grammatura()
{
}
