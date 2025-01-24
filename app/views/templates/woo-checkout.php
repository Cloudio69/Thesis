<?php wp_head(); ?>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<?php
wp_enqueue_style('tailwind', THESIS_URL . "/app/assets/css/tailwind.css");
wp_enqueue_style('thesis-frontend', THESIS_URL . "/app/assets/css/frontend/thesis-frontend.css");

$order_key = isset($_GET['key']) ? sanitize_text_field($_GET['key']) : '';

$order_id = wc_get_order_id_by_order_key($order_key);
$order = wc_get_order($order_id);

if ($order) {
    if ($order->get_status() === 'trash') {
        wp_redirect(home_url());
        exit;
    }

    if (strpos($_SERVER['REQUEST_URI'], '/checkout/order-pay') !== 0 && $order->get_status() !== 'pending') {
        if (strpos($order_key, 'wc_order_') !== 0) {
            wp_redirect(home_url());
            exit;
        }
    }
} else {
    wp_redirect(home_url('/error-page'));
    exit;
}

?>

<body <?php body_class(); ?>>
    <div class="thesis--wrapper h-full flex flex-col">
        <header class="thesis--header bg-white w-full top-0 flex justify-between items-center z-[99] px-6 py-4">
            <h1 class="text-xl font-bold m-0">Checkout</h1>
            <?php
            if (is_user_logged_in()) {
                $current_user = wp_get_current_user();
            ?>
                <div class="user-info flex items-center gap-2">
                    <span class="material-symbols-outlined text-xl">account_circle</span>
                    <span class="font-bold">Ciao <?php echo esc_html($current_user->display_name); ?>! 🎉</span>
                </div>
            <?php
            }
            ?>
            <?php
            if (isset($_GET['delete_order']) && intval($_GET['delete_order']) === $order_id) {
                wc_get_order($order_id)->delete();
                wp_redirect(home_url());
                exit;
            }
            ?>
            <a href="<?php echo esc_url(add_query_arg('delete_order', $order_id)); ?>" class="flex items-center gap-2 p-2 bg-white">
                <span class="!text-black font-bold">ANNULLA</span>
                <span class="material-symbols-outlined !text-black text-xl">close</span>
            </a>
        </header>
        <main class="flex-1 flex flex-col items-center justify-center">
            <?php
            if (is_user_logged_in()) {
                $order->set_customer_id($current_user->ID);
                $order->save();
            }

            echo do_shortcode('[woocommerce_checkout]');
            
            ?>
        </main>
    </div>
</body>


<?php wp_footer(); ?>