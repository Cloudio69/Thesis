<div class="thesis--heading flex justify-between items-center rounded-md bg-white overflow-hidden border border-slate-200">
    <nav class="thesis--nav flex items-center text-[12px] uppercase font-bold divide-x divide-slate-200">
        <a href="<?php echo menu_page_url('thesis', false) ?>" class="flex gap-2 items-center justify-center py-3 px-3 transition-all hover:bg-slate-500 hover:text-white hover:shadow-inner"><span class="material-symbols-outlined text-amber-300 drop-shadow-sm">dashboard</span><span class="">Dashboard</span></a>
        <a href="<?php echo menu_page_url('thesis-ordini', false) ?>" class="flex gap-2 items-center justify-center p-3 transition-all hover:bg-slate-500 hover:text-white hover:shadow-inner"><span class="material-symbols-outlined text-amber-300 drop-shadow-sm">orders</span><span class="">Ordini</span></a>
        <a href="<?php echo menu_page_url('thesis-copertine', false) ?>" class="flex gap-2 items-center justify-center p-3 transition-all hover:bg-slate-500 hover:text-white hover:shadow-inner"><span class="material-symbols-outlined text-amber-300 drop-shadow-sm">book_2</span>Copertine</span></a>
        <a href="<?php echo menu_page_url('thesis-prodotti', false) ?>" class="flex gap-2 items-center justify-center p-3 transition-all hover:bg-slate-500 hover:text-white hover:shadow-inner"><span class="material-symbols-outlined text-amber-300 drop-shadow-sm">inventory_2</span>Prodotti</span></a>
        <a href="<?php echo menu_page_url('thesis-impostazioni', false) ?>" class="flex gap-2 items-center justify-center p-3 transition-all hover:bg-slate-500 hover:text-white hover:shadow-inner"><span class="material-symbols-outlined text-amber-300 drop-shadow-sm">settings</span><span class="">Impostazioni</span></a>
    </nav>
    <div class="version">
        <span class="rounded-full drop-shadow-xl font-bold text-[10px] px-4">v <?php echo get_plugin_data(THESIS_DIR . "thesis.php")["Version"]; ?></span>
    </div>
</div>