<?php wp_head();?>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<?php
wp_enqueue_style('tailwind', THESIS_URL . "/app/assets/css/tailwind.css");
wp_enqueue_style('thesis-frontend', THESIS_URL . "/app/assets/css/frontend/thesis-frontend.css");
?>
<body <?php body_class();?>>
<div class="thesis--wrapper h-full">
    <header class="thesis--header bg-white w-full top-0 flex justify-between items-center z-[99] px-6 py-4 fixed">
        <h1 class="text-xl font-bold m-0">Checkout</h1>
        <?php
if (is_user_logged_in()) {
    $current_user = wp_get_current_user();
    ?>
                <div class="user-info flex items-center gap-2">
                    <span class="material-symbols-outlined text-xl">account_circle</span>
                    <span class="font-bold">Loggato come: <?php echo esc_html($current_user->display_name); ?></span>
                </div>
                <?php
}
?>
        <a href="/" class="flex items-center gap-2 p-2 bg-white"><span class="!text-black font-bold">ANNULLA</span><span class="material-symbols-outlined !text-black text-xl">close</span></a>
    </header>
    <main>
        <?php
        if (!is_user_logged_in()) {
            ?>
            <div class="thesis--register h-full flex items-center justify-center">
                <?php
                echo do_shortcode('[woocommerce_my_account]');
                ?>
            </div>
            <?php
        }
        ?>
    </main>
</div>
</body>


<?php wp_footer();?>

