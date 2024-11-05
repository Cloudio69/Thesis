<?php wp_enqueue_style('tailwind'); ?>
<?php wp_enqueue_style('thesis-frontend', THESIS_URL . "/app/assets/css/frontend/thesis-frontend.css"); ?>

<?php
if (isset($_POST['coupon_code']) && !empty($_POST['coupon_code'])) {

	$order_id = absint(get_query_var('order-pay'));
	$order = wc_get_order($order_id);

	$coupon_code = sanitize_text_field($_POST['coupon_code']);

	$order->apply_coupon($coupon_code);

	$order->calculate_totals();
}
?>
<div class="wrapper flex p-16 gap-6 h-full">
	<div class="order--table w-1/2">
		<?php
		$order_id = absint(get_query_var('order-pay'));
		$order = wc_get_order($order_id);

		if ($order) {
		?>
			<h2 class="font-bold text-xl mb-4"><?php esc_html_e('Dettagli ordine', 'woocommerce'); ?></h2>

			<div class="order-details-grid flex flex-col gap-4">
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
		<?php
		} else {
			echo '<p>' . esc_html__('Order not found.', 'woocommerce') . '</p>';
		}
		?>
		<hr class="my-4">
		<div class="total text-3xl mb-4 font-bold p-4 bg-white border rounded-md !sticky bottom-0 w-full">
			<?php esc_html_e('Totale', 'woocommerce'); ?>:
			<?php echo wp_kses_post($order->get_formatted_order_total()); ?>
			<div class="coupons-used mt-4">
				<h3 class="font-bold text-lg mb-2"><?php esc_html_e('Coupon usati', 'woocommerce'); ?></h3>
				<?php
				$coupons = $order->get_coupon_codes();
				if (!empty($coupons)) {
					foreach ($coupons as $coupon_code) {
						$coupon = new WC_Coupon($coupon_code);
				?>
						<div class="flex justify-between !items-center bg-gray-100 p-2 rounded-md mb-2">
							<span class="capitalize text-xl"><?php echo esc_html($coupon_code); ?></span>
							<form method="post" class="remove-coupon-form !m-0">
								<input type="hidden" name="remove_coupon" value="<?php echo esc_attr($coupon_code); ?>" />
								<button type="submit" class="!bg-black !text-white hover:!bg-neutral-800 hover:!text-white focus:!ring-1 focus:ring-offset-2 focus:!ring-neutral-900 !border-none"><?php esc_html_e('Remove', 'woocommerce'); ?></button>
							</form>
						</div>
				<?php
					}
				} else {
					echo '<p class="text-xl opacity-50">' . esc_html__('Nessun coupon usato.', 'woocommerce') . '</p>';
				}
				?>
			</div>

			<?php
			if (isset($_POST['remove_coupon']) && !empty($_POST['remove_coupon'])) {
				$coupon_code = sanitize_text_field($_POST['remove_coupon']);
				$order->remove_coupon($coupon_code);
				$order->calculate_totals();
				echo '<meta http-equiv="refresh" content="0">';
			}
			?>
		</div>
	</div>
	<div class="order--actions w-1/2">
		<div class="!sticky top-24">
			<form id="order_review" method="post">
				<div id="payment" class="!bg-zinc-50 !border !rounded-md p-4 flex flex-col">
					<h1 class="font-bold text-xl p-4 !m-0">Scegli un metodo di pagamento</h1>
					<?php if ($order->needs_payment()) : ?>
						<ul class="wc_payment_methods payment_methods methods">
							<?php
							if (! empty($available_gateways)) {
								foreach ($available_gateways as $gateway) {
									wc_get_template('checkout/payment-method.php', array('gateway' => $gateway));
								}
							} else {
								echo '<li>';
								wc_print_notice(apply_filters('woocommerce_no_available_payment_methods_message', esc_html__('Sorry, it seems that there are no available payment methods for your location. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce')), 'notice'); // phpcs:ignore WooCommerce.Commenting.CommentHooks.MissingHookComment
								echo '</li>';
							}
							?>
						</ul>
					<?php endif; ?>
					<div class="p-4">
						<input type="hidden" name="woocommerce_pay" value="1" />

						<?php wc_get_template('checkout/terms.php'); ?>

						<?php do_action('woocommerce_pay_order_before_submit'); ?>

						<?php
						$order_button_text = "Completa il pagamento";
						echo apply_filters('woocommerce_pay_order_button_html', '<button type="submit" class="!bg-black !text-white hover:!bg-neutral-800 hover:!text-white focus:!ring-1 focus:ring-offset-2 focus:!ring-neutral-900 !border-none' . esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : '') . '" id="place_order" value="' . esc_attr($order_button_text) . '" data-value="' . esc_attr($order_button_text) . '">' . esc_html($order_button_text) . '</button>');
						?>

						<?php do_action('woocommerce_pay_order_after_submit'); ?>

						<?php wp_nonce_field('woocommerce-pay', 'woocommerce-pay-nonce'); ?>
					</div>
				</div>
			</form>

			<div class="coupon-form mt-6 p-4 bg-white border rounded-md">
				<h2 class="font-bold text-xl mb-2"><?php esc_html_e('Inserisci coupon', 'woocommerce'); ?></h2>
				<p class="mb-4">Se possiedi un codice, puoi ricevere uno sconto inserendolo qui sotto</p>
				<form class="flex gap-2" method="post">
					<p class="form-row form-row-first">
						<input type="text" name="coupon_code" class="input-text" placeholder="<?php esc_attr_e('Coupon code', 'woocommerce'); ?>" id="coupon_code" value="" />
					</p>
					<p class="form-row form-row-last">
						<button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e('Apply coupon', 'woocommerce'); ?>"><?php esc_html_e('Apply coupon', 'woocommerce'); ?></button>
					</p>
				</form>
			</div>
		</div>
	</div>

</div>