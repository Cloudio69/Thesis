<?php

if (get_option('prezzo_angoli') == '') update_option('prezzo_angoli', '4.00'); 
if (get_option('prezzo_segnalibri') == '') update_option('prezzo_segnalibri', '2.00');
if (get_option('prezzo_bn') == '') update_option('prezzo_bn', '0.04');
if (get_option('prezzo_colori') == '') update_option('prezzo_colori', '0.40');
if (get_option('prezzo_a4') == '') update_option('prezzo_a4', '0.00');
if (get_option('prezzo_a3') == '') update_option('prezzo_a3', '0.04');
if (get_option('prezzo_cd') == '') update_option('prezzo_cd', '10.00');

if(isset($_POST['submit'])) {
    update_option('prezzo_angoli', $_POST['accessorio-angoli']);
    update_option('prezzo_segnalibri', $_POST['accessorio-segnalibri']);
    update_option('prezzo_bn', $_POST['accessorio-bn']);
    update_option('prezzo_colori', $_POST['accessorio-colori']);
    update_option('prezzo_a4', $_POST['accessorio-a4']);
    update_option('prezzo_a3', $_POST['accessorio-a3']);
    update_option('prezzo_cd', $_POST['cd']);
}

?>


<div class="thesis--wrapper p-6 h-full">
    <?php include_once(THESIS_DIR . 'app/views/admin/components/welcome.php'); ?>
    <section class="body flex flex-col mt-4 gap-4 h-full">
        <?php include_once(THESIS_DIR . 'app/views/admin/components/header.php') ?>
        <div class="thesis--accessori flex gap-4">
            <div class="thesis--sidebar flex flex-col gap-4 max-w-64">
                <div class="thesis--info bg-white p-4 rounded-md border border-slate-200">
                    <h3 class="text-2xl font-bold flex items-center gap-2"><span class="material-symbols-outlined text-amber-300 drop-shadow-sm">info</span><span>Accessori</span></h3>
                    <p class="mt-2">Da qui puoi vedere gli angoli, i segnalibri e le grammature puoi creare gli accessori cliccando sul pulsante "+"</p>
                </div>
            </div>
            <div class="thesis--manager flex flex-1 gap-4 flex-col rounded-md bg-white w-full border border-slate-200 p-4">
                <div class="thesis--rilegature flex gap-4">
                    <?php include_once THESIS_DIR . "app/views/admin/components/accessori/angoli.php"; ?>
                </div>
                <div class="thesis--segnalibri flex gap-4">
                    <?php include_once THESIS_DIR . "app/views/admin/components/accessori/segnalibri.php"; ?>
                </div>
                <div class="thesis--grammature flex gap-4">       
                    <?php include_once THESIS_DIR . "app/views/admin/components/accessori/grammature.php"; ?>
                </div>
            </div>
            <div class="thesis--prezzi-accessori">
                <div class="thesis--prezzi flex flex-col gap-4 bg-white p-4 rounded-md border border-slate-200">
                    <h3 class="text-base font-bold mb-2">Prezzi accessori</h3>
                    <p>Imposta il prezzo fisso degli accessori</p>
                    <form method="post" id="form--prezzi-accessori" class="flex flex-col gap-4">
                        <div class="thesis--prezzo-item flex justify-between items-center mb-2">
                            <label for="accessorio-angoli" class="text-sm font-medium">Angoli:</label>
                            <input type="number" min="0.00" step="any" id="accessorio-angoli" name="accessorio-angoli" class="border border-slate-300 rounded-md p-2 max-w-24" placeholder="€" value="<?php echo get_option('prezzo_angoli'); ?>" />
                        </div>
                        <div class="thesis--prezzo-item flex justify-between items-center mb-2">
                            <label for="accessorio-segnalibri" class="text-sm font-medium">Segnalibri: </label>
                            <input type="number" min="0.00" step="any" id="accessorio-segnalibri" name="accessorio-segnalibri" class="border border-slate-300 rounded-md p-2 max-w-24" placeholder="€" value="<?php echo get_option('prezzo_segnalibri'); ?>" />
                        </div>
                        <div class="thesis--prezzo-item flex justify-between items-center mb-2">
                            <label for="accessorio-bn" class="text-sm font-medium">Pagine B/N: </label>
                            <input type="number" min="0.00" step="any" id="accessorio-bn" name="accessorio-bn" class="border border-slate-300 rounded-md p-2 max-w-24" placeholder="€" value="<?php echo get_option('prezzo_bn'); ?>" />
                        </div>
                        <div class="thesis--prezzo-item flex justify-between items-center mb-2">
                            <label for="accessorio-colori" class="text-sm font-medium">Pagine colori: </label>
                            <input type="number" min="0.00" step="any" id="accessorio-colori" name="accessorio-colori" class="border border-slate-300 rounded-md p-2 max-w-24" placeholder="€" value="<?php echo get_option('prezzo_colori'); ?>" />
                        </div>
                        <div class="thesis--prezzo-item flex justify-between items-center mb-2">
                            <label for="accessorio-a4" class="text-sm font-medium">Formato A4: </label>
                            <input type="number" min="0.00" step="any" id="accessorio-a4" name="accessorio-a4" class="border border-slate-300 rounded-md p-2 max-w-24" placeholder="€" value="<?php echo get_option('prezzo_a4'); ?>" />
                        </div>
                        <div class="thesis--prezzo-item flex justify-between items-center mb-2">
                            <label for="accessorio-a3" class="text-sm font-medium">Formato A3: </label>
                            <input type="number" min="0.00" step="any" id="accessorio-a3" name="accessorio-a3" class="border border-slate-300 rounded-md p-2 max-w-24" placeholder="€" value="<?php echo get_option('prezzo_a3'); ?>" />
                        </div>
                        <div class="thesis--prezzo-item flex justify-between items-center mb-2">
                            <label for="cd" class="text-sm font-medium">Prezzo CD: </label>
                            <input type="number" min="0.00" step="any" id="accessorio-a3" name="cd" class="border border-slate-300 rounded-md p-2 max-w-24" placeholder="€" value="<?php echo get_option('prezzo_cd'); ?>" />
                        </div>
                        
                        <p class="text-sm opacity-50">Il prezzo delle pagine verrà sommato al prezzo delle grammature e del formato</p>
                        <?php submit_button('Salva', 'primary', 'submit', false);?>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>