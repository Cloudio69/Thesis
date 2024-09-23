<?php

/**
 *
 * Plugin Name: Thesis
 * Plugin URI: https://icones.it/
 * Description: Personalizza la tua tesi!
 * Version: 0.0.1
 * Author: Claudio Caso - Icones
 * Author URI: http://icones.it
 * Text Domain: thesis
 * Domain Path: app/i18n
 *
 */

// Directory path e url del plugin
define('THESIS_DIR', plugin_dir_path(__FILE__));
define('THESIS_URL', plugin_dir_url(__FILE__));
define('THESIS_FILES', THESIS_DIR . "app/files");
define('THESIS_WOO', THESIS_DIR . "app/woocommerce");

// Caricamento dei vendor **COMPOSER**
// require_once(THESIS_DIR . 'app/vendor/autoload.php');

// Inizializza le classi principali
require_once THESIS_DIR . 'app/includes/init.php';
require_once THESIS_DIR . "app/includes/db.php";

// Inizializza hook di attivazione e disinstallazione
// Controlla se WooCommerce è attivo
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    // WooCommerce è attivo, inizializza Thesis
    $init = new Thesis();
} else {
    // WooCommerce non è attivo, mostra un messaggio di avviso
    add_action('admin_notices', function() {
        echo '<div class="notice notice-error">
                <p>' . __('Thesis richiede WooCommerce per la corretta funzione', 'thesis') . '</p>
              </div>';
    });
}
register_activation_hook(__FILE__, array('ThesisDatabase', 'create_tables'));
