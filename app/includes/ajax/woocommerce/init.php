<?php

require_once(THESIS_DIR . 'app/includes/generate_pdf.php');

$order = null;
$cart_items = null;

function wc_thesis_create_order($args)
{

    $order = wc_create_order();

    $cart_items = $args['cart'];

    wc_thesis_create_cart($cart_items, $order);

    $billing_data = array(
        'first_name' => $args['nome'],
        'last_name'  => $args['cognome'],
        'email'      => $args['email'],
        'phone'      => $args['telefono'],
        'address_1'  => $args['indirizzo'],
        'city'       => $args['citta'],
        'state'      => $args['provincia'],
        'postcode'   => $args['codice_postale'],
        'country'    => 'IT',
    );
    $order->set_address($billing_data, 'billing');

    $shipping_data = array(
        'first_name' => $args['nome'],
        'last_name'  => $args['cognome'],
        'address_1'  => $args['indirizzo'],
        'city'       => $args['citta'],
        'state'      => $args['provincia'],
        'postcode'   => $args['codice_postale'],
        'country'    => 'IT',
    );
    $order->set_address($shipping_data, 'shipping');

    $spedizione = $args['spedizione'];

    $data_store = WC_Data_Store::load('shipping-zone');
    $raw_zones = $data_store->get_zones();
    foreach ($raw_zones as $raw_zone) {
        $zones[] = new WC_Shipping_Zone($raw_zone);
    }
    $zones[] = new WC_Shipping_Zone(0);

    foreach ($zones as $zone) {
        $shipping_methods = $zone->get_shipping_methods();
        foreach ($shipping_methods as $shipping_method) {
            $instance = $shipping_method->instance_settings;
            if ($shipping_method->is_enabled()) {
                $instance_id = $shipping_method->get_instance_id();

                if ($instance_id == $spedizione) {
                    $spedizione_obj = new WC_Order_Item_Shipping();
                    $spedizione_obj->set_method_title($shipping_method->title);
                    $spedizione_obj->set_instance_id($instance_id);
                    $spedizione_obj->set_total($shipping_method->cost);
                    $order->add_item($spedizione_obj);
                }
            }
        }
    }

    $order->calculate_totals();

    $order->add_order_note("L'ordine è stato creato, in attesa di conferma definitiva.");

    update_post_meta($order->get_id(), '_cart_items', json_encode($cart_items, true));
    update_post_meta($order->get_id(), '_download_zip', THESIS_URL . 'app/files/' . $_COOKIE['thesis_session'] . '/riepilogo_' . $order->get_id() . '.zip');

    $order->save();

    $order_id = $order->get_id();
    $payment_url = $order->get_checkout_payment_url();

    return wp_send_json_success(array('order_id' => $order_id, 'payment_url' => $payment_url, 'products' => $order->get_item_count()), 200);
}


function wc_thesis_create_cart($cart_items, $order)
{
    wc_create_rilegature_products($cart_items, $order);
    wc_create_pagine_product($cart_items, $order);

    if (isset($cd['qty']) < 1 && isset($cd['qty']) != 0) wc_create_cd_product($cart_items, $order);
}

function wc_create_cd_product($cart_items, $order)
{

    $cd = $cart_items['cd'];

    $cd_product = new WC_Product_Simple();
    $cd_product->set_name('CD Serigrafato');
    $cd_product->set_regular_price(get_option('prezzo_cd'));
    $cd_product->set_price(get_option('prezzo_cd'));

    if (isset($cd['qty']) < 1) $cd['qty'] = 1;

    $order_item_id = $order->add_product($cd_product, $cd['qty'], array(
        'subtotal' => get_option('prezzo_cd') * $cd['qty'],
        'total' => get_option('prezzo_cd') * $cd['qty'],
    ));
}

