<div class="thesis--wrapper p-6 h-full">
    <?php include_once(THESIS_DIR . 'app/views/admin/components/welcome.php'); ?>
    <section class="body flex flex-col mt-4 gap-4 h-full">
        <?php include_once(THESIS_DIR . 'app/views/admin/components/header.php') ?>
        <div class="thesis--orders flex gap-4">
            <div class="thesis--sidebar flex flex-col gap-4 max-w-64">
                <div class="thesis--info bg-white p-4 rounded-md border border-slate-200">
                    <h3 class="text-2xl font-bold flex items-center gap-2"><span class="material-symbols-outlined text-amber-300 drop-shadow-sm">info</span><span>Ordini</span></h3>
                    <p class="mt-2">Da qui puoi vedere un riepilogo degli ordini effettuati dai clienti</p>
                </div>
            </div>
            <div class="thesis--manager flex flex-1 rounded-md bg-white w-full">
                <table class="table-auto border-collapse w-full">
                    <tr class="divide-x rounded-md">
                        <th class="border border-slate-200 px-4">Ordine #ID</th>
                        <th class="border border-slate-200 px-4">Nome Cliente</th>
                        <th class="border border-slate-200 px-4">File</th>
                        <th class="border border-slate-200 px-4">Importo</th>
                    </tr>
                    <tr>
                        <td class="border border-slate-200 px-4">Prova</td>
                        <td class="border border-slate-200 px-4">Prova</td>
                        <td class="border border-slate-200 px-4">Prova</td>
                        <td class="border border-slate-200 px-4">Prova</td>
                    </tr>
                </table>
            </div>
        </div>
    </section>
</div>