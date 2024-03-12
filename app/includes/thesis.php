<?php

class Thesis
{

    public function __construct()
    {
        $this->thesis_hooks();
        $this->thesis_widgets();
        $this->thesis_api_endpoints();
    }

    public function thesis_hooks()
    {
        // Inizializza pagina admin
        add_action('admin_menu', array($this, 'thesis_admin_page'));
        add_action('admin_enqueue_scripts', array($this, 'thesis_scripts'));
    }

    public function thesis_scripts()
    {
        wp_enqueue_style( 'thesis-admin', THESIS_URL . "/app/assets/css/thesis.admin.css" ); 
    }

    public function thesis_widgets()
    {
    }

    public function thesis_api_endpoints()
    {
    }

    public function thesis_admin_page()
    {
        add_menu_page(
            __('Thesis', 'textdomain'),
            'Thesis',
            'manage_options',
            'thesis',
            array($this, 'thesis_render_admin_page'),
            'dashicons-book-alt',
            10
        );
    }
    public function thesis_render_admin_page()
    {
        include_once(THESIS_DIR . 'app/views/admin/admin.php');
    }
}
