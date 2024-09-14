<?php

if (get_option('prezzo_angoli') == '') update_option('prezzo_angoli', '4.00'); 
if (get_option('prezzo_segnalibri') == '') update_option('prezzo_segnalibri', '2.00');

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
                    <form id="form--prezzi-accessori" class="flex flex-col gap-4">
                        <div class="thesis--prezzo-item flex justify-between items-center mb-2">
                            <label for="accessorio-angoli" class="text-sm font-medium">Angoli:</label>
                            <input type="number" min="1" step="any" id="accessorio-angoli" class="border border-slate-300 rounded-md p-2 max-w-24" placeholder="€" value="<?php echo get_option('prezzo_angoli'); ?>" />
                        </div>
                        <div class="thesis--prezzo-item flex justify-between items-center mb-2">
                            <label for="accessorio-segnalibri" class="text-sm font-medium">Segnalibri: </label>
                            <input type="number" min="1" step="any" id="accessorio-segnalibri" class="border border-slate-300 rounded-md p-2 max-w-24" placeholder="€" value="<?php echo get_option('prezzo_segnalibri'); ?>" />
                        </div>
                        <?php submit_button('Salva', 'primary', 'submit', false);?>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>