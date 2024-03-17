<?php

include_once THESIS_DIR . "app/includes/ajax/init.php";

class Thesis
{

    public function __construct()
    {
        $this->thesis_hooks();
        $this->thesis_widgets();
    }

    public function thesis_hooks()
    {
        /* Admin - Menu e Scripts */
        add_action('admin_menu', array($this, 'thesis_admin_page'));
        add_action('admin_enqueue_scripts', array($this, 'thesis_scripts'));
    }

    public function thesis_scripts()
    {
        /* Stili e Scripts */
        $current_screen = get_current_screen();

        if (strpos($current_screen->base, 'thesis') === false) return;

        wp_enqueue_media();
        wp_enqueue_style('thesis-admin', THESIS_URL . "/app/assets/css/thesis.admin.css");
        wp_enqueue_style('tailwind-css',  THESIS_URL . "/app/assets/css/tailwind.css");
        wp_enqueue_script('chart-js', 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js');
    }

    public function thesis_widgets()
    {
        /* Widget per Elementor */
    }

    public function thesis_admin_page()
    {
        /* Pagina Admin e Sottopagine */
        add_menu_page(
            __('Thesis', 'textdomain'),
            'Thesis',
            'manage_options',
            'thesis',
            array($this, 'thesis_render_admin_page'),
            'dashicons-book-alt',
            10
        );

        add_submenu_page(
            'thesis',
            'Copertine',
            'Copertine',
            'manage_options',
            'thesis-copertine',
            function () {
                include_once(THESIS_DIR . 'app/views/admin/copertine.php');
            },
            null
        );

        add_submenu_page(
            'thesis',
            'Ordini',
            'Ordini',
            'manage_options',
            'thesis-ordini',
            function () {
                include_once(THESIS_DIR . 'app/views/admin/orders.php');
            },
            null
        );

        add_submenu_page(
            'thesis',
            'Prodotti',
            'Prodotti',
            'manage_options',
            'thesis-prodotti',
            function () {
                include_once(THESIS_DIR . 'app/views/admin/products.php');
            },
            null
        );

        add_submenu_page(
            'thesis',
            'Impostazioni',
            'Impostazioni',
            'manage_options',
            'thesis-impostazioni',
            function () {
                include_once(THESIS_DIR . 'app/views/admin/settings.php');
            },
            null
        );
    }
    public function thesis_render_admin_page()
    {
        /* Template pagina Admin */
        include_once(THESIS_DIR . 'app/views/admin/init.php');
    }
}
