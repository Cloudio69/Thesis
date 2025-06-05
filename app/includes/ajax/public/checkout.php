<?php

include_once(THESIS_DIR . 'app/includes/ajax/woocommerce/init.php');

add_action('wp_ajax_validate_user_info', 'validate_user_info');
add_action('wp_ajax_nopriv_validate_user_info', 'validate_user_info');
add_action('wp_ajax_thesis_get_shipping_cost', 'get_shipping_cost');
add_action('wp_ajax_nopriv_thesis_get_shipping_cost', 'get_shipping_cost');


function validate_user_info()
{

    $nonce = isset($_POST['nonce']) ? $_POST['nonce'] : '';

    if (!wp_verify_nonce($nonce, 'thesis-token')) {
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
    $spedizione = sanitize_text_field($_POST['spedizione']);

    $cart = isset($_POST['cart']) ? json_decode(stripslashes($_POST['cart']), true) : [];

    if (json_last_error() !== JSON_ERROR_NONE) {
        wp_send_json_error(array('message' => 'Errore nel formato del carrello'), 400);
    }

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

    if (empty($spedizione)) {
        $errors['spedizione'] = 'Spedizione è richiesta';
    }

    if (empty($cart)) {
        $errors['cart'] = 'Carrello è vuoto';
    }

    if (!empty($errors)) {
        wp_send_json_error($errors, 400);
    }

    wc_thesis_create_order([
        'nome' => $nome,
        'cognome' => $cognome,
        'email' => $email,
        'telefono' => $telefono,
        'provincia' => $provincia,
        'indirizzo' => $indirizzo,
        'citta' => $citta,
        'codice_postale' => $codice_postale,
        'spedizione' => $spedizione,
        'cart' => $cart
    ]);

    wp_send_json_success(array("message" => "I campi sono validi"), 200);
}

function get_shipping_cost()
{
    $nonce = isset($_POST['nonce']) ? $_POST['nonce'] : '';

    if (!wp_verify_nonce($nonce, 'thesis-token')) {
        wp_send_json_error(array('message' => 'Nonce verification failed', 'nonce' => $_POST['nonce']), 403);
    }

    $zones_store = WC_Data_Store::load('shipping-zone');

    $zones = $zones_store->get_zones();

    $zip_code = $_POST['codice_postale'];
    $city = $_POST['citta'];
    $province = $_POST['provincia'];

    $shipping_cost = 0;

    $check_disagiate = check_zone_disagiate($zip_code);

    $check_isole = check_zone_isole($province);

    

    if ($shipping_cost == 0) {
        foreach ($zones as $zone) {
            if (strpos(strtolower($zone->zone_name), 'italia') !== false) {
                $shipping_methods = WC_Shipping_Zones::get_zone($zone->zone_id)->get_shipping_methods();
                foreach ($shipping_methods as $method) {
                    if ($method->id == 'flat_rate') {
                        $shipping_cost = $method->cost;
                        
                        $res = [];

                        if (is_array($check_disagiate) && count($check_disagiate) > 0) {
                            $res = $check_disagiate;
                        } else if (is_array($check_isole) && count($check_isole) > 0) {
                            $res = $check_isole;
                        } else {
                            $res = [
                                'zone_id' => $zone->zone_id,
                                'zone_name' => $zone->zone_name,
                                'shipping_cost' => $shipping_cost,
                                    'shipping_method' => [
                                    'method_id' => $method->id,
                                    'method_title' => $method->title,
                                    'instance_id' => $method->instance_id,
                                    'cost' => $method->cost,
                                ],
                            ];
                        }
                        
                        $response = $res;
                        
                        return wp_send_json_success($response, 200);
                    }
                }
            }
        }
    }
}


function check_zone_disagiate($zip_code)
{

    $zones_store = WC_Data_Store::load('shipping-zone');

    $zones = $zones_store->get_zones();

    $zone_id = 0;

    foreach ($zones as $zone) {
        $zone_locations = WC_Shipping_Zones::get_zone($zone->zone_id)->get_zone_locations();
        foreach ($zone_locations as $location) {
            if ($location->type == 'postcode' && $location->code == $zip_code) {
                if (strpos(strtolower($zone->zone_name), 'disagiat') !== false) {
                    $zone_id = $zone->zone_id;
                    break;
                }
            }
        }
    }

    if ($zone_id == 0) {
        return;
    }

    $shipping_methods = WC_Shipping_Zones::get_zone($zone_id)->get_shipping_methods();

    foreach ($shipping_methods as $method) {
        if ($method->id == 'flat_rate') {
            $shipping_cost = $method->cost;
            return array(
                'zone_id' => $zone->zone_id,
                'zone_name' => $zone->zone_name,
                'shipping_cost' => $shipping_cost,
                'shipping_method' => array(
                    'method_id' => $method->id,
                    'method_title' => $method->title,
                    'instance_id' => $method->instance_id,
                    'cost' => $method->cost
                )
            );
        }
    }
}

function check_zone_isole($province)
{

    $zones_store = WC_Data_Store::load('shipping-zone');

    $zones = $zones_store->get_zones();

    $zone_id = 0;

    foreach ($zones as $zone) {
        $zone_locations = WC_Shipping_Zones::get_zone($zone->zone_id)->get_zone_locations();
        foreach ($zone_locations as $location) {
            if (strpos(strtolower($zone->zone_name), 'isole') !== false) {
                if ($location->type == 'state' && $location->code == "IT:" . $province) {
                    $zone_id = $zone->zone_id;
                    break 2;
                }
            }
        }
    }

    if ($zone_id == 0) {
        return;
    }

    $shipping_methods = WC_Shipping_Zones::get_zone($zone_id)->get_shipping_methods();

    foreach ($shipping_methods as $method) {
        if ($method->id == 'flat_rate') {
            $shipping_cost = $method->cost;
            return array(
                'zone_id' => $zone->zone_id,
                'zone_name' => $zone->zone_name,
                'shipping_cost' => $shipping_cost,
                'shipping_method' => array(
                    'method_id' => $method->id,
                    'method_title' => $method->title,
                    'instance_id' => $method->instance_id,
                    'cost' => $method->cost
                )
            );
        }
    }
}
