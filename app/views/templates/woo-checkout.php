<?php wp_head();?>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<?php
wp_enqueue_style('tailwind', THESIS_URL . "/app/assets/css/tailwind.css");
wp_enqueue_style('thesis-frontend', THESIS_URL . "/app/assets/css/frontend/thesis-frontend.css");
?>
<body <?php body_class();?>>
<div class="thesis--wrapper h-full flex flex-col justify-center items-center">
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
        <a href="/" class="flex items-center gap-2 p-2 bg-white"><span class="!text-black font-bold">ANNULLA</span><span class="material-symbols-outlined !text-black text-xl">close</span></a>
    </header>
    <main class="flex-1 flex flex-col items-center justify-center">
        <?php
if (!is_user_logged_in()) {
    ?>
            <div class="thesis--register h-full flex items-center justify-center flex-1">
                <?php
echo do_shortcode('[woocommerce_my_account]');
    ?>
            </div>
            <?php
}
?>
   <?php
if (is_user_logged_in()) {
    ?>
        <div class="thesis--checkout-form flex justify-center items-center flex-1">

                <?php
$available_gateways = WC()->payment_gateways->get_available_payment_gateways();
    if (!empty($available_gateways)) {
        echo '<ul class="payment-methods">';
        foreach ($available_gateways as $gateway) {
            echo '<li class="payment-method">';
            echo '<input type="radio" id="payment_method_' . esc_attr($gateway->id) . '" name="payment_method" value="' . esc_attr($gateway->id) . '" />';
            echo '<label for="payment_method_' . esc_attr($gateway->id) . '">' . esc_html($gateway->get_title()) . '</label>';
            echo '</li>';
        }
        echo '</ul>';
        echo '<div class="terms-and-conditions">';
        echo '<input type="checkbox" id="terms" name="terms" required />';
        echo '<label for="terms">' . sprintf(__('I have read and agree to the <a href="%s" target="_blank">terms and conditions</a>', 'woocommerce'), esc_url(get_permalink(wc_get_page_id('terms')))) . '</label>';
        echo '</div>';
    } else {
        echo '<p>' . esc_html__('No available payment methods.', 'woocommerce') . '</p>';
    }
    ?>

        </div>
        <?php
}
?>
<form method="post" action="<?php echo esc_url(wc_get_checkout_url()); ?>" class="checkout woocommerce-checkout">
    <?php
    if (is_user_logged_in() && !empty($available_gateways)) {
        ?>
        <div class="thesis--pay-button mt-4">
            <button type="submit" class="button alt" id="place_order" value="<?php esc_attr_e('Place order', 'woocommerce'); ?>">
                <?php esc_html_e('Place order', 'woocommerce'); ?>
            </button>
        </div>
        <?php
    }
    ?>
</form>
    </main>
</div>
</body>


<?php wp_footer();?>

