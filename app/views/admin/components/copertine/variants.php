<div class="thesis--varianti-copertine flex gap-4">
    <div class="thesis--sidebar flex flex-col gap-4 max-w-64">
        <div class="thesis--info bg-white p-4 rounded-md border border-slate-200">
            <h3 class="text-2xl font-bold flex items-center gap-2"><span class="material-symbols-outlined text-amber-300 drop-shadow-sm">info</span><span>Varianti Colore</span></h3>
            <p class="mt-2">Da qui puoi vedere tutte le varianti colore, puoi creare le varianti colore cliccando sul pulsante "+"</p>
        </div>
    </div>
    <div class="thesis--manager flex flex-1 flex-col rounded-md bg-white w-full border border-slate-200 p-4">
        <h3 class="font-bold text-xl flex items-center justify-between mb-4"><span>Varianti colore</span><button id="aggiungi--copertina"><span class="material-symbols-outlined rounded-full bg-cyan-500 text-white transition-all hover:bg-slate-500">add</span></button></h3>
        <div id="list--varianti" class="w-full p-4 animate-pulse bg-gray-200 rounded-md h-10"></div>
    </div>
</div>
<?php wp_enqueue_script('thesis-varianti', THESIS_URL . "app/assets/js/thesis-copertine-variants.admin.js"); ?>