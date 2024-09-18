<?php

include THESIS_DIR . "app/includes/models/pdf/init.php";

add_action('wp_ajax_nopriv_upload_file', 'ajax_upload_file');
add_action('wp_ajax_upload_file', 'ajax_upload_file');

add_action('wp_ajax_clear_all_frontespizi', 'clear_all_frontespizi');
add_action('wp_ajax_nopriv_clear_all_frontespizi', 'clear_all_frontespizi');

add_action('wp_ajax_nopriv_upload_frontespizio', 'ajax_upload_frontespizio');
add_action('wp_ajax_upload_frontespizio', 'ajax_upload_frontespizio');

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

add_action('wp_ajax_thesis_clear_files', 'thesis_clear_files');

add_action('wp_ajax_nopriv_upload_cd_file', 'ajax_upload_cd_file');
add_action('wp_ajax_upload_cd_file', 'ajax_upload_cd_file');

add_action('wp_ajax_nopriv_remove_cd_file', 'ajax_remove_cd_file');
add_action('wp_ajax_remove_cd_file', 'ajax_remove_cd_file');


function uuidv4()
{
    $data = random_bytes(16);

    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

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

        if (!is_dir(THESIS_FILES . "/" . $tmp_folder)) {
            mkdir(THESIS_FILES . "/" . $tmp_folder, 0755, true);
        }

        $upload_dir = THESIS_FILES . "/" . $tmp_folder;
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

function ajax_genera_pagine()
{

    $data = $_POST['data'];

    $numPagina = $data['num_pagina'];
    $tmp_folder = $data['uuid'];
    $upload_dir = THESIS_FILES . "/" . $tmp_folder;

    if (!is_dir($upload_dir . "/pagine")) {
        mkdir($upload_dir . "/pagine", 0755, true);
    }

    $process = new ThesisProcess;

    $process->genera_pagine($upload_dir . "/tesi.pdf", $upload_dir . "/pagine", $numPagina);

    wp_send_json_success(json_encode(array("message" => "Pagina generata.", "pagina" => $numPagina)), 200);
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
    $upload_dir = str_replace('\\', '/', THESIS_FILES . "/" . $uuid);

    $process = new ThesisProcess;

    $query = $process->get_num_pagine($upload_dir . "/tesi.pdf");

    wp_send_json_success(json_encode(array("results" => $query)));
}


function ajax_upload_cd_file() {
    $nonce = $_POST['nonce'];

    $token = $_COOKIE['thesis_session'];

    $verify = wp_verify_nonce($nonce, 'thesis-token');

    if (!$verify) {
        wp_die("Nonce not verified.", 'thesis', array('response' => 403));
    } else if (!$token) {
        wp_die("Token not found.", 'thesis', array('response' => 403));
    }

    if($_FILES['file']) {
        $file = $_FILES['file'];
        $file_name = basename($file['name']);
        $file_tmp = $file['tmp_name'];

        $tmp_folder = $token;

        $upload_dir = THESIS_FILES . "/" . $tmp_folder;

        if(!is_dir($upload_dir . "/file_aggiuntivi")) {
            mkdir($upload_dir . "/file_aggiuntivi", 0755, true);
        }

        $destination = $upload_dir . "/file_aggiuntivi/" . $file_name;

        if(move_uploaded_file($file_tmp, $destination)) {
            echo json_encode(array('success' => true, 'message' => 'File caricato correttamente.'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Si è verificato un errore durante il caricamento del file.'));
        }
    } else {
        echo json_encode(array('success' => false, 'message' => 'Nessun file inviato.'));
    }
}

function ajax_remove_cd_file(){
    $nonce = $_POST['nonce'];

    $token = $_COOKIE['thesis_session'];

    $verify = wp_verify_nonce($nonce, 'thesis-token');

    if (!$verify) {
        wp_die("Nonce not verified.", 'thesis', array('response' => 403));
    } else if (!$token) {
        wp_die("Token not found.", 'thesis', array('response' => 403));
    }

    $file = $_POST['filename'];

    $tmp_folder = $token;

    $upload_dir = THESIS_FILES . "/" . $tmp_folder;

    $destination = $upload_dir . "/file_aggiuntivi/" . $file;

    if(unlink($destination)) {
        echo json_encode(array('success' => true, 'message' => 'File rimosso correttamente.'));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Si è verificato un errore durante la rimozione del file.'));
    }
}


function clear_all_frontespizi()
{

    if (!$_COOKIE['thesis_session']) {
        wp_die("Sessione non valida.");
    }

    $frontespizi = THESIS_FILES . "/" . $_COOKIE['thesis_session'] . "/frontespizi";

    $files = glob($frontespizi . '/*');

    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }
}

function rrmdir($dir)
{
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (filetype($dir . "/" . $object) == "dir") {
                    rrmdir($dir . "/" . $object);
                } else {
                    unlink($dir . "/" . $object);
                }

            }
        }
        reset($objects);
        rmdir($dir);
    }
}

function thesis_clear_files()
{
    rrmdir(THESIS_FILES);
    mkdir(THESIS_FILES, 0755, true);
}


