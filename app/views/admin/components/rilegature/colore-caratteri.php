<div class="thesis--colori-carattere flex gap-4">
    <div class="thesis--sidebar flex flex-col gap-4 max-w-64">
        <div class="thesis--info bg-white p-4 rounded-md border border-slate-200">
            <h3 class="text-2xl font-bold flex items-center gap-2"><span class="material-symbols-outlined text-amber-300 drop-shadow-sm">info</span><span>Colori carattere</span></h3>
            <p class="mt-2">Da qui puoi vedere tutte i colori carattere, puoi creare i colori carattere cliccando sul pulsante "+"</p>
        </div>
    </div>
    <div class="thesis--manager flex flex-1 flex-col rounded-md bg-white w-full border border-slate-200 p-4">
        <h3 class="font-bold text-xl flex items-center justify-between mb-4"><span class="flex gap-4 items-center"><span class="material-symbols-outlined text-amber-300 drop-shadow-sm">border_color</span><span>Colori carattere</span></span></h3>
        <div class="thesis--chars-manager flex gap-4">
            <div class="lista--colori border p-4 rounded-md w-3/5">
                <h3 class="font-bold text-md flex items-center gap-4 justify-between mb-4"><span>Colori</span><span id="aggiungi--colore" class="material-symbols-outlined rounded-full bg-cyan-500 text-white transition-all hover:bg-slate-500 cursor-pointer">add</span></h3>
                <div id="lista--colori" class="w-full p-4 animate-pulse bg-gray-200 rounded-md h-40 flex-1"></div>
            </div>
            <div class="lista--colori-assegnati border p-4 rounded-md w-full">
                <h3 class="font-bold text-md flex items-center gap-4 justify-between mb-4"><span>Colori associati</span><span id="associa--colore" class="material-symbols-outlined rounded-full bg-cyan-500 text-white transition-all hover:bg-slate-500 cursor-pointer">add</span></h3>
                <div id="lista--colori-assegnati" class="w-full flex animate-pulse bg-gray-200 rounded-md h-60 flex-1"></div>
            </div>
        </div>
    </div>
</div>
<dialog id="crea--colore" class="min-w-[20vw] min-h-[20vh] p-4 rounded-md">
    <section class="modal--heading flex justify-between items-center">
        <h3 class="font-bold text-xl">Crea colore</h3>
        <form method="dialog"><button><span class="material-symbols-outlined text-xl">close</span></button></form>
    </section>
    <section class="modal--body h-full">
        <form id="form--crea-colore" class="flex h-max">
            <div class="inputs--rilegatura flex-1 flex flex-col gap-2 p-4">
                <label for="nome_colore">Nome colore</label>
                <input type="text" name="nome_colore" required>
                <label for="hex_colore">Valore colore</label>
                <div class="flex items-stretch border rounded-md p-4">
                    <input type="color" id="hex_colore" name="hex_colore" class="active:!border-none !border-none w-[64px] h-[64px]">
                    <span id="colore--scelto" class="flex-1 !bg-transparent flex items-center justify-center text-xl font-bold cursor-pointer">#000000</span>
                </div>

                <div class="flex gap-1">
                    <button type="submit" id="submit--colore" class="bg-cyan-800 text-white p-2 rounded-md mt-2 disabled:opacity-25 flex-1">SALVA</button>
                    <button type="reset" id="reset--colore" class="bg-cyan-800 text-white p-2 rounded-md mt-2 flex-1">CANCELLA</button>
                </div>
            </div>
        </form>
    </section>
</dialog>
<dialog id="assoc--colore" class="min-w-[30vw] p-4 rounded-md">
    <section class="modal--heading flex justify-between items-center">
        <h3 class="font-bold text-xl">Associazione colore</h3>
        <form method="dialog"><button><span class="material-symbols-outlined text-xl">close</span></button></form>
    </section>
    <section class="modal--body h-full">
        <form id="form--assoc-colore" class="flex h-max">
            <div class="inputs--rilegatura flex-1 flex flex-col gap-2 p-4">
                <select id="select--rilegature-colori" class="w-full min-w-full !p-3 flex-1" name="select_colore"></select>
                <div id="color--list" class="grid grid-cols-3 gap-4 py-4">
                </div>
                <div class="flex gap-1">
                    <button type="submit" id="submit--associazione" class="bg-cyan-800 text-white p-2 rounded-md mt-2 disabled:opacity-25 flex-1">SALVA</button>
                    <button type="reset" id="reset--associazione" class="bg-cyan-800 text-white p-2 rounded-md mt-2 flex-1">CANCELLA</button>
                </div>
            </div>
        </form>
    </section>
</dialog>

<?php wp_enqueue_script('thesis-colore-caratteri', THESIS_URL . "app/assets/js/thesis-colore-caratteri.admin.js");
