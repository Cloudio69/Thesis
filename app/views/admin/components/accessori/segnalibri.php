<div class="thesis--manager flex flex-1 flex-col rounded-md bg-white w-full border border-slate-200 p-4">
    <h3 class="font-bold text-xl flex items-center justify-between mb-4"><span class="flex gap-4 items-center"><span class="material-symbols-outlined text-amber-300 drop-shadow-sm">bookmark</span><span>Segnalibri</span></span><button id="aggiungi--segnalibri"><span class="material-symbols-outlined rounded-full bg-cyan-500 text-white transition-all hover:bg-slate-500">add</span></button></h3>
    <div id="list--segnalibri" class="grid auto-cols-fr w-full p-4 animate-pulse bg-gray-200 rounded-md h-24"></div>
</div>
<dialog id="dialog--segnalibri" class="min-w-[30vw] min-h-[30vh] p-4 rounded-md">
    <section class="modal--heading flex justify-between items-center">
        <h3 class="font-bold text-xl">Aggiungi segnalibro</h3>
        <form method="dialog"><button><span class="material-symbols-outlined text-xl">close</span></button></form>
    </section>
    <section class="modal--body h-full">
        <form id="form--segnalibro" class="flex flex-col h-max">
            <div class="attachment--segnalibro flex-1 flex flex-col gap-2 p-4"><span>Immagine segnalibro</span><button class="select--segnalibro min-h-[300px] flex items-center justify-center flex-1 border border-slate-200 border-dashed text-slate-500 rounded-md"><span class="material-symbols-outlined text-3xl">add</span><img id="selected--image-segnalibro" class="hidden w-[300px] h-[300px] object-contain p-2" /></button></div>
            <div class="inputs--segnalibro flex-1 flex flex-col gap-2 p-4">
                <label for="nome_segnalibro">Nome segnalibro</label>
                <input type="text" name="nome_segnalibro" class="w-full p-2" required />
                <button type="submit" id="submit--segnalibro" class="bg-cyan-800 text-white p-2 rounded-md mt-2 disabled:opacity-25">SALVA</button>
                <button type="reset" id="reset--segnalibro" class="bg-cyan-800 text-white p-2 rounded-md mt-2">CANCELLA</button>
            </div>
        </form>
    </section>
</dialog>
<?php wp_enqueue_script('thesis-segnalibri', THESIS_URL . "app/assets/js/accessori/thesis-segnalibri.admin.js") ?>