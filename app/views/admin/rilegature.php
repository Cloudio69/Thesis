<div class="thesis--wrapper p-6 h-full">
    <?php include_once(THESIS_DIR . 'app/views/admin/components/welcome.php'); ?>
    <section class="body flex flex-col mt-4 gap-4 h-full">
        <?php include_once(THESIS_DIR . 'app/views/admin/components/header.php') ?>
        <div class="thesis--rilegature flex gap-4">
            <div class="thesis--sidebar flex flex-col gap-4 max-w-64">
                <div class="thesis--info bg-white p-4 rounded-md border border-slate-200">
                    <h3 class="text-2xl font-bold flex items-center gap-2"><span class="material-symbols-outlined text-amber-300 drop-shadow-sm">info</span><span>Rilegature</span></h3>
                    <p class="mt-2">Da qui puoi vedere tutte le rilegature, puoi creare le rilegature cliccando sul pulsante "+"</p>
                </div>
            </div>
            <div class="thesis--manager flex flex-1 flex-col rounded-md bg-white w-full border border-slate-200 p-4">
                <h3 class="font-bold text-xl flex items-center justify-between mb-4"><span class="flex gap-4 items-center"><span class="material-symbols-outlined text-amber-300 drop-shadow-sm">book_2</span><span>Rilegature</span></span><button id="aggiungi--rilegatura"><span class="material-symbols-outlined rounded-full bg-cyan-500 text-white transition-all hover:bg-slate-500">add</span></button></h3>
                <div id="list--rilegature" class="grid auto-cols-fr w-full p-4 animate-pulse bg-gray-200 rounded-md h-60"></div>
            </div>
        </div>
        <?php include_once(THESIS_DIR . '/app/views/admin/components/rilegature/variants.php'); ?>
        <?php include_once(THESIS_DIR . '/app/views/admin/components/rilegature/char-colors.php'); ?>
    </section>
</div>
<dialog id="modal--thesis" class="min-w-[30vw] min-h-[30vh] p-4 rounded-md">
    <section class="modal--heading flex justify-between items-center">
        <h3 class="font-bold text-xl">Aggiungi rilegatura</h3>
        <form method="dialog"><button><span class="material-symbols-outlined text-xl">close</span></button></form>
    </section>
    <section class="modal--body h-full">
        <form id="form--rilegature" class="flex h-max">
            <div class="attachment--rilegatura flex-1 flex flex-col gap-2 p-4"><span>Immagine Rilegatura</span><button class="select--rilegatura flex-1 border border-slate-200 border-dashed text-slate-500 rounded-md"><span class="material-symbols-outlined text-3xl">add</span><img id="selected--image" class="hidden w-[300px] h-[300px] object-contain p-2" /></button></div>
            <div class="inputs--rilegatura flex-1 flex flex-col gap-2 p-4">
                <label for="nome_rilegatura">Nome rilegatura</label>
                <input type="text" name="nome_rilegatura" class="w-full p-2" required/>
                <label for="descrizione_rilegatura">Descrizione rilegatura</label>
                <textarea name="descrizione_rilegatura" class="full resize-none p-2" rows="10" required></textarea>
                <button type="submit" id="submit--rilegature" class="bg-cyan-800 text-white p-2 rounded-md mt-2 disabled:opacity-25">SALVA</button>
                <button type="reset" id="reset--rilegature" class="bg-cyan-800 text-white p-2 rounded-md mt-2">CANCELLA</button>
            </div>
        </form>
    </section>
</dialog>
<dialog id="update--thesis" class="min-w-[30vw] min-h-[30vh] p-4 rounded-md">
    <section class="modal--heading flex justify-between items-center">
        <h3 class="font-bold text-xl">Modifica rilegatura</h3>
        <form method="dialog"><button><span class="material-symbols-outlined text-xl">close</span></button></form>
    </section>
    <section class="modal--body h-full">
        <form id="form--update-rilegatura" class="flex h-max">
            <div class="attachment--rilegatura flex-1 flex flex-col gap-2 p-4"><span>Immagine Rilegatura</span><button class="update--rilegatura flex-1 border border-slate-200 border-dashed text-slate-500 rounded-md"><span class="material-symbols-outlined text-3xl">add</span><img id="updated--image" class="hidden w-[300px] h-[300px] object-contain p-2" /></button></div>
            <div class="inputs--rilegatura flex-1 flex flex-col gap-2 p-4">
                <label for="nome_rilegatura">Nome rilegatura</label>
                <input type="text" name="nome_rilegatura" class="w-full p-2" required/>
                <label for="descrizione_rilegatura">Descrizione rilegatura</label>
                <textarea name="descrizione_rilegatura" class="full resize-none p-2" rows="10" required></textarea>
                <button type="submit" id="submit--update" class="bg-cyan-800 text-white p-2 rounded-md mt-2 disabled:opacity-25">SALVA</button>
                <button type="reset" id="reset--update" class="bg-cyan-800 text-white p-2 rounded-md mt-2">CANCELLA</button>
            </div>
        </form>
    </section>
</dialog>
<div id="toast" class="fixed hidden pointer-events-auto bg-green-700 text-white bottom-0 right-0 items-center justify-between p-4 m-4 z-50 gap-4 rounded-md">
    <div class="icon flex items-center"></div>
    <div class="body text-sm flex items-center"></div>
</div>
<?php
/* Script per Rilegature */
wp_enqueue_script('thesis-rilegature', THESIS_URL . "app/assets/js/thesis-rilegature.admin.js");
?>