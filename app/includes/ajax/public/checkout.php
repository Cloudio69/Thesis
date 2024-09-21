<?php 

add_action('wp_ajax_validate_user_info', 'validate_user_info');
add_action('wp_ajax_nopriv_validate_user_info', 'validate_user_info');

function validate_user_info() {

    $nonce = isset($_POST['nonce']) ? $_POST['nonce'] : '';

    if (!wp_verify_nonce($_POST['nonce'], 'thesis-token')) {
        wp_send_json_error(array('message' => 'Nonce verification failed', 'nonce' => $_POST['nonce']), 403);
    }

    $errors = [];

    $nome = sanitize_text_field($_POST['nome']);
    $cognome = sanitize_text_field($_POST['cognome']);
    $email = sanitize_email($_POST['email']);
    $telefono = sanitize_text_field($_POST['telefono']);
    $provincia = sanitize_text_field($_POST['provincia']);
    $indirizzo = sanitize_text_field($_POST['indirizzo']);
    $citta = sanitize_text_field($_POST['citta']);
    $codice_postale = sanitize_text_field($_POST['codice_postale']);

    if (empty($nome)) {
        $errors['nome'] = 'Nome è richiesto';
    }

    if (empty($cognome)) {
        $errors['cognome'] = 'Cognome è richiesto';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Formato email non valido';
    }

    if (empty($telefono)) {
        $errors['telefono'] = 'Telefono è richiesto';
    }

    if (empty($provincia)) {
        $errors['provincia'] = 'Provincia è richiesto';
    }

    if (empty($indirizzo)) {
        $errors['indirizzo'] = 'Indirizzo è richiesto';
    }

    if (empty($citta)) {
        $errors['citta'] = 'Città è richiesto';
    }

    if (empty($codice_postale)) {
        $errors['codice_postale'] = 'Codice postale è richiesto';
    }

    if (!empty($errors)) {
        wp_send_json_error($errors, 400);
    }

    wp_send_json_success(array("message" => "I campi sono validi"), 200);
}