<?php wp_head(); ?>
<?php
wp_enqueue_style('tailwind-css',  THESIS_URL . "/app/assets/css/tailwind.css");
wp_enqueue_style('thesis-frontend', THESIS_URL . "/app/assets/css/frontend/thesis-frontend.css");
?>

<div id="preloader" class="h-full w-full z-[99] flex justify-center items-center flex-col fixed bg-white top-0 gap-2">
    <img src=<?php echo THESIS_URL . "app/assets/img/svg/loading.svg" ?> class="animate-spin w-10 h-10" />
    <p class="">Caricamento...</p>
</div>
<div class="thesis--wrapper h-full">
    <?php include_once THESIS_DIR . "app/views/frontend/components/header.php"; ?>
    <div class="thesis--body h-full flex justify-stretch">
        <div class="thesis--fragments flex items-center justify-center h-full w-[60%] pt-[4rem] bg-slate-100">
            <?php include_once THESIS_DIR . "app/views/frontend/components/fragments/frontespizio.php"; ?>
            <?php include_once THESIS_DIR . "app/views/frontend/components/fragments/tipologia.php"; ?>
            <?php include_once THESIS_DIR . "app/views/frontend/components/fragments/rilegature.php"; ?>
        </div>
        <?php include_once THESIS_DIR . "app/views/frontend/components/sidebar.php"; ?>
    </div>
</div>

<?php wp_enqueue_script('thesis-configurator', THESIS_URL . 'app/assets/js/frontend/thesis-configurator.js'); ?>
<?php wp_enqueue_script('gsap', 'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js'); ?>

<?php wp_footer(); ?>
