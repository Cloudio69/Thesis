<div id="pagine_step" class="p-12 flex flex-col gap-4">
    <h1 class="text-3xl font-bold">Scegli il colore di stampa</h1>
    <p>Qui puoi controllare il numero totale di pagine rilevate in bianco e nero e a colori., il processo è automatico dunque potrai riscontrare degli errori. Puoi filtrare le pagine cliccando sui contatori per tipo di stampa<br><br><b>Clicca sui pulsanti per cambiare la modalità di stampa, cliccando sull'immagine ti verrà mostrata l'anteprima* <br><br>
            <p class="text-sm opacity-50">* L'anteprima viene mostrata a colori</p>
        </b></p>
    <section class="colori--stampa flex flex-col gap-4 justify-center mt-4">
        <div class="flex items-center justify-around gap-8 my-4">
            <div id="bianco--nero" class="flex flex-col gap-4 items-center flex-1 cursor-pointer ">
                <span class="text-7xl p-4 animate-pulse rounded-md border-slate-300 border-2 min-w-[200px] min-h-[200px] flex items-center justify-center">0</span>
                <b>PAGINE BIANCO E NERO</b>
            </div>
            <div id="colore" class="flex flex-col gap-4 items-center flex-1 cursor-pointer">
                <span class="text-7xl p-4 animate-pulse rounded-md border-slate-300 border-2 min-w-[200px] min-h-[200px] flex items-center justify-center">0</span>
                <b>PAGINE A COLORI</b>
            </div>
        </div>
        <h1 class="flex-1 font-bold mt-4">Azioni Stampa</h1>
        <p class="mb-4">Puoi anche cambiare comodamente la stampa di tutte le pagine con i bottoni sottostanti</p>
        <div class="azioni--massive flex w-full gap-2">
            <button id="stampa_bn" class="btn--massive bg-slate-50 text-black border border-slate-50 flex-1 p-4 rounded-md flex flex-col items-center justify-center"><img src="/wp-content/plugins/thesis/app/assets/img/svg/black-and-white.svg" class="w-6 h-6" alt="TUTTE BIANCO E NERO"><span>BIANCO E NERO</span></button>
            <button id="stampa_colori" class="btn--massive bg-slate-50 text-black border border-slate-50 flex-1 p-4 rounded-md flex flex-col items-center justify-center"><img src="/wp-content/plugins/thesis/app/assets/img/svg/rgb.svg" class="w-6 h-6" alt="TUTTE A COLORI"><span>A COLORI</span></button>
        </div>
    </section>
    <section class="subtotale_pagine mt-4 py-6 animate-pulse">
        <h1 class="font-bold text-xl flex gap-2 items-center"><span class="material-symbols-outlined">euro_symbol</span>Subtotale</h1>
        <div class="p-4">
            <div class="flex space-between gap-2">
                <span class="flex-1">Pagine B/N</span>
                <span id="subtotale_bn"><b>0</b></span>
            </div>
            <div class="flex space-between gap-2">
                <span class="flex-1">Pagine a colori</span>
                <span id="subtotale_colori"><b>0</b></span>
            </div>
            <div class="flex space-between gap-2">
                <span class="flex-1">Prezzo pagine B/N</span>
                <span id="prezzo_bn"><b>0</b></span>
            </div>
            <div class="flex space-between gap-2">
                <span class="flex-1">Prezzo pagine a colori</span>
                <span id="prezzo_colori"><b>0</b></span>
            </div>
            <div class="flex space-between gap-2 border-t mt-2 py-2">
                <span class="flex-1">Totale</span>
                <span id="totale_pagine"><b>0</b></span>
            </div>
        </div>
    </section>

</div>