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

/* if (is_admin()) {
    define('GH_REQUEST_URI', 'https://api.github.com/repos/%s/%s/releases');
    define('GHPU_USERNAME', 'YOUR_GITHUB_USERNAME');
    define('GHPU_REPOSITORY', 'YOUR_GITHUB_REPOSITORY_NAME');
    define('GHPU_AUTH_TOKEN', 'YOUR_GITHUB_ACCESS_TOKEN');

    include_once plugin_dir_path(__FILE__) . '/update/git-update.php';

    $updater = new GhPluginUpdater(__FILE__);
    $updater->init();
} */


$init = new Thesis();
