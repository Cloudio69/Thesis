<?php

add_action('wp_ajax_wc_thesis_create_order', 'wc_thesis_create_order');
add_action('wp_ajax_nopriv_wc_thesis_create_order', 'wc_thesis_create_order');

// TODO: Implement this function

function wc_thesis_create_order() {

        $order = wc_create_order();

        $product = new WC_Product_Simple();
        $product->set_name('Temporary Custom Product');  
        $product->set_regular_price(29.99);              

        $product->update_meta_data('has_angles', true);
        $product->update_meta_data('has_bookmarks', true);  

        $order->add_product($product, 1, array(
            'subtotal' => $product->get_price(),
            'total'    => $product->get_price(),
        ));

        $billing_data = array(
            'first_name' => 'John',
            'last_name'  => 'Doe',
            'company'    => 'Doe Industries',
            'email'      => 'john.doe@example.com',
            'phone'      => '555-555-5555',
            'address_1'  => '123 Main Street',
            'address_2'  => '',
            'city'       => 'Anytown',
            'state'      => 'CA',
            'postcode'   => '12345',
            'country'    => 'US',
        );
        $order->set_address($billing_data, 'billing');

        $shipping_data = array(
            'first_name' => 'John',
            'last_name'  => 'Doe',
            'company'    => 'Doe Industries',
            'address_1'  => '123 Main Street',
            'address_2'  => '',
            'city'       => 'Anytown',
            'state'      => 'CA',
            'postcode'   => '12345',
            'country'    => 'US',
        );
        $order->set_address($shipping_data, 'shipping');

        $order->calculate_totals();
        $order->save();

        $order_id = $order->get_id();
        $payment_url = $order->get_checkout_payment_url();

        return wp_send_json_success(array('order_id' => $order_id, 'payment_url' => $payment_url));
}