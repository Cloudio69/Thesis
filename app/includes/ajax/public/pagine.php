<?php

add_action('wp_ajax_genera_pagine', 'ajax_genera_pagine');
add_action('wp_ajax_nopriv_genera_pagine', 'ajax_genera_pagine');

function ajax_genera_pagine()
{

    $data = $_POST['data'];

    $numPagina = $data['num_pagina'];
    $tmp_folder = $data['uuid'];
    $upload_dir = THESIS_FILES . "/" . $tmp_folder;

    if (!is_dir($upload_dir . "/pagine")) {
        mkdir($upload_dir . "/pagine", 0755, true);
    }

    $process = new ThesisProcess;

    $process->genera_pagine($upload_dir . "/tesi.pdf", $upload_dir . "/pagine", $numPagina);

    wp_send_json_success(json_encode(array("message" => "Pagina generata.", "pagina" => $numPagina)), 200);
}

add_action('wp_ajax_get_num_pagine', 'ajax_get_num_pagine');
add_action('wp_ajax_nopriv_get_num_pagine', 'ajax_get_num_pagine');

function ajax_get_num_pagine()
{
    $uuid = $_GET['uuid'];
    $upload_dir = str_replace('\\', '/', THESIS_FILES . "/" . $uuid);

    $process = new ThesisProcess;

    $query = $process->get_num_pagine($upload_dir . "/tesi.pdf");

    wp_send_json_success(json_encode(array("results" => $query)));
}
