<?php

require_once THESIS_DIR . 'app/vendor/vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

class ThesisSummary
{

    private $pdf;
    private $session;
    private $order;
    private $cart_items;

    public function __construct($cart_items, $order)
    {

        $options = new Options();
        $options->set('defaultFont', 'Helvetica');

        $this->pdf = new Dompdf($options);
        $this->order = $order;
        $this->cart_items = $cart_items;
        $this->session = $_COOKIE['thesis_session'];

        $this->generate_summary();
    }

    private function generate_summary()
    {
        $html = "
        <head>
            <style>
            ". file_get_contents(THESIS_DIR . 'app/assets/css/tailwind.css') ."
            </style>
        </head>
        <body>
        <table class='w-full'>
            <tr>
                <td class='font-bold text-xl'>Riepilogo Ordine</td>
                <td class='font-bold opacity-50 text-sm text-right'>Ordine ID #". $this->order->get_id() ."</td>
            </tr>
        </table>
        ";

        $html .= $this->generate_user_data();

        $this->pdf->loadHtml($html);

        $this->pdf->setPaper('A4', 'portrait');

        $this->pdf->render();

        $output = $this->pdf->output();

        file_put_contents(THESIS_DIR . 'app/files/' . $this->session . '/riepilogo_' . $this->order->get_id() .'.pdf', $output);
    }

    private function generate_user_data()
    {
        $content = "
        <table class='w-full mt-6 border'>
            <tr>
                <td colspan=2 class='font-bold border bg-slate-200 text-sm p-2'>Dettagli cliente</td>
            </tr>
            <tr>
                <td class='font-bold border text-xs p-2'>Nome</td>
                <td class='font-bold border text-xs text-right p-2'>". $this->order->get_billing_first_name() ."</td>
            </tr>
            <tr>
                <td class='font-bold border text-xs p-2'>Cognome</td>
                <td class='font-bold border text-xs text-right p-2'>". $this->order->get_billing_last_name() ."</td>
            </tr>
            <tr>
                <td class='font-bold border text-xs p-2'>Email</td>
                <td class='font-bold border text-xs text-right p-2'>". $this->order->get_billing_email() ."</td>
            </tr>
            <tr>
                <td class='font-bold border text-xs p-2'>Telefono</td>
                <td class='font-bold border text-xs text-right p-2'>". $this->order->get_billing_phone() ."</td>
            </tr>
            <tr>
                <td class='font-bold border text-xs p-2'>Indirizzo</td>
                <td class='font-bold border text-xs text-right p-2'>". $this->order->get_billing_address_1() ."</td>
            </tr>
            <tr>
                <td class='font-bold border text-xs p-2'>Citt&agrave;</td>
                <td class='font-bold border text-xs text-right p-2'>". $this->order->get_billing_city() ."</td>
            </tr>
            <tr>
                <td class='font-bold border text-xs p-2'>CAP</td>
                <td class='font-bold border text-xs text-right p-2'>". $this->order->get_billing_postcode() ."</td>
            </tr>
            <tr>
                <td class='font-bold border text-xs p-2'>Provincia</td>
                <td class='font-bold border text-xs text-right p-2'>". $this->order->get_billing_state() ."</td>
            </tr>
        ";

        return $content;
    }
}
