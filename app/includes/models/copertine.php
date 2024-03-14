<?php

class Copertina
{
    private $nome_copertina = "";

    private $anteprima_copertina = "";

    private $descrizione_copertina = "";

    private $varianti;

    private $angoli;

    private $segnalibri;

    private $grammature;

    public function __construct($nome_copertina = "", $anteprima_copertina = "", $descrizione_copertina = "")
    {
        $this->nome_copertina = $nome_copertina;
        $this->anteprima_copertina = $anteprima_copertina;
        $this->descrizione_copertina = $descrizione_copertina;
    }

    public function get_copertine($id = null)
    {
        global $wpdb;
        if (!$id) {
            $results = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "thesis_copertine");
            return json_encode($results);
        } else {
            $results = $wpdb->get_results(
                $wpdb->prepare("SELECT * FROM {$wpdb->prefix}thesis_copertine WHERE id_copertina = {$id}")
            );
            return json_encode($results);
        }
    }
}
