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

// Caricamento dei vendor **COMPOSER**
require_once(THESIS_DIR . 'app/vendor/autoload.php');
require_once(THESIS_DIR . 'app/includes/init.php');

$init = new Thesis();