function wc_create_pagine_product($cart_items, $order)
{
    $pagine = $cart_items['pagine'];

    $total_rilegature = 0;
    foreach ($cart_items['rilegature'] as $rilegatura) {
        $total_rilegature += $rilegatura['qty'];
    }

    $grammatura = $pagine['id_grammatura'];
    $grammatura_db = new Grammatura;
    $grammatura_db = $grammatura_db->get_grammature($grammatura);
    $grammatura_db = json_decode($grammatura_db);

    $formato_id = $pagine['id_formato'];

    if ($formato_id == "formato-a4") {
        $formato = "A4";
    } else {
        $formato = "A3";
    }

    $bn_pages = isset($pagine['bn']) ? $pagine['bn'] : array();
    $colorate_pages = isset($pagine['colorate']) ? $pagine['colorate'] : array();

    $bn_pages = array_map(function ($page) {
        return $page + 1;
    }, $bn_pages);

    $colorate_pages = array_map(function ($page) {
        return $page + 1;
    }, $colorate_pages);

    $total_bn_pages = count($bn_pages);
    $total_colorate_pages = count($colorate_pages);

    $bn_product = new WC_Product_Simple();
    $bn_product->set_name('Pagine monocolore');
    $bn_product->set_regular_price(get_option('prezzo_bn')); // Set the price per page
    $bn_product->set_price(get_option('prezzo_bn'));


    if ($total_bn_pages > 0) {
        $order_item_id = $order->add_product($bn_product, $total_bn_pages, array(
            'subtotal' => (get_option('prezzo_bn') * $total_bn_pages) * $total_rilegature,
            'total' => (get_option('prezzo_bn') * $total_bn_pages) * $total_rilegature,
        ));

        wc_add_order_item_meta($order_item_id, 'Indici pagine', implode(', ', $bn_pages));
        if ($grammatura_db[0]->prezzo_grammatura == 0) wc_add_order_item_meta($order_item_id, 'Grammatura', $grammatura_db[0]->nome_grammatura);
        if ($formato == "A4") wc_add_order_item_meta($order_item_id, 'Formato', $formato);
    }

    $colorate_product = new WC_Product_Simple();
    $colorate_product->set_name('Pagine multicolore');
    $colorate_product->set_regular_price(get_option('prezzo_colori')); // Set the price per page
    $colorate_product->set_price(get_option('prezzo_colori'));

    if ($total_colorate_pages > 0) {

        $order_item_id = $order->add_product($colorate_product, $total_colorate_pages, array(
            'subtotal' => (get_option('prezzo_colori') * $total_colorate_pages) * $total_rilegature,
            'total' => (get_option('prezzo_colori') * $total_colorate_pages) * $total_rilegature,
        ));

        wc_add_order_item_meta($order_item_id, 'Indici pagine', implode(', ', $colorate_pages));
        if ($grammatura_db[0]->prezzo_grammatura == 0) wc_add_order_item_meta($order_item_id, 'Grammatura', $grammatura_db[0]->nome_grammatura);
        if ($formato == "A4") wc_add_order_item_meta($order_item_id, 'Formato', $formato);
    }

    if ($grammatura_db[0]->prezzo_grammatura != 0) {

        $grammaturaProduct = new WC_Product_Simple();
        $grammaturaProduct->set_name("Grammatura " . $grammatura_db[0]->nome_grammatura);
        $grammaturaProduct->set_regular_price($grammatura_db[0]->prezzo_grammatura);
        $grammaturaProduct->set_price($grammatura_db[0]->prezzo_grammatura);

        $order_item_id = $order->add_product($grammaturaProduct, ($total_bn_pages + $total_colorate_pages), array(
            'subtotal' => ($grammatura_db[0]->prezzo_grammatura * ($total_bn_pages + $total_colorate_pages)) * $total_rilegature,
            'total' => ($grammatura_db[0]->prezzo_grammatura * ($total_bn_pages + $total_colorate_pages)) * $total_rilegature,
        ));

        wc_add_order_item_meta($order_item_id, 'Prezzo', $grammatura_db[0]->prezzo_grammatura . '€ per pagina');
    }

    if ($formato == "A3") {
        $formatoProduct = new WC_Product_Simple();
        $formatoProduct->set_name("Formato A3");
        $formatoProduct->set_regular_price(get_option('prezzo_a3'));
        $formatoProduct->set_price(get_option('prezzo_a3'));

        $order_item_id = $order->add_product($formatoProduct, ($total_bn_pages + $total_colorate_pages), array(
            'subtotal' => (get_option('prezzo_a3') * ($total_bn_pages + $total_colorate_pages)) * $total_rilegature,
            'total' => (get_option('prezzo_a3') * ($total_bn_pages + $total_colorate_pages)) * $total_rilegature,
        ));

        wc_add_order_item_meta($order_item_id, 'Prezzo', get_option('prezzo_a3') . '€ per pagina');
    }
}

