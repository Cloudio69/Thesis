<?php include_once(THESIS_DIR . 'app/includes/ajax/public/init.php'); ?>
<div class="thesis--wrapper p-6 h-full">
    <?php include_once(THESIS_DIR . 'app/views/admin/components/welcome.php'); ?>
    <section class="body flex flex-col mt-4 gap-4 h-full">
        <?php include_once(THESIS_DIR . 'app/views/admin/components/header.php') ?>
        <div class="thesis--dashboard flex gap-4">
            <div class="thesis--sidebar flex flex-col gap-4 max-w-64">
                <div class="thesis--info bg-white p-4 rounded-md border border-slate-200">
                    <h3 class="text-2xl font-bold flex items-center gap-2"><span class="material-symbols-outlined text-amber-300 drop-shadow-sm">info</span><span>Dashboard</span></h3>
                    <p class="mt-2">Da qui puoi vedere un riepilogo dei tuoi guadagni e dei clienti che hanno acquistato</p>
                </div>
                <div class="thesis--stats flex flex-col gap-4 p-4 bg-white rounded-md border border-slate-200">
                    <div class="nuovi--clienti flex flex-col"><span class="text-xs font-bold">Nuovi clienti</span><span class="text-3xl font-bold"><?php echo do_shortcode('[new_customers_count]') ?></span></div>
                    <div class="nuovi--ordini flex flex-col"><span class="text-xs font-bold">Nuovi ordini</span><span class="text-3xl font-bold"><?php echo do_shortcode('[new_orders_count]'); ?></span></div>
                    <div class="guadagno flex flex-col"><span class="text-xs font-bold">Guadagno totale</span><span class="text-3xl font-bold"><?php echo do_shortcode('[total_profit]'); ?></span></div>
                </div>
            </div>
            <div class="thesis--manager flex flex-1 gap-4 flex-wrap rounded-md">
                <div class="flex w-full gap-4">
                    <div class="thesis--customers bg-white flex-1 p-4 rounded-md border border-slate-200 flex flex-col min-h-[320px] max-h-[320px]">
                        <h3 class="text-base font-bold flex items-center gap-2"><span class="material-symbols-outlined text-amber-300 drop-shadow-md">groups</span>Clienti</h3>
                        <div class="customer--data flex flex-col flex-1 overflow-auto pt-4">
                            <?php
                            global $wpdb;
                            $new_customers = $wpdb->get_results("
                                SELECT u.ID, u.user_login, u.user_email, u.user_registered
                                FROM {$wpdb->prefix}users u
                                INNER JOIN {$wpdb->prefix}usermeta um ON u.ID = um.user_id
                                WHERE um.meta_key = 'wp_capabilities' AND um.meta_value LIKE '%customer%'
                                ORDER BY u.user_registered DESC
                                LIMIT 10
                            ");

                            if (!empty($new_customers)) {
                                echo '<ul class="customer-list w-full flex flex-col gap-2">';
                                foreach ($new_customers as $customer) {
                                    echo '<li class="flex items-center justify-between p-4 bg-neutral-100 rounded-md w-full shadow-md">';
                                    echo '<strong class="flex-1">' . esc_html($customer->user_login) . '</strong>';
                                    echo '<strong class="flex-1">' . esc_html($customer->user_email) . '</strong><br>';
                                    echo '<span>Registrato il: <strong>' . esc_html(date('Y-m-d', strtotime($customer->user_registered)));
                                    echo '</strong></span></li>';
                                }
                                echo '</ul>';
                            } else {
                                echo '<span class="material-symbols-outlined">folder_open</span>';
                                echo '<p>Nessun dato.</p>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="thesis--orders flex-1 bg-white p-4 rounded-md border border-slate-200 flex flex-col min-h-[320px] max-h-[320px]">
                        <h3 class="text-base font-bold flex items-center gap-2"><span class="material-symbols-outlined text-amber-300 drop-shadow-md">orders</span>Ordini</h3>
                        <div class="customer--data flex flex-col flex-1 overflow-auto pt-4">
                            <?php
                            global $wpdb;
                            $orders = $wpdb->get_results("
                                SELECT ID, date_created_gmt, total_amount AS order_total
                                FROM {$wpdb->prefix}wc_orders
                                ORDER BY date_created_gmt DESC
                                LIMIT 10
                            ");

                            if (!empty($orders)) {
                                echo '<ul class="order-list w-full flex flex-col gap-2">';
                                foreach ($orders as $order) {
                                    $order_link = get_admin_url(null, 'post.php?post=' . $order->ID . '&action=edit');
                                    echo '<li class="flex items-center justify-between p-4 bg-neutral-100 rounded-md w-full shadow-md">';
                                    echo '<a href="' . esc_url($order_link) . '" class="flex-1 flex items-center justify-between">';
                                    echo '<strong>ID #: ' . esc_html($order->ID) . '</strong>';
                                    echo '<strong>Totale: ' . esc_html(number_format($order->order_total, 2)) . '</strong><br>';
                                    echo '<span>Ordinato il: <strong>' . esc_html(date('Y-m-d', strtotime($order->date_created_gmt))) . '</strong></span>';
                                    echo '</a>';
                                    echo '</li>';
                                }
                                echo '</ul>';
                            } else {
                                echo '<span class="material-symbols-outlined">folder_open</span>';
                                echo '<p>Nessun dato.</p>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="thesis--accessori w-full bg-white p-4 rounded-md border border-slate-200">
                    <h3 class="text-base font-bold mb-2">Accessori</h3>
                    <div class="thesis--list flex items-center w-fit">
                        <a href="<?php echo menu_page_url('thesis-accessori', false) ?>#grammature" class="uppercase font-bold flex items-center gap-4 p-4 transition-all hover:bg-slate-500 hover:text-white hover:shadow-inner rounded-md"><span class="material-symbols-outlined text-amber-300 drop-shadow-sm">format_size</span><span>Grammature</span></a>
                        <a href="<?php echo menu_page_url('thesis-accessori', false) ?>#segnalibri" class="uppercase font-bold flex items-center gap-4 p-4 transition-all hover:bg-slate-500 hover:text-white hover:shadow-inner rounded-md"><span class="material-symbols-outlined text-amber-300 drop-shadow-sm">bookmark</span><span>Segnalibri</span></a>
                        <a href="<?php echo menu_page_url('thesis-accessori', false) ?>#angoli" class="uppercase font-bold flex items-center gap-4 p-4 transition-all hover:bg-slate-500 hover:text-white hover:shadow-inner rounded-md"><span class="material-symbols-outlined text-amber-300 drop-shadow-sm">arrows_more_up</span><span>Angoli</span></a>
                    </div>
                </div>
                <div class="thesis--rilegature w-full bg-white p-4 rounded-md border border-slate-200">
                    <h3 class="text-base font-bold mb-2">Rilegature</h3>
                    <div class="thesis--list flex items-center w-fit">
                        <a href="<?php echo menu_page_url('thesis-rilegature', false) ?>#grammature" class="uppercase font-bold flex items-center gap-4 p-4 transition-all hover:bg-slate-500 hover:text-white hover:shadow-inner rounded-md"><span class="material-symbols-outlined text-amber-300 drop-shadow-sm">palette</span><span>Tipologie</span></a>
                        <a href="<?php echo menu_page_url('thesis-rilegature', false) ?>#segnalibri" class="uppercase font-bold flex items-center gap-4 p-4 transition-all hover:bg-slate-500 hover:text-white hover:shadow-inner rounded-md"><span class="material-symbols-outlined text-amber-300 drop-shadow-sm">border_color</span><span>Colori carattere</span></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>