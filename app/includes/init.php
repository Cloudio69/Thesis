<?php

include_once THESIS_DIR . "app/includes/ajax/init.php";

class Thesis
{

    public function __construct()
    {
        $this->thesis_options();
        $this->thesis_hooks();
        $this->thesis_widgets();
    }

    public function thesis_hooks()
    {
        /* Admin - Menu e Scripts */
        add_action('admin_menu', array($this, 'thesis_admin_page'));
        add_action('admin_enqueue_scripts', array($this, 'thesis_scripts'));
        add_action('wp_enqueue_scripts', array($this, 'thesis_public_scripts'));
        add_filter('page_template', array($this, 'thesis_template_page'));
        add_action('wp_footer', array($this, 'add_thesis_id_button'));
    }

    public function thesis_public_scripts()
    {
        global $pagename;
        if ($pagename !== 'configuratore') { 
            wp_enqueue_script('thesis-initialize', THESIS_URL . 'app/assets/js/frontend/thesis-initialize.js', array(), false, true);
            wp_enqueue_style('tailwind-css',  THESIS_URL . "/app/assets/css/tailwind.css");
        }
    }

    public function thesis_template_page()
    {
        if (is_page(get_option('pagina_configuratore'))) {
            $page_template = THESIS_DIR . 'app/views/frontend/configuratore.php';
        } else {
            $page_template = '';
        }

        return $page_template;
    }

    public function thesis_scripts()
    {
        /* Stili e Scripts */
        $current_screen = get_current_screen();

        if (strpos($current_screen->base, 'thesis') === false) return;

        wp_enqueue_media();
        wp_enqueue_style('thesis-admin', THESIS_URL . "/app/assets/css/thesis.admin.css");
        wp_enqueue_style('tailwind-css',  THESIS_URL . "/app/assets/css/tailwind.css");
        wp_enqueue_script('admin-js', THESIS_URL . "/app/assets/js/thesis.admin.js", array(), null, true);
        wp_enqueue_script('chart-js', 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js');
    }

    public function thesis_widgets()
    {
        /* Widget per Elementor */
    }

    function add_thesis_id_button()
    {
    ?>
        <script>
            const init = document.querySelector("#<?php echo get_option('id_bottone'); ?>")
            const nonce = "<?php echo wp_create_nonce( 'thesis-token' ); ?>"
        </script>
    <?php
    }

    public function thesis_options()
    {
        add_option(
            'pagina_configuratore',
            'configuratore'
        );
        add_option(
            'id_bottone',
            'configuratore'
        );
        register_setting(
            'thesis_impostazioni',
            'pagina_configuratore'
        );
        register_setting(
            'thesis_impostazioni',
            'id_bottone'
        );
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
            'Rilegature',
            'Rilegature',
            'manage_options',
            'thesis-rilegature',
            function () {
                include_once(THESIS_DIR . 'app/views/admin/rilegature.php');
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
            'Accessori',
            'Accessori',
            'manage_options',
            'thesis-accessori',
            function () {
                include_once(THESIS_DIR . 'app/views/admin/accessori.php');
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
                include_once(THESIS_DIR . 'app/views/admin/impostazioni.php');
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
