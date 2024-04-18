<?php

include THESIS_DIR . "app/includes/models/pdf/init.php";

add_action('wp_ajax_nopriv_upload_file', 'ajax_upload_file');
add_action('wp_ajax_upload_file', 'ajax_upload_file');

add_action('wp_ajax_get_options', 'ajax_get_options');
add_action('wp_ajax_nopriv_get_options', 'ajax_get_options');

add_action('wp_ajax_genera_frontespizio', 'ajax_genera_frontespizio');
add_action('wp_ajax_nopriv_genera_frontespizio', 'ajax_genera_frontespizio');

add_action('wp_ajax_get_colori_carattere', 'ajax_get_colori_carattere');
add_action('wp_ajax_nopriv_get_colori_carattere', 'ajax_get_colori_carattere');

add_action('wp_ajax_genera_pagine', 'ajax_genera_pagine');
add_action('wp_ajax_nopriv_genera_pagine', 'ajax_genera_pagine');

add_action('wp_ajax_get_num_pagine', 'ajax_get_num_pagine');
add_action('wp_ajax_nopriv_get_num_pagine', 'ajax_get_num_pagine');

function uuidv4()
{
    $data = random_bytes(16);

    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

function ajax_upload_file()
{
    $nonce = $_POST['nonce'];

    $verify = wp_verify_nonce($nonce, 'thesis-token');

    if (!$verify) {
        wp_die("Nonce not verified.");
    }

    if ($_FILES['file']) {
        $file = $_FILES['file'];
        $file_name = 'tesi.pdf';
        $file_tmp = $file['tmp_name'];

        $tmp_folder = uuidv4();

        mkdir(THESIS_PDFS . "/" . $tmp_folder, 0755, true);

        $upload_dir = THESIS_PDFS . "/" . $tmp_folder;
        $destination = $upload_dir . '/' . $file_name;

        if (move_uploaded_file($file_tmp, $destination)) {
            echo json_encode(array('success' => true, 'message' => 'File caricato correttamente.', 'thesis_session' => $tmp_folder));
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

function ajax_get_options()
{
    $rilegatura = new Rilegatura;
    $query = $rilegatura->get_full_data_rilegature();

    wp_send_json_success(json_encode(array("results" => $query, "message" => "Query effettuata.")), 200);
}

function ajax_genera_frontespizio()
{
    $data = $_POST['data'];

    [$r, $g, $b] = $data['rgb'];

    $tmp_folder = $data['uuid'];
    $upload_dir = THESIS_PDFS . "/" . $tmp_folder;

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

function ajax_genera_pagine(){

    $data = $_POST['data'];

    $numPagina = $data['num_pagina'];
    $tmp_folder = $data['uuid'];
    $upload_dir = THESIS_PDFS . "/" . $tmp_folder;

    if (!is_dir($upload_dir . "/pagine")) {
        mkdir($upload_dir . "/pagine", 0755, true);
    }

    $process = new ThesisProcess;

    $process->genera_pagine($upload_dir . "/tesi.pdf", $upload_dir . "/pagine", $data['num_pagina']);

    wp_send_json_success(json_encode(array("message" => "Pagina generata.")), 200);
}

function ajax_get_colori_carattere()
{
    $data = $_GET['data'];

    $rilegatura = new Rilegatura;
    $query = $rilegatura->get_colori_carattere($data['id_rilegatura']);

    wp_send_json_success(json_encode(array("results" => $query)));
}

function ajax_get_num_pagine()
{
    $uuid = $_GET['uuid'];
    $upload_dir = str_replace('\\', '/', THESIS_PDFS . "/" . $uuid);

    $process = new ThesisProcess;

    $query = $process->get_num_pagine($upload_dir . "/tesi.pdf");
    
    wp_send_json_success(json_encode(array("results" => $query)));
}
