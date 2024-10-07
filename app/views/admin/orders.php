<div class="thesis--wrapper p-6 h-full">
    <?php include_once(THESIS_DIR . 'app/views/admin/components/welcome.php'); ?>
    <section class="body flex flex-col mt-4 gap-4 h-full">
        <?php include_once(THESIS_DIR . 'app/views/admin/components/header.php') ?>
        <div class="thesis--orders flex gap-4">
            <div class="thesis--sidebar flex flex-col gap-4 max-w-64">
                <div class="thesis--info bg-white p-4 rounded-md border border-slate-200">
                    <h3 class="text-2xl font-bold flex items-center gap-2"><span class="material-symbols-outlined text-amber-300 drop-shadow-sm">info</span><span>Ordini</span></h3>
                    <p class="mt-2">Da qui puoi vedere un riepilogo degli ordini effettuati dai clienti* <br><br><span class="font-bold text-xs">*Solo gli ordini che sono stati pagati</span></p>
                </div>
            </div>
            <div class="thesis--manager flex flex-col flex-1 bg-white w-full h-full">
                <table class="table-auto border border-collapse w-full">
                    <thead>
                        <tr class="bg-slate-100">
                            <th class="border border-slate-200 p-2">Ordine #ID</th>
                            <th class="border border-slate-200 p-2">Nome Cliente</th>
                            <th class="border border-slate-200 p-2">Data Ordine</th>
                            <th class="border border-slate-200 p-2">Scarica ZIP</th>
                            <th class="border border-slate-200 p-2">Importo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $page = isset($_GET['paged']) ? intval($_GET['paged']) : 1;
                        $orders_per_page = 20;

                        $orders = wc_get_orders(array(
                            'limit' => $orders_per_page,
                            'orderby' => 'date',
                            'order' => 'DESC',
                            'status' => array('on-hold', 'completed'),
                            'paged' => $page
                        ));

                        if(empty($orders)) {
                            echo '<tr class="text-center"><td colspan="4" class="border border-slate-200 p-2">Nessun ordine trovato</td></tr>';
                        }

                        foreach ($orders as $order) {
                            $order_id = $order->get_id();
                            $order_total = $order->get_total();
                            $order_date = $order->get_date_created()->date('d-m-Y H:i:s');
                            $order_customer = $order->get_billing_first_name() . ' ' . $order->get_billing_last_name();
                            $download_zip = get_post_meta($order_id, '_download_zip', true);

                            if (empty($download_zip)) {
                                $zip = '';
                            } else {
                                $zip = $download_zip;
                            }

                        ?>
                            <tr class="">
                                <td class="border border-slate-200 p-2 text-center"><?php echo $order_id; ?></td>
                                <td class="border border-slate-200 p-2 font-bold text-center"><?php echo $order_customer; ?></td>
                                <td class="border border-slate-200 p-2 text-center"><?php echo $order_date; ?></td>
                                <td class="border border-slate-200 p-2 text-center"><a href="<?php echo $zip; ?>" download class="underline text-center">Download</a></td>
                                <td class="border border-slate-200 p-2 font-bold text-center text-lg"><?php echo wc_price($order_total); ?></td>
                            </tr>
                        <?php
                        }

                        ?>
                    </tbody>
                </table>
                <?php 
                    $total_orders = wc_get_orders(array(
                        'limit' => -1,
                        'orderby' => 'date',
                        'order' => 'DESC',
                        'status' => 'completed'
                    ));
                    $total_pages = ceil(count($total_orders) / $orders_per_page);
                    $pagination_args = array(
                        'base' => add_query_arg('paged', '%#%'),
                        'format' => '',
                        'current' => max(1, $page),
                        'total' => $total_pages,
                        'prev_text' => __('&laquo; Previous'),
                        'next_text' => __('Next &raquo;'),
                    );

                    echo '<div class="pagination flex gap-4 items-center justify-center p-4">';
                    echo paginate_links($pagination_args);
                    echo '</div>';
                        
                ?>
            </div>
        </div>
    </section>
</div>