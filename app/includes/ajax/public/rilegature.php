<?php

add_action('wp_ajax_nopriv_upload_frontespizio', 'ajax_upload_frontespizio');
add_action('wp_ajax_upload_frontespizio', 'ajax_upload_frontespizio');

function ajax_upload_frontespizio()
{
    $nonce = $_POST['nonce'];

    $token = $_COOKIE['thesis_session'];

    $verify = wp_verify_nonce($nonce, 'thesis-token');

    if (!$verify) {
        wp_die("Nonce not verified.", 'thesis', array('response' => 403));
    } else if (!$token) {
        wp_die("Token not found.", 'thesis', array('response' => 403));
    }

    if ($_FILES['file']) {
        $file = $_FILES['file'];
        $file_name = 'frontespizio.pdf';
        $file_tmp = $file['tmp_name'];

        $tmp_folder = $token;

        $upload_dir = THESIS_FILES . "/" . $tmp_folder;
        $destination = $upload_dir . '/' . $file_name;

        if (move_uploaded_file($file_tmp, $destination)) {
            $process = new ThesisProcess;
            $process->process_frontespizio($file_name, $upload_dir);

            echo json_encode(array('success' => true, 'message' => 'File caricato correttamente.'));
        } else {
            // Errore durante il caricamento del file
            echo json_encode(array('success' => false, 'message' => 'Si è verificato un errore durante il caricamento del file.'));
        }
    } else {
        // Nessun file è stato inviato
        echo json_encode(array('success' => false, 'message' => 'Nessun file inviato.'));
    }
    wp_die();
}

add_action('wp_ajax_get_options', 'ajax_get_options');
add_action('wp_ajax_nopriv_get_options', 'ajax_get_options');

function ajax_get_options()
{
    $rilegatura = new Rilegatura;
    $query = $rilegatura->get_full_data_rilegature();

    wp_send_json_success(json_encode(array("results" => $query, "message" => "Query effettuata.")), 200);
}

add_action('wp_ajax_genera_frontespizio', 'ajax_genera_frontespizio');
add_action('wp_ajax_nopriv_genera_frontespizio', 'ajax_genera_frontespizio');

function ajax_genera_frontespizio()
{
    $data = $_POST['data'];

    [$r, $g, $b] = $data['rgb'];

    $tmp_folder = $data['uuid'];
    $upload_dir = THESIS_FILES . "/" . $tmp_folder;

    if (!is_dir($upload_dir . "/frontespizi")) {
        mkdir($upload_dir . "/frontespizi", 0755, true);
    }

    $process = new ThesisProcess;

    if (!isset($data['id'])) {
        $process->genera_frontespizio($upload_dir . "/frontespizio.jpg", $r, $g, $b, $upload_dir . "/frontespizio_generato.png");
    } else {
        if (!file_exists($upload_dir . "/frontespizi/frontespizio_generato-" . $data['id'] . ".png")) {
            $process->genera_frontespizio($upload_dir . "/frontespizio.jpg", $r, $g, $b, $upload_dir . "/frontespizi/frontespizio_generato-" . $data['id'] . ".png");
        }
    }

    wp_send_json_success(json_encode(array("message" => "Frontespizio generato.")), 200);
}

add_action('wp_ajax_get_colori_carattere', 'ajax_get_colori_carattere');
add_action('wp_ajax_nopriv_get_colori_carattere', 'ajax_get_colori_carattere');

function ajax_get_colori_carattere()
{
    $data = $_GET['data'];

    $rilegatura = new Rilegatura;
    $query = $rilegatura->get_colori_carattere($data['id_rilegatura']);

    wp_send_json_success(json_encode(array("results" => $query)));
}
