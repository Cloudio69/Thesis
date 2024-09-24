<?php

/**
 * Inizializza i file ajax pubblici
 * 
 * @package Thesis
 * @subpackage Includes/Ajax/Public
 * 
 */

require THESIS_DIR . "app/includes/models/pdf/init.php";
require THESIS_DIR . "app/includes/ajax/public/files.php";
require THESIS_DIR . "app/includes/ajax/public/checkout.php";
require THESIS_DIR . "app/includes/ajax/public/rilegature.php";
require THESIS_DIR . "app/includes/ajax/public/pagine.php";

function count_new_customers() {
    global $wpdb;

    // Query per contare i nuovi clienti
    $new_customers_count = $wpdb->get_var("
        SELECT COUNT(*)
        FROM {$wpdb->users} u
        INNER JOIN {$wpdb->usermeta} um ON u.ID = um.user_id
        WHERE um.meta_key = 'wp_capabilities'
        AND um.meta_value LIKE '%customer%'
        AND u.user_registered >= DATE_SUB(NOW(), INTERVAL 1 MONTH)
    ");

    return $new_customers_count;
}

function count_new_orders() {
    global $wpdb;

    // Query per contare i nuovi ordini
    $new_orders_count = $wpdb->get_var("
        SELECT COUNT(*)
        FROM {$wpdb->prefix}wc_orders
        WHERE type = 'shop_order'
        AND status IN ('wc-completed', 'wc-processing', 'wc-on-hold', 'wc-pending')
        AND date_created_gmt >= DATE_SUB(NOW(), INTERVAL 1 MONTH)
    ");

    return $new_orders_count;
}

function calculate_total_profit() {
    global $wpdb;

    // Query per calcolare il profitto totale
    $total_profit = $wpdb->get_var("
        SELECT SUM(total_amount)
        FROM {$wpdb->prefix}wc_orders
        WHERE type = 'shop_order'
        AND status IN ('wc-completed', 'wc-processing', 'wc-on-hold', 'wc-pending')
        AND date_created_gmt >= DATE_SUB(NOW(), INTERVAL 1 MONTH)
    ");

    return $total_profit;
}

function display_total_profit() {
    $total_profit = calculate_total_profit();
    return $total_profit > 0 ? wc_price($total_profit) : 0;
}

add_shortcode('total_profit', 'display_total_profit');

function display_new_customers_count() {
    $new_customers_count = count_new_customers();
    return $new_customers_count;
}

add_shortcode('new_customers_count', 'display_new_customers_count');

function display_new_orders_count() {
    $new_orders_count = count_new_orders();
    return $new_orders_count > 0 ? $new_orders_count : 0;
}

add_shortcode('new_orders_count', 'display_new_orders_count');