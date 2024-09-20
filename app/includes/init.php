<?php

include_once THESIS_DIR . "app/includes/ajax/init.php";

include_once THESIS_DIR . "app/includes/ajax/public/init.php";

class Thesis
{

    public function __construct()
    {
        $this->thesis_check_updates();
        $this->thesis_options();
        $this->thesis_hooks();
        $this->thesis_widgets();
    }

    public function thesis_check_updates()
    {
        // Will be implemented in the future
    }

    public function thesis_hooks()
    {
        /* Admin - Menu e Scripts */
        add_action('init', array($this, 'thesis_schedule_cron'));
        add_action('admin_menu', array($this, 'thesis_admin_page'));
        add_action('admin_enqueue_scripts', array($this, 'thesis_scripts'));
        add_action('wp_enqueue_scripts', array($this, 'thesis_public_scripts'));
        add_filter('page_template', array($this, 'thesis_template_page'));
        add_action('wp_footer', array($this, 'add_thesis_id_button'));
        add_action('thesis_clear_event', array($this, 'thesis_clear_function'));
        add_filter('cron_schedules', array($this, 'thesis_clear_interval'));
    }

    public function thesis_schedule_cron()
    {
        if (!wp_next_scheduled('thesis_clear_event')) {
            wp_schedule_event(time(), get_option('time_schedule') ? get_option('time_schedule') : 'monthly', 'thesis_clear_event');
        }
    }

    public function thesis_clear_interval()
    {
        $schedules['daily'] = array(
            'interval' => 86400,
            'display' => __('Once Daily'),
        );

        $schedules['hourly'] = array(
            'interval' => 3600,
            'display' => __('Once Hourly'),
        );

        $schedules['weekly'] = array(
            'interval' => 604800,
            'display' => __('Once Weekly'),
        );

        $schedules['monthly'] = array(
            'interval' => 2635200,
            'display' => __('Once Monthly'),
        );

        return $schedules;
    }

    public function thesis_clear_function()
    {
        $dir = THESIS_FILES;
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir . "/" . $object) == "dir") {
                        rrmdir($dir . "/" . $object);
                    } else {
                        unlink($dir . "/" . $object);
                    }
                }
            }
            reset($objects);
            rmdir($dir);
        }
        mkdir(THESIS_FILES, 0755, true);
    }

    public function thesis_public_scripts()
    {
        global $pagename;
        if ($pagename !== 'configuratore') {
            wp_enqueue_script('thesis-initialize', THESIS_URL . 'app/assets/js/frontend/thesis-initialize.js', array(), false, true);
            wp_enqueue_style('tailwind-css', THESIS_URL . "/app/assets/css/tailwind.css");
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

        if (strpos($current_screen->base, 'thesis') === false) {
            return;
        }

        wp_enqueue_media();
        wp_enqueue_style('thesis-admin', THESIS_URL . "/app/assets/css/thesis.admin.css");
        wp_enqueue_style('tailwind-css', THESIS_URL . "/app/assets/css/tailwind.css");
        wp_enqueue_script('admin-js', THESIS_URL . "/app/assets/js/thesis.admin.js", array(), null, true);
        wp_enqueue_script('chart-js', 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js');
    }

    public function thesis_widgets()
    {
        /* Widget per Elementor */
    }

    public function add_thesis_id_button()
    {
        ?>
        <script>
            const init = document.querySelectorAll(".<?php echo get_option('class_bottone'); ?>")
            const nonce = "<?php echo wp_create_nonce('thesis-token'); ?>"
            const ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
            const configuratore = "<?php echo get_option('pagina_configuratore') ?>"
            const popupId = <?php echo get_option('popup_id') ? get_option('popup_id') : 68; ?>;
        </script>
<?php
}

    public function thesis_options()
    {
        add_option('pagina_configuratore', 'configuratore');
        add_option('class_bottone', 'configuratore');
        add_option('time_schedule', 'monthly');
        register_setting('thesis_impostazioni', 'pagina_configuratore');
        register_setting('thesis_impostazioni', 'class_bottone');
        register_setting('thesis_impostazioni', 'time_schedule');

        // Prezzi settings
        add_option('prezzo_angoli', '4');
        add_option('prezzo_segnalibri', '2');
        add_option('prezzo_bn', '0.04');
        add_option('prezzo_colori', '0.40');
        add_option('prezzo_a4', '0.00');
        add_option('prezzo_a3', '0.04');
        add_option('prezzo_cd', '10.00');
        register_setting('thesis_prezzi', 'prezzo_a4');
        register_setting('thesis_prezzi', 'prezzo_a3');
        register_setting('thesis_prezzi', 'prezzo_bn');
        register_setting('thesis_prezzi', 'prezzo_colori');
        register_setting('thesis_prezzi', 'prezzo_angoli');
        register_setting('thesis_prezzi', 'prezzo_segnalibri');
        register_setting('thesis_prezzi', 'prezzo_cd');
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
                include_once (THESIS_DIR . 'app/views/admin/rilegature.php');
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
                include_once (THESIS_DIR . 'app/views/admin/orders.php');
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
                include_once (THESIS_DIR . 'app/views/admin/accessori.php');
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
                include_once (THESIS_DIR . 'app/views/admin/impostazioni.php');
            },
            null
        );
    }
    public function thesis_render_admin_page()
    {
        /* Template pagina Admin */
        include_once THESIS_DIR . 'app/views/admin/init.php';
    }
}
