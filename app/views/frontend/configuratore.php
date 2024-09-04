<?php wp_head();?>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<?php

if (isset($_COOKIE['thesis_session'])) {
    $tmp_folder = $_COOKIE['thesis_session'];
    $upload_dir = THESIS_PDFS . "/" . $tmp_folder;
    $file_name = "tesi.pdf";

    if (!file_exists($upload_dir . '/frontespizio.jpg')) {
        $process = new ThesisProcess;
        if (file_exists($upload_dir . "/" . $file_name)) {
            $process->process_frontespizio($file_name, $upload_dir);
        } else {
            $_COOKIE['thesis_session'] = null;
        }
    }
}

?>
<?php
wp_enqueue_style('tailwind-css', THESIS_URL . "/app/assets/css/tailwind.css");
wp_enqueue_style('thesis-frontend', THESIS_URL . "/app/assets/css/frontend/thesis-frontend.css");
wp_enqueue_script('fabric-js', 'https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.1/fabric.min.js');
wp_enqueue_script('gsap', 'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js');
?>

<?php if (!isset($_COOKIE['thesis_session'])) {?>
    <div class="thesis--wrapper w-full h-full flex flex-col justify-center items-center gap-4">
        <div class="alert bg-red-700 text-white ring-1 ring-red-500 rounded-md ring-offset-2 font-bold p-2 px-4">Sessione non valida</div>
        <a href="/" class="underline">Torna indietro</a>
    </div>
<?php } else { ?>
    <div id="preloader" class="h-full w-full z-[99] flex justify-center items-center flex-col fixed bg-white top-0 gap-2">
        <img src=<?php echo THESIS_URL . "app/assets/img/svg/loading.svg" ?> class="animate-spin w-10 h-10" />
        <p class="font-medium">Caricamento...</p>
    </div>
    <div class="thesis--wrapper h-full">
        <?php include_once THESIS_DIR . "app/views/frontend/components/header.php";?>
        <div class="thesis--body h-full lg:flex justify-stretch md:flex-col md:flex">
            <div class="thesis--fragments flex items-center justify-center lg:h-full md:h-[50vh] lg:w-[60%] pt-[4rem] bg-slate-100 overflow-auto">
                <?php include_once THESIS_DIR . "app/views/frontend/components/fragments/frontespizio.php";?>
                <?php include_once THESIS_DIR . "app/views/frontend/components/fragments/tipologia.php";?>
                <?php include_once THESIS_DIR . "app/views/frontend/components/fragments/rilegature.php";?>
                <?php include_once THESIS_DIR . "app/views/frontend/components/fragments/pagine.php";?>
                <?php include_once THESIS_DIR . "app/views/frontend/components/fragments/cd.php";?>
                <?php include_once THESIS_DIR . "app/views/frontend/components/fragments/finalizza.php";?>
                <?php include_once THESIS_DIR . "app/views/frontend/components/fragments/checkout.php";?>
            </div>
            <?php include_once THESIS_DIR . "app/views/frontend/components/sidebar.php";?>
        </div>
    </div>

    <?php 
        wp_enqueue_script('thesis-configurator', THESIS_URL . 'app/assets/js/frontend/thesis-configurator.js', ['jquery'], true);
        wp_enqueue_script('thesis-canvas', THESIS_URL . 'app/assets/js/frontend/thesis-canvas.js', ['fabric-js'], true);
    ?>
<?php
}

?>

<?php wp_footer();?>