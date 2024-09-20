<?php

/**
 * 
 * Plugin Name: Thesis
 * Plugin URI: https://icones.it/
 * Description: Personalizza la tua tesi!
 * Version: 1.0.0
 * Author: Claudio Caso - Icones
 * Author URI: http://icones.it
 * Text Domain: thesis
 * Domain Path: /i18n
 * 
 */

// Directory path e url del plugin
define('THESIS_DIR', plugin_dir_path(__FILE__));
define('THESIS_URL', plugin_dir_url(__FILE__));
define('THESIS_FILES', THESIS_DIR . "app/files");

// Caricamento dei vendor **COMPOSER**
// require_once(THESIS_DIR . 'app/vendor/autoload.php');

// Inizializza le classi principali
require_once(THESIS_DIR . 'app/includes/init.php');
require_once(THESIS_DIR . "app/includes/db.php");

// Inizializza hook di attivazione e disinstallazione
register_activation_hook(__FILE__, array('ThesisDatabase', 'create_tables'));
// Dimesso: register_uninstall_hook(__FILE__, array('ThesisDatabase', 'delete_tables'));

if (is_admin()) {
    define('GH_REQUEST_URI', 'https://api.github.com/repos/%s/%s/releases');
    define('GHPU_USERNAME', 'Cloudio69');
    define('GHPU_REPOSITORY', 'Thesis');
    define('GHPU_AUTH_TOKEN', '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');

    include_once plugin_dir_path(__FILE__) . '/update/git-update.php';

    $updater = new GhPluginUpdater(__FILE__);
    $updater->init();
}


$init = new Thesis();
