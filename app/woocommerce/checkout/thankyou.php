<?php
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $wp;
$order_id = absint($wp->query_vars['order-received']);
$order = wc_get_order($order_id);

if ($order) : ?>

    <div class="woocommerce-order p-4">

        <?php if ($order->has_status('failed')) : ?>

            <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e('Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce'); ?></p>

            <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
                <a href="<?php echo esc_url($order->get_checkout_payment_url()); ?>" class="button pay"><?php esc_html_e('Pay', 'woocommerce'); ?></a>
                <?php if (is_user_logged_in()) : ?>
                    <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="button pay"><?php esc_html_e('My account', 'woocommerce'); ?></a>
                <?php endif; ?>
            </p>

        <?php else : ?>
            <div class="p-4 flex flex-col items-center">
                <p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters('woocommerce_thankyou_order_received_text', esc_html__('Il tuo ordine è stato ricevuto.', 'woocommerce'), $order); ?></p>

                <ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details !mt-4">

                    <li class="woocommerce-order-overview__order order">
                        <?php esc_html_e('Order number:', 'woocommerce'); ?>
                        <strong><?php echo esc_html($order->get_order_number()); ?></strong>
                    </li>

                    <li class="woocommerce-order-overview__date date">
                        <?php esc_html_e('Date:', 'woocommerce'); ?>
                        <strong><?php echo esc_html(wc_format_datetime($order->get_date_created())); ?></strong>
                    </li>

                    <li class="woocommerce-order-overview__total total">
                        <?php esc_html_e('Total:', 'woocommerce'); ?>
                        <strong><?php echo wp_kses_post($order->get_formatted_order_total()); ?></strong>
                    </li>

                    <li class="woocommerce-order-overview__payment-method method">
                        <?php esc_html_e('Payment method:', 'woocommerce'); ?>
                        <strong><?php echo wp_kses_post($order->get_payment_method_title()); ?></strong>
                    </li>

                </ul>
            </div>
            <div class="order-received-wrapper flex w-full p-4 gap-4 h-full">

                <div class="order-details-grid flex flex-col gap-4 w-1/2">
                    <h1 class="text-3xl font-bold">Dettagli ordine</h1>
                    <?php
                    foreach ($order->get_items() as $item_id => $item) {
                        $product = $item->get_product();
                    ?>
                        <div class="bg-white border rounded-md p-4">
                            <div>
                                <?php
                                echo '<span class="text-xl font-bold">' . esc_html($item->get_name()) . '</span>';
                                echo ' <strong class="product-quantity">&times; ' . esc_html($item->get_quantity()) . '</strong>';
                                ?>
                            </div>

                            <div class="order-item-meta text-sm flex-col flex gap-2 border-b py-4 my-2">
                                <?php
                                $meta_data = $item->get_formatted_meta_data('_', true);
                                foreach ($meta_data as $meta_id => $meta) {
                                    if ($meta->display_value !== "") {
                                        if ($meta->display_key !== 'Indici pagine') {
                                            echo "<div class='flex gap-2'>";
                                            echo '<p><strong>' . esc_html($meta->display_key) . ':</strong> ' . wp_kses_post($meta->display_value) . '</p>';
                                            echo "</div>";
                                        }
                                    }
                                }
                                ?>
                            </div>
                            <div class="text-2xl font-bold w-full flex items-end">
                                <?php echo wp_kses_post($order->get_formatted_line_subtotal($item)); ?>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>

                <div class="woocommerce-customer-details w-1/2 p-4 !sticky top-20 h-fit">
                    <h2 class="font-bold"><?php esc_html_e('Dati spedizione', 'woocommerce'); ?></h2>
                    <div class="p-4 rounded-md border mt-4">
                        <?php
                        $shipping_fields = $order->get_address('shipping');
                        foreach ($shipping_fields as $key => $value) {
                            if (!empty($value)) {
                                echo '<p><strong>' . esc_html__(ucwords(str_replace('_', ' ', $key)), 'woocommerce') . ':</strong> ' . esc_html($value) . '</p>';
                            }
                        }
                        ?>

                    </div>

                    <div class="woocommerce-total-paid">
                        <h2 class="mt-4 font-bold"><?php esc_html_e('Riepilogo pagamento', 'woocommerce'); ?></h2>
                        <div class="p-4 rounded-md border mt-4">
                            <p><strong><?php esc_html_e('Subtotal:', 'woocommerce'); ?></strong> <?php echo wp_kses_post($order->get_subtotal_to_display()); ?></p>
                            <p><strong><?php esc_html_e('Shipping:', 'woocommerce'); ?></strong> <?php echo wp_kses_post($order->get_shipping_to_display()); ?></p>
                            <?php
                            $coupons = $order->get_coupon_codes();
                            if (!empty($coupons)) {
                                foreach ($coupons as $coupon_code) {
                                    $coupon = new WC_Coupon($coupon_code);
                                    $discount_amount = $coupon->get_amount();
                                    echo '<p><strong>' . esc_html__('Coupon:', 'woocommerce') . '</strong> ' . esc_html($coupon_code) . ' - ' . wc_price($discount_amount) . '</p>';
                                }
                            }
                            ?>
                            <p><strong><?php esc_html_e('Total:', 'woocommerce'); ?></strong> <?php echo wp_kses_post($order->get_formatted_order_total()); ?></p>
                        </div>
                    </div>
                </div>

            </div>
        <?php endif; ?>

    </div>

<?php endif; ?>