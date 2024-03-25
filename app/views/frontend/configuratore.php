<?php wp_head(); ?>
<?php 
    wp_enqueue_style('tailwind-css',  THESIS_URL . "/app/assets/css/tailwind.css"); 
    wp_enqueue_style('thesis-frontend', THESIS_URL . "/app/assets/css/frontend/thesis-frontend.css");
?>


<div class="thesis--wrapper h-full">
    <?php include_once THESIS_DIR . "app/views/frontend/components/header.php"; ?>
    <div class="thesis--body h-full flex justify-stretch">
        <?php include_once THESIS_DIR . "app/views/frontend/components/fragments/frontespizio.php"; ?>
        <?php include_once THESIS_DIR . "app/views/frontend/components/sidebar.php"; ?>
    </div>
</div>

<?php wp_enqueue_script('thesis-configurator', THESIS_URL . 'app/assets/js/frontend/thesis-configurator.js'); ?>

<?php wp_footer(); ?>