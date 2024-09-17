<div id="rilegature_step" class="p-12 flex flex-col gap-4">
    <h1 class="text-3xl font-bold">Scegli la rilegatura</h1>
    <p>Tutta la libertà che vuoi con CheTesi! Puoi personalizzare la Rilegatura, il suo colore ed il carattere, tipo di carta e grammatura e aggiungere angoli metallici e segnalibro.</p>
    <b>Clicca sopra per visualizzare l'anteprima dettagliata</b>
    <section class="lista--opzioni h-full flex flex-col justify-center mt-4 gap-4">
        <form id="rilegature_form" class="flex flex-col gap-4">
            <div class="rilegature flex flex-col gap-4">
                <h1 class="font-bold text-xl flex gap-2 items-center"><span class="material-symbols-outlined">book_2</span>Rilegature</h1>
                <div class="grid grid-cols-3 gap-4 items-center place-items-center text-center">
                    <?php

                    $prezzo_angoli = get_option('prezzo_angoli');
                    $prezzo_segnalibri = get_option('prezzo_segnalibri');
                    $rilegature = new Rilegatura;
                    $query = $rilegature->get_rilegature();

                    $decodedRilegature = json_decode($query);

                    for ($i = 0; $i < count($decodedRilegature); $i++) {
                    ?>
                        <label for="<?php echo $decodedRilegature[$i]->id_rilegatura; ?>" class="card rilegatura bg-slate-50 border flex flex-col font-bold rounded-md w-full justify-center items-center overflow-hidden">
                            <img src="<?php echo $decodedRilegature[$i]->anteprima_rilegatura ?>" class="w-32 h-32 object-contain p-4" />
                            <div class="flex justify-between items-center w-full p-4 bg-white border-t">
                                <h3><?php echo $decodedRilegature[$i]->nome_rilegatura ?></h3>
                                <span class="!text-sm"><?php echo $decodedRilegature[$i]->prezzo_rilegatura ?> €</span>
                            </div>
                            <input type="radio" data-nome="<?php echo $decodedRilegature[$i]->nome_rilegatura ?>" data-prezzo="<?php echo $decodedRilegature[$i]->prezzo_rilegatura ?>" data-descrizione="<?php echo htmlspecialchars($decodedRilegature[$i]->descrizione_rilegatura, ENT_QUOTES, 'UTF-8') ?>" name="rilegatura" value="<?php echo $decodedRilegature[$i]->id_rilegatura; ?>" id="<?php echo $decodedRilegature[$i]->id_rilegatura; ?>" class="hidden" />
                        </label>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="varianti flex flex-col gap-4 mt-4">
                <h1 class="font-bold text-xl flex gap-2 items-center"><span class="material-symbols-outlined">palette</span>Varianti colore</h1>
                <div class="flex gap-4 items-center place-items-center text-center">
                    <p class="opacity-50">Scegli prima una rilegatura.</p>
                </div>
            </div>
            <div class="colori_carattere flex flex-col gap-4 mt-4">
                <h1 class="font-bold text-xl flex gap-2 items-center"><span class="material-symbols-outlined">border_color</span>Colori carattere</h1>
                <div class="flex gap-4 items-center place-items-center text-center">
                    <p class="opacity-50">Scegli prima una rilegatura.</p>
                </div>
            </div>
            <div class="section_accessori">
                <div class="carta_grammatura flex flex-col gap-4 mt-4">
                    <h1 class="font-bold text-xl flex gap-2 items-center"><span class="material-symbols-outlined">article</span>Carta e grammatura</h1>
                    <div class="flex gap-4 items-center place-items-center text-center">
                        <select name="grammatura" class="p-2 rounded-md" required>
                            <option value="" selected disabled>Seleziona la grammatura</option>
                            <?php

                            $grammature = new Grammatura;
                            $grammature = $grammature->get_grammature();
                            $decodedGrammature = json_decode($grammature);

                            foreach ($decodedGrammature as $grammatura) {
                                echo "<option value=\"$grammatura->id_grammatura\" data-prezzo=\"$grammatura->prezzo_grammatura\">$grammatura->nome_grammatura</option>";
                            }
                            ?>
                        </select>
                        <select name="formato" class="p-2 rounded-md">
                            <option value="" selected disabled>Seleziona il formato</option>
                            <option value="formato-a4" data-prezzo="<?php echo get_option('prezzo_a4') ?>">A4</option>
                            <option value="formato-a3" data-prezzo="<?php echo get_option('prezzo_a3') ?>">A3</option>
                        </select>
                    </div>
                </div>
                <div class="angoli flex flex-col gap-4 mt-4">
                    <h1 class="font-bold text-xl flex gap-2 items-center"><span class="material-symbols-outlined">arrows_more_up</span>Angoli</h1>
                    <div class="flex gap-4 items-center place-items-center text-center">
                        <select name="angoli" class="p-2 rounded-md" required>
                            <option value="" selected disabled>Seleziona gli angoli</option>
                            <?php
                            $angoli = new Angolo;
                            $angoli = $angoli->get_angoli();
                            $decodedAngoli = json_decode($angoli);

                            foreach ($decodedAngoli as $angolo) {
                                echo "<option value=\"$angolo->id_angolo\" data-src=\"$angolo->anteprima_angolo\" data-prezzo=\"$prezzo_angoli\">$angolo->nome_angolo</option>";
                            }

                            ?>
                        </select>
                    </div>
                </div>
                <div class="segnalibri flex flex-col gap-4 mt-4">
                    <h1 class="font-bold text-xl flex gap-2 items-center"><span class="material-symbols-outlined">bookmark</span>Segnalibri</h1>
                    <div class="flex gap-4 items-center place-items-center text-center">
                        <select name="segnalibri" class="p-2 rounded-md" required>
                            <option value="" selected disabled>Seleziona il segnalibro</option>
                            <?php
                            $segnalibri = new Segnalibro;
                            $segnalibri = $segnalibri->get_segnalibri();
                            $decodedSegnalibri = json_decode($segnalibri);

                            foreach ($decodedSegnalibri as $segnalibro) {
                                echo "<option value=\"$segnalibro->id_segnalibro\" data-src=\"$segnalibro->anteprima_segnalibro\" data-prezzo=\"$prezzo_segnalibri\">$segnalibro->nome_colore</option>";
                            }

                            ?>
                        </select>
                    </div>
                </div>
                <div class="quantita flex flex-col gap-4 mt-4">
                    <h1 class="font-bold text-xl flex gap-2 items-center"><span class="material-symbols-outlined">add_shopping_cart</span>Quantità</h1>
                    <div class="flex gap-4 items-center place-items-center text-center">
                        <input type="number" name="quantita" class="w-24 p-2 rounded-md" value="1" min="1" required />
                        <button type="submit" class="rounded-md bg-slate-600 hover:bg-slate-400 text-white border-none focus:bg-yellow-400">AGGIUNGI AL CARRELLO</button>
                    </div>
                </div>
                <div class="subtotale_rilegature mt-24">
                    <div class="scelte_rilegature flex gap-4 items-start justify-between mt-4">
                        <h1 class="font-bold text-xl flex gap-2 items-center"><span class="material-symbols-outlined">euro_symbol</span>Subtotale</h1>
                        <p class="font-bold text-2xl" id="subtotale_rilegature">0.00 €</p>
                    </div>
                    <div class="font-bold text-sm mt-4 flex items-start gap-4"><span class="material-symbols-outlined text-3xl !text-white bg-amber-400 rounded-full">info</span><p class="text-neutral-500"> il formato e la grammatura sono moltiplicati per le pagine e non influiscono sul prezzo della rilegatura </p></div>
                </div>
            </div>
        </form>
        <div class="fixed bg-white flex flex-col gap-2 rounded-md p-4 min-w-[15%] max-w-[15%] left-[43%] top-24 m-4 shadow-md">
            <h1 class="font-bold text-lg">Rilegatura</h1>
            <section class="rilegature_riepilogo">
                <p class="opacity-50 text-sm">Seleziona una rilegatura per scoprirne le caratteristiche.</p>
            </section>
        </div>
</div>