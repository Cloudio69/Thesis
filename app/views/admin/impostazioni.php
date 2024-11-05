<?php
if (!isset($_POST)) {
    $success = false;
}

delete_transient('dirsize_cache');

function readableBytes($bytes)
{
    if ($bytes <= 0) {
        return '0 B';
    }

    $i = floor(log($bytes) / log(1024));
    $sizes = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');

    return sprintf('%.02F', $bytes / pow(1024, $i)) * 1 . ' ' . $sizes[$i];
}

if (isset($_POST['submit'])) {
    $class_bottone = sanitize_text_field($_POST['class_bottone']);
    $pagina_configuratore = sanitize_text_field($_POST['wordpress--page']);
    $select_time = $_POST['time_schedule'];
    $popup_id = $_POST['popup_id'];
    update_option('class_bottone', $class_bottone);
    update_option('time_schedule', $select_time);
    update_option('pagina_configuratore', $pagina_configuratore);
    update_option('popup_id', $popup_id);

    $timestamp = wp_next_scheduled('thesis_clear_event');
    if ($timestamp) {
        wp_unschedule_event($timestamp, 'thesis_clear_event');
    }
    wp_schedule_event(time(), $select_time, 'thesis_clear_event');

    $success = true;
} else {
    $success = false;
}

$opzione_salvata = get_option('pagina_configuratore');
$id_salvato = get_option('class_bottone');
$time_schedule = get_option('time_schedule');
$popup_id = get_option('popup_id');
?>



<div class="thesis--wrapper p-6 h-full">
    <?php include_once THESIS_DIR . 'app/views/admin/components/welcome.php';?>
    <section class="body flex flex-col mt-4 gap-4 h-full">
        <?php include_once THESIS_DIR . 'app/views/admin/components/header.php'?>
        <?php if ($success) {
    echo "<p class='success bg-green-700 items-center text-lg text-white p-4 m-0 rounded-md flex justify-between'>Impostazioni aggiornate <button class='material-symbols-outlined'>close</button></p>";
}
?>
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
                <h1 class="text-xl font-bold mb-2 mt-8">Popup Abbandono</h1>
                <p class="opacity-75 mb-4">Seleziona il Popup per l'evento di abbandono</p>
                <select name="popup_id">
                    <?php 
                    $popups = get_posts(array('post_type' => 'elementor_library', 'posts_per_page' => -1));
                    foreach ($popups as $popup) {
                        $popup_meta = get_post_meta($popup->ID, '_elementor_template_type', true);
                        if ($popup_meta === 'popup') {
                            if ($popup->ID == $popup_id) {
                                echo '<option selected value="' . $popup->ID . '">' . $popup->post_title . '</option>';
                            } else {
                                echo '<option value="' . $popup->ID . '">' . $popup->post_title . '</option>';
                            }
                        }
                    }
                    
                    ?>
                </select>
                <h1 class="text-xl font-bold mb-2 mt-8">Persistenza Tesi</h1>
                <p class="opacity-75 mb-4">Le tesi caricate dagli utenti sono salvate sul disco, per liberare spazio viene temporizzata la cancellazione delle tesi caricate<br> Inserisci un valore (periodo di tempo)</p>
                <p class="opacity-50 mb-4">Questo cancellerà i file in base al periodo di tempo inserito</p>
                <select name="time_schedule" disabled>
                    <option value="hourly" <?php if ($time_schedule === "hourly") {
                        echo "selected";
                    }
                    ?>>Ogni ora</option>
                                        <option value="daily" <?php if ($time_schedule === "daily") {
                        echo "selected";
                    }
                    ?>>Ogni giorno</option>
                                        <option value="weekly" <?php if ($time_schedule === "weekly") {
                        echo "selected";
                    }
                    ?>>Ogni settimana</option>
                                        <option value="monthly" <?php if ($time_schedule === "monthly") {
                        echo "selected";
                    }
                    ?>>Ogni mese</option>
                </select>
                <h1 class="text-xl font-bold mb-2 mt-8">Cancella cartelle Tesi</h1>
                <p class="opacity-75 mb-4">Clicca per cancellare adesso tutte le cartelle</p>
                <div class="storage-utility flex flex-col gap-4 mb-4">
                    <div class="used-storage">
                        <h2>Spazio utilizzato <p class="text-xl"><?php echo readableBytes(recurse_dirsize(THESIS_FILES)) ?></p></h2>
                    </div>
                    <div class="free-storage">
                        <button id="free-storage" class="button button-secondary">LIBERA SPAZIO</button>
                    </div>
                </div>
                <?php submit_button('Salva impostazioni');?>
            </form>
        </div>
    </section>
</div>