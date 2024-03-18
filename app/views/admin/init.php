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
                    <div class="nuovi--clienti flex flex-col"><span class="text-xs font-bold">Nuovi clienti</span><span class="text-3xl font-bold">0</span></div>
                    <div class="nuovi--ordini flex flex-col"><span class="text-xs font-bold">Nuovi ordini</span><span class="text-3xl font-bold">0</span></div>
                    <div class="guadagno flex flex-col"><span class="text-xs font-bold">Guadagno totale</span><span class="text-3xl font-bold">0</span></div>
                </div>
            </div>
            <div class="thesis--manager flex flex-1 gap-4 flex-wrap rounded-md">
                <div class="thesis--customers bg-white flex-1 p-4 rounded-md border border-slate-200">
                    <h3 class="text-base font-bold flex items-center gap-2"><span class="material-symbols-outlined text-amber-300 drop-shadow-md">groups</span>Clienti</h3>
                    <canvas id="thesis--customers" class="py-4 h-full">
                </div>
                <div class="thesis--orders flex-1 bg-white p-4 rounded-md border border-slate-200">
                    <h3 class="text-base font-bold flex justify-between items-center"><span class="flex items-center gap-2"><span class="material-symbols-outlined text-amber-300 drop-shadow-sm">orders</span>Ordini</span><span><a class="flex items-center gap-2 text-[12px]" href="<?php echo menu_page_url('thesis-ordini', false) ?>">VAI AGLI ORDINI <span class="material-symbols-outlined text-amber-300 text-sm drop-shadow-">east</span></a></span></h3>
                    <canvas id="thesis--orders" class="py-4 h-full">
                </div>
                <div class="thesis--products w-full bg-white p-4 rounded-md border border-slate-200">
                    <h3 class="text-base font-bold mb-2">Prodotti</h3>
                    <div class="thesis--list flex items-center w-fit">
                        <a href="<?php echo menu_page_url('thesis-prodotti', false) ?>#grammature" class="uppercase font-bold flex items-center gap-4 p-4 transition-all hover:bg-slate-500 hover:text-white hover:shadow-inner rounded-md"><span class="material-symbols-outlined text-amber-300 drop-shadow-sm">contract</span><span>Grammature</span></a>
                        <a href="<?php echo menu_page_url('thesis-prodotti', false) ?>#segnalibri" class="uppercase font-bold flex items-center gap-4 p-4 transition-all hover:bg-slate-500 hover:text-white hover:shadow-inner rounded-md"><span class="material-symbols-outlined text-amber-300 drop-shadow-sm">bookmark</span><span>Segnalibri</span></a>
                        <a href="<?php echo menu_page_url('thesis-prodotti', false) ?>#angoli" class="uppercase font-bold flex items-center gap-4 p-4 transition-all hover:bg-slate-500 hover:text-white hover:shadow-inner rounded-md"><span class="material-symbols-outlined text-amber-300 drop-shadow-sm">pageless</span><span>Angoli</span></a>
                    </div>
                </div>
                <div class="thesis--copertine w-full bg-white p-4 rounded-md border border-slate-200">
                    <h3 class="text-base font-bold mb-2">Copertine</h3>
                    <div class="thesis--list flex items-center w-fit">
                        <a href="<?php echo menu_page_url('thesis-copertine', false) ?>#grammature" class="uppercase font-bold flex items-center gap-4 p-4 transition-all hover:bg-slate-500 hover:text-white hover:shadow-inner rounded-md"><span class="material-symbols-outlined text-amber-300 drop-shadow-sm">palette</span><span>Tipologie</span></a>
                        <a href="<?php echo menu_page_url('thesis-copertine', false) ?>#segnalibri" class="uppercase font-bold flex items-center gap-4 p-4 transition-all hover:bg-slate-500 hover:text-white hover:shadow-inner rounded-md"><span class="material-symbols-outlined text-amber-300 drop-shadow-sm">border_color</span><span>Colori carattere</span></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
    /* Script per Dashboard */
    wp_enqueue_script('thesis-charts', THESIS_URL . "/app/assets/js/charts.admin.js", array(), null, true);
    
?>