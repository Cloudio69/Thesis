<?php
if (!isset($_POST)) $success = false;

if (isset($_POST['submit'])) {
    $class_bottone = sanitize_text_field($_POST['class_bottone']);
    $pagina_configuratore = sanitize_text_field($_POST['wordpress--page']);
    update_option('class_bottone', $class_bottone);
    update_option('pagina_configuratore', $pagina_configuratore);

    $success = true;
} else {
    $success = false;
}

$opzione_salvata = get_option('pagina_configuratore');
$id_salvato = get_option('class_bottone');

?>



<div class="thesis--wrapper p-6 h-full">
    <?php include_once(THESIS_DIR . 'app/views/admin/components/welcome.php'); ?>
    <section class="body flex flex-col mt-4 gap-4 h-full">
        <?php include_once(THESIS_DIR . 'app/views/admin/components/header.php') ?>
        <?php if ($success) echo "<p class='success bg-green-700 items-center text-lg text-white p-4 m-0 rounded-md flex justify-between'>Impostazioni aggiornate <button class='material-symbols-outlined'>close</button></p>" ?>
        <div class="thesis--manager flex flex-col p-4 bg-white border rounded-md">
            <form method="post">
                <h1 class="text-xl font-bold mb-2">Configuratore</h1>
                <p class="opacity-75 mb-4">Da qui puoi scegliere dove visualizzare il configuratore delle tesi</p>
                <select name="wordpress--page" class="w-[10rem]">
                    <?php $pages = get_pages();
                    foreach ($pages as $page) {
                        if ($page->post_name == $opzione_salvata) {
                            echo '<option selected value="' . $page->post_name . '">' . $page->post_title . '</option>';
                        } else {
                            echo '<option value="' . $page->post_name . '">' . $page->post_title . '</option>';
                        }
                    }
                    ?>
                </select>
                <h1 class="text-xl font-bold mb-2 mt-8">Bottone Upload</h1>
                <p class="opacity-75 mb-4">Inserisci la classe del bottone da usare per inizializzare il configuratore</p>
                <input type="text" name="class_bottone" value="<?php echo $id_salvato; ?>" placeholder="Inserisci senza #" />

                <?php submit_button('Salva impostazioni'); ?>
            </form>
        </div>
    </section>
</div>