<div class="thesis--wrapper p-6 h-full">
    <?php include_once(THESIS_DIR . 'app/views/admin/components/welcome.php'); ?>
    <section class="body flex flex-col mt-4 gap-4 h-full">
        <?php include_once(THESIS_DIR . 'app/views/admin/components/header.php') ?>
        <div class="thesis--copertine flex gap-4">
            <div class="thesis--sidebar flex flex-col gap-4 max-w-64">
                <div class="thesis--info bg-white p-4 rounded-md border border-slate-200">
                    <h3 class="text-2xl font-bold flex items-center gap-2"><span class="material-symbols-outlined text-amber-300 drop-shadow-sm">info</span><span>Copertine</span></h3>
                    <p class="mt-2">Da qui puoi vedere tutte le copertine, puoi creare le copertine cliccando sul pulsante "+"</p>
                </div>
            </div>
            <div class="thesis--manager flex flex-1 flex-col rounded-md bg-white w-full border border-slate-200 p-4">
                <h3 class="font-bold text-xl flex items-center justify-between mb-4"><span>Copertine</span><button id="aggiungi--copertina"><span class="material-symbols-outlined rounded-full bg-cyan-500 text-white transition-all hover:bg-slate-500">add</span></button></h3>
                <div>Non ci sono copertine.</div>
            </div>
        </div>
    </section>
</div>
<dialog id="modal--thesis" class="min-w-[30vw] min-h-[30vh] p-4 rounded-md">
    <section class="modal--heading flex justify-between items-center">
        <h3 class="font-bold text-xl mb-4">Aggiungi copertina</h3>
        <form method="dialog"><button><span class="material-symbols-outlined text-xl">close</span></button></form>
    </section>
    <section class="modal--body h-full">
        <form id="form--copertine" class="flex h-max divide-x">
            <div class="attachment--copertina flex-1 flex flex-col gap-2 p-4"><span>Immagine Copertina</span><button class="select--copertina flex-1 border border-dashed border-slate-500 bg-slate-300 text-slate-500 rounded-md"><span class="material-symbols-outlined text-3xl">add</span><img id="selected--image" class="hidden w-[300px] h-[300px] object-contain" /></button></div>
            <div class="inputs--copertina flex-1 flex flex-col gap-2 p-4">
                <label for="nome_copertina">Nome copertina</label>
                <input type="text" name="nome_copertina" class="w-full p-2"/>
                <label for="descrizione_copertina">Descrizione copertina</label>
                <textarea name="descrizione_copertina" class="full resize-none p-2" rows="10" ></textarea>
                <button type="submit" id="submit--copertine" class="bg-cyan-500 text-white p-2 rounded-md mt-2">SALVA</button>
                <button type="reset" id="reset--copertine" class="bg-cyan-500 text-white p-2 rounded-md mt-2">CANCELLA</button>
            </div>
        </form>
    </section>
</dialog>
<?php
/* Script per Copertine */
wp_enqueue_script('thesis-copertine', THESIS_URL . "app/assets/js/thesis-copertine.admin.js");
?>