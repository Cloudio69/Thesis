<?php

include THESIS_DIR . "app/includes/models/pdf/init.php";

add_action('wp_ajax_nopriv_upload_file', 'ajax_upload_file');
add_action('wp_ajax_upload_file', 'ajax_upload_file');

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

    if (!$verify) wp_die("Nonce not verified.");

    if ($_FILES['file']) {
        $file = $_FILES['file'];
        $file_name = $file['name'];
        $file_tmp = $file['tmp_name'];

        $tmp_folder = uuidv4();

        mkdir(THESIS_PDFS . "/" . $tmp_folder, 0755, true);

        $upload_dir = THESIS_PDFS . "/" . $tmp_folder;
        $destination = $upload_dir . '/' . $file_name;

        if (move_uploaded_file($file_tmp, $destination)) {

            $process = new ThesisProcess;
            $process->process_frontespizio($file_name, $upload_dir);
            
            echo json_encode(array('success' => true, 'message' => 'File caricato correttamente.', 'thesis_session' => $tmp_folder, "process" => $process));
        } else {
            // Errore durante il caricamento del file
            echo json_encode(array('success' => false, 'message' => 'Si è verificato un errore durante il caricamento del file.'));
        }
    } else {
        // Nessun file è stato inviato
        echo json_encode(array('success' => false, 'message' => 'Nessun file inviato.'));
    }
    // Assicurati di terminare lo script
    wp_die();
}
