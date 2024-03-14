<?php

require_once ABSPATH . 'wp-admin/includes/upgrade.php';

class ThesisDatabase
{
    public static function create_tables()
    {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();

        $sql = 
        "CREATE TABLE " . $wpdb->prefix . "thesis_copertine (
            id_copertina INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            nome_copertina VARCHAR(50),
            descrizione_copertina TEXT,
            anteprima_copertina TEXT
        ) $charset_collate;

        CREATE TABLE " . $wpdb->prefix . "thesis_variations (
            id_variazione INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            id_copertina INT,
            codice_colore VARCHAR(50),
            nome_variazione VARCHAR(50),
            anteprima_variazione TEXT,
            FOREIGN KEY (id_copertina) REFERENCES ". $wpdb->prefix ."thesis_copertine(id_copertina)
        ) $charset_collate;  

        CREATE TABLE " . $wpdb->prefix . "thesis_variations_chars (
            id_colore_carattere INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            id_variazione INT,
            nome_colore VARCHAR(50),
            hex_colore VARCHAR(9),
            FOREIGN KEY (id_variazione) REFERENCES ". $wpdb->prefix ."thesis_variations(id_variazione)
        ) $charset_collate;

        CREATE TABLE " . $wpdb->prefix . "thesis_bookmarks (
            id_segnalibro INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            id_copertina INT,
            nome_colore VARCHAR(50),
            anteprima_segnalibro TEXT,
            FOREIGN KEY (id_copertina) REFERENCES ". $wpdb->prefix ."thesis_copertine(id_copertina)
        ) $charset_collate;

        CREATE TABLE " . $wpdb->prefix . "thesis_paper_weights (
            id_grammatura INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            id_copertina INT,
            nome_grammatura VARCHAR(50),
            formato_grammatura VARCHAR(3),
            FOREIGN KEY (id_copertina) REFERENCES ". $wpdb->prefix ."thesis_copertine(id_copertina)
        ) $charset_collate;

        CREATE TABLE " . $wpdb->prefix . "thesis_corners (
            id_angolo INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            id_copertina INT,
            nome_angolo VARCHAR(50),
            hex_colore VARCHAR(9),
            FOREIGN KEY (id_copertina) REFERENCES ". $wpdb->prefix ."thesis_copertine(id_copertina)
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
