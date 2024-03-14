<?php

class Copertina
{
    private $nome_copertina;

    private $anteprima_copertina;

    private $descrizione_copertina;

    private $varianti;

    private $angoli;

    private $segnalibri;

    private $grammature;

    public function get_copertine($id = null)
    {
        global $wpdb;

        if (!$id) {
            $query = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "thesis_copertine");
            return json_encode($query);
        } else {
            $query = $wpdb->get_results(
                $wpdb->prepare("SELECT * FROM {$wpdb->prefix}thesis_copertine WHERE id_copertina = {$id}")
            );
            return json_encode($query);
        }
    }

    public function create_copertina()
    {


    }
}


$copertineDb = new Copertina;