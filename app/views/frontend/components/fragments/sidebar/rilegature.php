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
include_once THESIS_DIR . "app/includes/models/rilegature.php";
$rilegature = new Rilegatura;
$query = $rilegature->get_rilegature();

$decodedRilegature = json_decode($query);

for ($i = 0; $i < count($decodedRilegature); $i++) {
    ?>
                        <label for="<?php echo $decodedRilegature[$i]->id_rilegatura; ?>" class="card bg-slate-50 border flex flex-col font-bold rounded-md w-full justify-center items-center overflow-hidden">
                            <img src="<?php echo $decodedRilegature[$i]->anteprima_rilegatura ?>" class="w-32 h-32 object-contain p-4"/>
                            <div class="flex justify-between items-center w-full p-4 bg-white border-t">
                                <h3><?php echo $decodedRilegature[$i]->nome_rilegatura ?></h3>
                                <span class="!text-sm"><?php echo $decodedRilegature[$i]->prezzo_rilegatura ?> €</span>
                            </div>
                            <input type="radio" name="rilegatura" value="<?php echo $decodedRilegature[$i]->id_rilegatura; ?>" id="<?php echo $decodedRilegature[$i]->id_rilegatura; ?>" class="hidden"/>
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
        <div class="carta_grammatura flex flex-col gap-4 mt-4">
            <h1 class="font-bold text-xl flex gap-2 items-center"><span class="material-symbols-outlined">article</span>Carta e grammatura</h1>
            <div class="flex gap-4 items-center place-items-center text-center">
                <select name="grammatura" class="p-2 rounded-md" required>
                    <option value="" selected disabled>Seleziona la grammatura</option>
                    <option value="grammatura-80">80 gr.</option>
                    <option value="grammatura-100">100 gr. patinata</option>
                    <option value="grammatura-120">120 gr. uso mano</option>
                </select>
                <select name="formato" class="p-2 rounded-md">
                    <option value="" selected disabled>Seleziona il formato</option>
                    <option value="formato-a4">A4</option>
                    <option value="formato-a3">A3</option>
                </select>
            </div>
        </div>
        <div class="angoli flex flex-col gap-4 mt-4">
            <h1 class="font-bold text-xl flex gap-2 items-center"><span class="material-symbols-outlined">arrows_more_up</span>Angoli</h1>
            <div class="flex gap-4 items-center place-items-center text-center">
                <select name="angoli" class="p-2 rounded-md" required>
                    <option value="" selected disabled>Seleziona gli angoli</option>
                    <option value="angoli-dorati">Dorati</option>
                    <option value="angoli-argentati">Argentati</option>
                </select>
            </div>
        </div>
        <div class="segnalibri flex flex-col gap-4 mt-4">
            <h1 class="font-bold text-xl flex gap-2 items-center"><span class="material-symbols-outlined">bookmark</span>Segnalibri</h1>
            <div class="flex gap-4 items-center place-items-center text-center">
                <p class="opacity-50">Scegli prima una rilegatura.</p>
            </div>
        </div>
        <div class="quantita flex flex-col gap-4 mt-4">
            <h1 class="font-bold text-xl flex gap-2 items-center"><span class="material-symbols-outlined">add_shopping_cart</span>Quantità</h1>
            <div class="flex gap-4 items-center place-items-center text-center">
                <input type="number" name="quantita" class="w-24 p-2 rounded-md" value="1" min="1" required />
            </div>
        <button type="submit" class="rounded-md bg-slate-600 hover:bg-slate-400 text-white border-none focus:bg-yellow-400">SALVA</button>
        </form>
    </section>
</div>