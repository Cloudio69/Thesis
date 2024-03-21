<div class="thesis--colori-carattere flex gap-4">
    <div class="thesis--sidebar flex flex-col gap-4 max-w-64">
        <div class="thesis--info bg-white p-4 rounded-md border border-slate-200">
            <h3 class="text-2xl font-bold flex items-center gap-2"><span class="material-symbols-outlined text-amber-300 drop-shadow-sm">info</span><span>Colori Carattere</span></h3>
            <p class="mt-2">Da qui puoi vedere tutte i colori carattere, puoi creare i colori carattere cliccando sul pulsante "+"</p>
        </div>
    </div>
    <div class="thesis--manager flex flex-1 flex-col rounded-md bg-white w-full border border-slate-200 p-4">
        <h3 class="font-bold text-xl flex items-center justify-between mb-4"><span class="flex gap-4 items-center"><span class="material-symbols-outlined text-amber-300 drop-shadow-sm">border_color</span><span>Colori carattere</span></span></h3>
        <div class="thesis--chars-manager flex gap-4">
            <div class="lista--colori border p-4 rounded-md w-1/3">
                <h3 class="font-bold text-md flex items-center gap-4 justify-between mb-2"><span>Colori</span><span class="material-symbols-outlined rounded-full bg-cyan-500 text-white transition-all hover:bg-slate-500">add</span></h3>
                <div id="lista--colori">Non ci sono colori.</div>
            </div>
            <div id="lista--colori-assegnati" class="w-full p-4 animate-pulse bg-gray-200 rounded-md h-60 flex-1"></div>
        </div>
    </div>
</div>

<?php wp_enqueue_script('thesis-char-colors', THESIS_URL . "app/assets/js/thesis-char-colors.admin.js");