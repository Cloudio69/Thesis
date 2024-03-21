<?php

require_once ABSPATH . 'wp-admin/includes/upgrade.php';

class ThesisDatabase
{
    public static function create_tables()
    {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();


        $sql =
            "CREATE TABLE " . $wpdb->prefix . "thesis_rilegature (
            id_rilegatura INT NOT NULL AUTO_INCREMENT,
            nome_rilegatura VARCHAR(50),
            descrizione_rilegatura TEXT,
            anteprima_rilegatura TEXT,
            angoli INT DEFAULT 1,
            PRIMARY KEY (id_rilegatura)
        ) $charset_collate;

        CREATE TABLE " . $wpdb->prefix . "thesis_variations (
            id_variazione INT NOT NULL AUTO_INCREMENT,
            id_rilegatura INT,
            codice_colore VARCHAR(50),
            nome_variazione VARCHAR(50),
            anteprima_variazione TEXT,
            PRIMARY KEY (id_variazione),
            FOREIGN KEY (id_rilegatura) REFERENCES " . $wpdb->prefix . "thesis_rilegature(id_rilegatura) ON DELETE CASCADE ON UPDATE CASCADE
        ) $charset_collate; 

        CREATE TABLE " . $wpdb->prefix . "thesis_colori_carattere (
            id_colore_carattere INT NOT NULL AUTO_INCREMENT,
            nome_colore VARCHAR(50),
            hex_colore VARCHAR(9),
            PRIMARY KEY (id_colore_carattere)
        ) $charset_collate;

        CREATE TABLE " . $wpdb->prefix . "thesis_color_assoc (
            id_associazione INT NOT NULL AUTO_INCREMENT,
            id_rilegatura INT,
            id_colore_carattere INT,
            PRIMARY KEY (id_associazione),
            FOREIGN KEY (id_rilegatura) REFERENCES " . $wpdb->prefix . "thesis_rilegature(id_rilegatura) ON DELETE CASCADE ON UPDATE CASCADE,
            FOREIGN KEY (id_colore_carattere) REFERENCES " . $wpdb->prefix . "thesis_colori_carattere(id_colore_carattere) ON DELETE CASCADE ON UPDATE CASCADE
        ) $charset_collate;

        CREATE TABLE " . $wpdb->prefix . "thesis_bookmarks (
            id_segnalibro INT NOT NULL AUTO_INCREMENT,
            id_rilegatura INT,
            nome_colore VARCHAR(50),
            anteprima_segnalibro TEXT,
            PRIMARY KEY (id_segnalibro)
        ) $charset_collate;

        CREATE TABLE " . $wpdb->prefix . "thesis_paper_weights (
            id_grammatura INT NOT NULL AUTO_INCREMENT,
            id_rilegatura INT,
            nome_grammatura VARCHAR(50),
            formato_grammatura VARCHAR(3),
            PRIMARY KEY (id_grammatura)
        ) $charset_collate;

        CREATE TABLE " . $wpdb->prefix . "thesis_corners (
            id_angolo INT NOT NULL AUTO_INCREMENT,
            id_rilegatura INT,
            nome_angolo VARCHAR(50),
            hex_colore VARCHAR(9),
            PRIMARY KEY (id_angolo)
        ) $charset_collate;
        
        ";

        dbDelta($sql);
    }

    public static function delete_tables()
    {
        global $wpdb;

        $table_name = $wpdb->prefix . 'custom_table';
        $wpdb->query("DROP TABLE IF EXISTS $table_name");
    }
}
