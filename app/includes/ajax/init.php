<?php

include_once THESIS_DIR . "app/includes/models/copertine.php";

add_action('wp_ajax_post_copertine', 'ajax_post_copertine');

function ajax_post_copertine()
{
    try {
        $copertina = new Copertina;
        $query = $copertina->create_copertina("Prova", "Prova", "ProvaURL");
        wp_send_json_success("Inserito correttamente: {$query}", 200);
    } catch (Exception $e) {
        wp_send_json_error("Errore nella richiesta: {$e}", 500);
    }
}
