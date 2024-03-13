<div class="thesis--wrapper p-6 h-full">
    <?php include_once(THESIS_DIR . 'app/views/admin/components/welcome.php'); ?>
    <section class="body flex flex-col mt-4 gap-4 h-full">
        <?php include_once(THESIS_DIR . 'app/views/admin/components/header.php') ?>
        <div class="thesis--orders flex gap-4">
            <div class="thesis--sidebar flex flex-col gap-4 max-w-64">
                <div class="thesis--info bg-white p-4 rounded-md border border-slate-200">
                    <h3 class="text-2xl font-bold flex items-center gap-2"><span class="material-symbols-outlined text-amber-300 drop-shadow-sm">info</span><span>Copertine</span></h3>
                    <p class="mt-2">Da qui puoi vedere tutte le copertine, puoi creare le copertine cliccando sul pulsante "+"</p>
                </div>
            </div>
            <div class="thesis--manager flex flex-1 flex-col rounded-md bg-white w-full border border-slate-200 p-4">
                <h3 class="font-bold text-xl flex items-center justify-between"><span>Lista delle copertine</span><button id="aggiungi--copertina"><span class="material-symbols-outlined rounded-full bg-cyan-500 text-white transition-all hover:bg-slate-500">add</span></button></h3>
                <div>Non ci sono copertine.</div>
            </div>
        </div>
    </section>
</div>
<?php
/* Script per Copertine */
wp_enqueue_script('thesis-copertine', THESIS_URL . "app/assets/js/thesis-copertine.admin.js"); 
?>