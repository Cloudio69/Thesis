<div class="thesis--colori-carattere flex gap-4">
    <div class="thesis--sidebar flex flex-col gap-4 max-w-64">
        <div class="thesis--info bg-white p-4 rounded-md border border-slate-200">
            <h3 class="text-2xl font-bold flex items-center gap-2"><span class="material-symbols-outlined text-amber-300 drop-shadow-sm">info</span><span>Colori Carattere</span></h3>
            <p class="mt-2">Da qui puoi vedere tutte i colori carattere, puoi creare i colori carattere cliccando sul pulsante "+"</p>
        </div>
    </div>
    <div class="thesis--manager flex flex-1 flex-col rounded-md bg-white w-full border border-slate-200 p-4">
        <h3 class="font-bold text-xl flex items-center justify-between mb-4"><span class="flex gap-4 items-center"><span class="material-symbols-outlined text-amber-300 drop-shadow-sm">border_color</span><span>Colori carattere</span></span></h3>
        <div id="list--varianti" class="w-full p-4 animate-pulse bg-gray-200 rounded-md h-60"></div>
    </div>
</div>

<?php wp_enqueue_script('thesis-char-colors', THESIS_URL . "app/assets/js/thesis-char-colors.admin.js");