function wc_create_rilegature_products($cart_items, $order)
{
    foreach ($cart_items['rilegature'] as $rilegatura) {
        $rilegatura_db = new Rilegatura;
        $rilegatura_db = $rilegatura_db->get_rilegature($rilegatura['id_rilegatura']);
        $rilegatura_db = json_decode($rilegatura_db);

        $variante_db = new Variante;
        $variante_db = $variante_db->get_variante($rilegatura['id_variante']);
        $variante_db = json_decode($variante_db);

        $colore_db = new CharColors;
        $colore_db = $colore_db->get_char_colors($rilegatura['id_colore']);
        $colore_db = json_decode($colore_db);

        $nome_rilegatura = $rilegatura_db[0]->nome_rilegatura;
        $prezzo_rilegatura = $rilegatura_db[0]->prezzo_rilegatura;
        $nome_variante = $variante_db[0]->nome_variante;
        $colore_carattere = $colore_db[0]->nome_colore;
        $angoli = isset($rilegatura['id_angolo']) ? $rilegatura['id_angolo'] : 0;
        $segnalibri = isset($rilegatura['id_segnalibro']) ? $rilegatura['id_segnalibro'] : 0;
        //  $immagine = isset($rilegatura['rilegatura_thumbnail']) ? $rilegatura['rilegatura_thumbnail'] : '';
        $quantity = $rilegatura['qty'];

        $totale = $prezzo_rilegatura;

        $product = new WC_Product_Simple();
        $product->set_name($nome_rilegatura);

        if ($angoli != 0) {
            $angoli_db = new Angolo;
            $angoli_db = $angoli_db->get_angoli($angoli);
            $angoli_db = json_decode($angoli_db);

            $totale += get_option('prezzo_angoli');
        }

        if ($segnalibri != 0) {
            $segnalibri_db = new Segnalibro;
            $segnalibri_db = $segnalibri_db->get_segnalibri($segnalibri);
            $segnalibri_db = json_decode($segnalibri_db);

            $totale += get_option('prezzo_segnalibri');
        }

        $product->set_regular_price($totale);
        $product->set_price($totale);



        // TODO: Implement this

        /* if (!empty($immagine)) {
            $session_id = isset($_COOKIE['thesis_session']) ? $_COOKIE['thesis_session'] : null;
            if ($session_id) {
                $upload_dir = wp_upload_dir();

                $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $immagine));
                
                $file_path = $upload_dir['path'] . '/' . $session_id . '.png';
                file_put_contents($file_path, $image);

                $attachment = array(
                    'guid'           => $upload_dir['url'] . '/' . basename($file_path),
                    'post_mime_type' => 'image/png',
                    'post_title'     => preg_replace('/\.[^.]+$/', '', basename($file_path)),
                    'post_content'   => '',
                    'post_status'    => 'publish'
                );

                $attach_id = wp_insert_attachment($attachment, $file_path);
                $attach_data = wp_generate_attachment_metadata($attach_id, $file_path);
                wp_update_attachment_metadata($attach_id, $attach_data);

                $product->set_image_id($attach_id);
            }
        } */

        $order_item_id = $order->add_product($product, $quantity, array(
            'subtotal' => $totale * $quantity,
            'total' => $totale * $quantity,
        ));

        wc_add_order_item_meta($order_item_id, 'Stampa', $cart_items['tipologia']);
        wc_add_order_item_meta($order_item_id, 'Variante', $nome_variante);
        wc_add_order_item_meta($order_item_id, 'Colore carattere', $colore_carattere);

        if ($angoli != 0) wc_add_order_item_meta($order_item_id, 'Angoli', $angoli_db[0]->nome_angolo);
        else wc_add_order_item_meta($order_item_id, 'Angoli', 'Nessun angolo');
        if ($segnalibri != 0) wc_add_order_item_meta($order_item_id, 'Segnalibro', $segnalibri_db[0]->nome_colore);
        else wc_add_order_item_meta($order_item_id, 'Segnalibro', 'Nessun segnalibro');
    }
}
