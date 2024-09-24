<?php

add_action( 'init', 'create_custom_order_with_temp_product_and_email' );

function create_custom_order_with_temp_product_and_email() {
    // Only run this function once (for demonstration purposes)
    if( isset($_GET['create_temp_order']) ) {

        // 1. Create a new WooCommerce order object
        $order = wc_create_order();

        // 2. Create a temporary product (not saved in WooCommerce)
        $product = new WC_Product_Simple(); // Instantiate a simple product object
        $product->set_name('Temporary Custom Product');  // Set product name

        // 3. Set price directly when adding the product to the order
        $price = 29.99; // Define the price here
        
        // 4. Add the product to the order with the specified price
        $order_item_id = $order->add_product($product, 1, array(
            'subtotal' => $price,  // Set the price manually here
            'total'    => $price,  // Set the total price manually here
        ));

        // 5. Add custom metadata to the order item using wc_add_order_item_meta
        wc_add_order_item_meta($order_item_id, 'has_angles', true);     // Add custom field "has_angles"
        wc_add_order_item_meta($order_item_id, 'has_bookmarks', true);  // Add custom field "has_bookmarks"

        // 6. Add billing and shipping information
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
        $order->update_meta_data( 'order_origin', 'Configuratore' );

        // 7. Calculate totals and save the order
        $order->calculate_totals();
        $order->save();

        // 8. Get the payment URL for the customer to complete the payment
        $order_id = $order->get_id();
        $payment_url = $order->get_checkout_payment_url();

        // Output the payment URL (or handle it as needed)
        echo 'Order created! Please complete your payment at: ' . $payment_url;

        // 9. Send a WooCommerce email (like the "New Order" email)
        WC()->mailer()->get_emails()['WC_Email_New_Order']->trigger($order_id);

        // Stop further execution to prevent the hook from firing multiple times
        exit;
    }
}

add_action( 'template_redirect', 'require_login_for_order_payment' );

function require_login_for_order_payment() {
    if ( is_wc_endpoint_url( 'order-pay' ) && ! is_user_logged_in() ) {
        // Get the current URL (the order payment URL)
        $redirect_url = wc_get_page_permalink( 'myaccount' );

        // Add a query parameter to redirect the user back to the payment page after login
        $redirect_url = add_query_arg( 'redirect_to', urlencode( esc_url( $_SERVER['REQUEST_URI'] ) ), $redirect_url );

        // Redirect to the login/register page
        wp_redirect( $redirect_url );
        exit;
    }
}

add_action( 'wp_login', 'assign_guest_order_to_user', 10, 2 );
add_action( 'woocommerce_created_customer', 'assign_guest_order_to_user_after_registration', 10, 1 );

function assign_guest_order_to_user( $user_login, $user ) {
    if ( isset( $_GET['redirect_to'] ) ) {
        $redirect_url = esc_url( $_GET['redirect_to'] );
        associate_order_with_user( $redirect_url, $user->ID );
    }
}

function assign_guest_order_to_user_after_registration( $customer_id ) {
    if ( isset( $_GET['redirect_to'] ) ) {
        $redirect_url = esc_url( $_GET['redirect_to'] );
        associate_order_with_user( $redirect_url, $customer_id );
    }
}

function associate_order_with_user( $redirect_url, $user_id ) {
    // Check if the redirect URL contains an order-pay link
    if ( strpos( $redirect_url, 'order-pay' ) !== false ) {
        // Extract the order ID from the URL
        $order_id = url_to_order_id( $redirect_url );

        // Make sure the order ID is valid
        if ( $order_id ) {
            $order = wc_get_order( $order_id );

            // Check if the order is a guest order (no customer ID assigned)
            if ( $order && $order->get_customer_id() == 0 ) {
                // Assign the logged-in user to the order
                $order->set_customer_id( $user_id );
                $order->save();
            }
        }
    }
}

function url_to_order_id( $url ) {
    // Parse the URL and extract the order ID
    $order_pay_position = strpos( $url, 'order-pay/' );
    if ( $order_pay_position !== false ) {
        $order_id = intval( substr( $url, $order_pay_position + 10 ) );
        return $order_id;
    }
    return false;
}
