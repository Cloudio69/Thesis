<?php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

    if(isset($_GET['thesis_session'])){
        setcookie('thesis_session', $_GET['thesis_session'], time() + (86400 * 30), "/");
        header("Location: /configuratore");
    }
?>
<?php wp_head();?>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<?php

if (isset($_COOKIE['thesis_session'])) {
    $tmp_folder = $_COOKIE['thesis_session'];
    $upload_dir = THESIS_FILES . "/" . $tmp_folder;
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
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" /> 
<meta http-equiv="Pragma" content="no-cache"> 
<meta http-equiv="Expires" content="0"> 
<?php
wp_enqueue_style('tailwind', THESIS_URL . "/app/assets/css/tailwind.css");
wp_enqueue_style('thesis-frontend', THESIS_URL . "/app/assets/css/frontend/thesis-frontend.css");

wp_enqueue_script('fabric-js', 'https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.1/fabric.min.js');
wp_enqueue_script('gsap', 'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js');
wp_enqueue_script('cookie-helper', THESIS_URL . 'app/assets/js/frontend/helper/cookie-helper.js', array(), true);
?>
<body <?php body_class(); ?>>
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
    <div class="thesis--wrapper h-full overflow-hidden">
        <?php include_once THESIS_DIR . "app/views/frontend/components/header.php";?>
        <div class="thesis--body h-full lg:flex justify-stretch md:flex-col md:flex overflow-hidden">
            <div class="thesis--fragments flex items-center justify-center lg:h-full md:h-[50vh] lg:w-[60%] bg-slate-100 overflow-auto">
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
        wp_enqueue_script('thesis-pages', THESIS_URL . 'app/assets/js/frontend/thesis-pages.js', array(), true);
        wp_enqueue_script('thesis-frame', THESIS_URL . 'app/assets/js/frontend/thesis-frame.js', array(), true);
        wp_enqueue_script('thesis-typology', THESIS_URL . 'app/assets/js/frontend/thesis-typology.js', array(), true);
        wp_enqueue_script('thesis-cover', THESIS_URL . 'app/assets/js/frontend/thesis-cover.js', array(), true);
        wp_enqueue_script('thesis-cart', THESIS_URL . 'app/assets/js/frontend/thesis-cart.js', array(), true);
        wp_enqueue_script('thesis-canvas', THESIS_URL . 'app/assets/js/frontend/thesis-canvas.js', ['fabric-js'], true);
        wp_enqueue_script('thesis-finalize', THESIS_URL . 'app/assets/js/frontend/thesis-finalize.js', array(), true);
        wp_enqueue_script('thesis-checkout', THESIS_URL . 'app/assets/js/frontend/thesis-checkout.js', array(), true);
        wp_enqueue_script('popup-helper', THESIS_URL . 'app/assets/js/frontend/helper/popup-helper.js', array(), true);
    ?>
<?php
}

?>
</body>


<?php wp_footer(); ?>

