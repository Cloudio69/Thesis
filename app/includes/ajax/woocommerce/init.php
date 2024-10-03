<?php

// TODO: Implement this function

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

    $order->calculate_totals();
    $order->save();

    $order_id = $order->get_id();
    $payment_url = $order->get_checkout_payment_url();

    return wp_send_json_success(array('order_id' => $order_id, 'payment_url' => $payment_url, 'products' => $order->get_item_count()), 200);
}


function wc_thesis_create_cart($cart_items, $order)
{
    foreach ($cart_items['rilegature'] as $rilegatura) {
        $rilegatura_db = new Rilegatura;
        $rilegatura_db = $rilegatura_db->get_rilegature($rilegatura['id_rilegatura']);
        $rilegatura_db = json_decode($rilegatura_db);

        $nome_rilegatura = $rilegatura_db[0]->nome_rilegatura;
        $prezzo_rilegatura = $rilegatura_db[0]->prezzo_rilegatura;
        $angoli = isset($rilegatura['id_angolo']) ? $rilegatura['id_angolo'] : 0;
        $segnalibri = isset($rilegatura['id_segnalibro']) ? $rilegatura['id_segnalibro'] : 0;

        //  $immagine = isset($rilegatura['rilegatura_thumbnail']) ? $rilegatura['rilegatura_thumbnail'] : '';
        
        $quantity = $rilegatura['qty'];

        $product = new WC_Product_Simple();
        $product->set_name($nome_rilegatura);
        $product->set_regular_price($prezzo_rilegatura);
        $product->set_price($prezzo_rilegatura);

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
            'subtotal' => $prezzo_rilegatura * $quantity,
            'total' => $prezzo_rilegatura * $quantity,
        ));

    }
}
