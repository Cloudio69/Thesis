<div class="thesis--varianti-copertine flex gap-4">
    <div class="thesis--sidebar flex flex-col gap-4 max-w-64">
        <div class="thesis--info bg-white p-4 rounded-md border border-slate-200">
            <h3 class="text-2xl font-bold flex items-center gap-2"><span class="material-symbols-outlined text-amber-300 drop-shadow-sm">info</span><span>Varianti Colore</span></h3>
            <p class="mt-2">Da qui puoi vedere tutte le varianti colore, puoi creare le varianti colore cliccando sul pulsante "+"</p>
        </div>
    </div>
    <div class="thesis--manager flex flex-1 flex-col rounded-md bg-white w-full border border-slate-200 p-4">
        <h3 class="font-bold text-xl flex items-center justify-between mb-4"><span>Varianti colore</span><button id="aggiungi--variante"><span class="material-symbols-outlined rounded-full bg-cyan-500 text-white transition-all hover:bg-slate-500">add</span></button></h3>
        <div id="list--varianti" class="w-full p-4 animate-pulse bg-gray-200 rounded-md h-10"></div>
    </div>
</div>
<dialog id="modal--variants" class="min-w-[30vw] min-h-[30vh] p-4 rounded-md">
    <section class="modal--heading flex justify-between items-center">
        <h3 class="font-bold text-xl">Aggiungi variante</h3>
        <form method="dialog"><button><span class="material-symbols-outlined text-xl">close</span></button></form>
    </section>
    <section class="modal--body h-full">
        <form id="form--variante" class="flex h-max">
            <div class="attachment--variante flex-1 flex flex-col gap-2 p-4"><span>Immagine variante</span><button class="select--variante flex-1 border border-slate-200 border-dashed text-slate-500 rounded-md"><span class="material-symbols-outlined text-3xl">add</span><img id="selected--image-variante" class="hidden w-[300px] h-[300px] object-contain p-2" /></button></div>
            <div class="inputs--variante flex-1 flex flex-col gap-2 p-4">
                <label for="id_copertina">ID Copertina</label>
                <select id="lista_copertine"></select>
                <label for="nome_variante">Nome variante</label>
                <input type="text" name="nome_variante" class="w-full p-2" required/>
                <label for="descrizione_variante">Descrizione variante</label>
                <textarea name="descrizione_variante" class="full resize-none p-2" rows="10" required></textarea>
                <button type="submit" id="submit--variante" class="bg-cyan-800 text-white p-2 rounded-md mt-2 disabled:opacity-25">SALVA</button>
                <button type="reset" id="reset--variante" class="bg-cyan-800 text-white p-2 rounded-md mt-2">CANCELLA</button>
            </div>
        </form>
    </section>
</dialog>
<?php wp_enqueue_script('thesis-varianti', THESIS_URL . "app/assets/js/thesis-copertine-variants.admin.js"); ?>