<div class="thesis--manager flex flex-1 flex-col rounded-md bg-white w-full border border-slate-200 p-4">
    <h3 class="font-bold text-xl flex items-center justify-between mb-4"><span class="flex gap-4 items-center"><span class="material-symbols-outlined text-amber-300 drop-shadow-sm">bookmark</span><span>Segnalibri</span></span><button id="aggiungi--segnalibri"><span class="material-symbols-outlined rounded-full bg-cyan-500 text-white transition-all hover:bg-slate-500">add</span></button></h3>
    <div id="list--segnalibri" class="grid auto-cols-fr w-full p-4 animate-pulse bg-gray-200 rounded-md h-60"></div>
</div>
<?php wp_enqueue_script('thesis-segnalibri', THESIS_URL . "app/assets/js/accessori/thesis-segnalibri.admin.js") ?>