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
        </div>
    </section>
</div>