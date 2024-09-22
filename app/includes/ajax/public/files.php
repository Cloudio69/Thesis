<?php


function uuidv4()
{
    $data = random_bytes(16);

    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}


add_action('wp_ajax_nopriv_upload_file', 'ajax_upload_file');
add_action('wp_ajax_upload_file', 'ajax_upload_file');

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

add_action('wp_ajax_nopriv_upload_cd_file', 'ajax_upload_cd_file');
add_action('wp_ajax_upload_cd_file', 'ajax_upload_cd_file');

function ajax_upload_cd_file()
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
        $file_name = basename($file['name']);
        $file_tmp = $file['tmp_name'];

        $tmp_folder = $token;

        $upload_dir = THESIS_FILES . "/" . $tmp_folder;

        if (!is_dir($upload_dir . "/file_aggiuntivi")) {
            mkdir($upload_dir . "/file_aggiuntivi", 0755, true);
        }

        $destination = $upload_dir . "/file_aggiuntivi/" . $file_name;

        if (move_uploaded_file($file_tmp, $destination)) {
            echo json_encode(array('success' => true, 'message' => 'File caricato correttamente.'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Si è verificato un errore durante il caricamento del file.'));
        }
    } else {
        echo json_encode(array('success' => false, 'message' => 'Nessun file inviato.'));
    }
}

add_action('wp_ajax_nopriv_upload_cd_cover', 'upload_cd_cover');
add_action('wp_ajax_upload_cd_cover', 'upload_cd_cover');

function upload_cd_cover()
{
    $nonce = $_POST['nonce'];

    $token = $_COOKIE['thesis_session'];

    $verify = wp_verify_nonce($nonce, 'thesis-token');

    if (!$verify) {
        wp_die("Nonce not verified.", 'thesis', array('response' => 403));
    } else if (!$token) {
        wp_die("Token not found.", 'thesis', array('response' => 403));
    }

    if ($_POST['canvas']) {
        $canvas_data = $_POST['canvas'];
        $file_name = 'cd_cover.png';

        $tmp_folder = $token;
        $upload_dir = THESIS_FILES . "/" . $tmp_folder;

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $destination = $upload_dir . '/' . $file_name;

        // Decode the base64 data
        $canvas_data = str_replace('data:image/png;base64,', '', $canvas_data);
        $canvas_data = str_replace(' ', '+', $canvas_data);
        $file_data = base64_decode($canvas_data);

        if (file_put_contents($destination, $file_data)) {
            $destination_url = get_site_url() . "/wp-content/plugins/thesis/app/files/" . $token . "/" . $file_name;
            echo json_encode(array('success' => true, 'message' => 'File caricato correttamente.', 'url' => $destination_url));
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

add_action('wp_ajax_nopriv_remove_cd_file', 'ajax_remove_cd_file');
add_action('wp_ajax_remove_cd_file', 'ajax_remove_cd_file');

function ajax_remove_cd_file()
{
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

    if (unlink($destination)) {
        echo json_encode(array('success' => true, 'message' => 'File rimosso correttamente.'));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Si è verificato un errore durante la rimozione del file.'));
    }
}

add_action('wp_ajax_clear_all_frontespizi', 'clear_all_frontespizi');
add_action('wp_ajax_nopriv_clear_all_frontespizi', 'clear_all_frontespizi');

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

add_action('wp_ajax_thesis_clear_files', 'thesis_clear_files');

function thesis_clear_files()
{
    rrmdir(THESIS_FILES);
    mkdir(THESIS_FILES, 0755, true);
}
