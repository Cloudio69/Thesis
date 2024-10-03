<?php

// TODO: Implement this function

function wc_thesis_create_order($args)
{

    $order = wc_create_order();

    $cart_items = $args['cart'];

    wc_thesis_create_cart($cart_items, $order);

    /* $product = new WC_Product_Simple();
    $product->set_name('Temporary Custom Product');  
    $product->set_regular_price(29.99);              

    $product->update_meta_data('has_angles', true);
    $product->update_meta_data('has_bookmarks', true);   */

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
        $quantity = $rilegatura['qty'];

        $product = new WC_Product_Simple();
        $product->set_name($nome_rilegatura);
        $product->set_regular_price($prezzo_rilegatura);
        $product->set_price($prezzo_rilegatura);

        $order_item_id = $order->add_product($product, $quantity, array(
            'subtotal' => $prezzo_rilegatura * $quantity,
            'total' => $prezzo_rilegatura * $quantity,
        ));
    }
}
