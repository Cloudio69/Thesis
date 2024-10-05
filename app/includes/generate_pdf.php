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
            " . file_get_contents(THESIS_DIR . 'app/assets/css/tailwind.css') . "
            </style>
        </head>
        <body>
        <table class='w-full'>
            <tr>
                <td class='font-bold text-xl'>Riepilogo Ordine</td>
                <td class='font-bold opacity-50 text-sm text-right'>Ordine ID #" . $this->order->get_id() . "</td>
            </tr>
        </table>
        ";

        $html .= $this->generate_order_summary();

        $html .= $this->generate_wc_data_order();

        $html .= $this->generate_user_data();


        $this->pdf->loadHtml($html);

        $this->pdf->setPaper('A4', 'portrait');

        $this->pdf->render();

        $output = $this->pdf->output();

        file_put_contents(THESIS_DIR . 'app/files/' . $this->session . '/riepilogo_' . $this->order->get_id() . '.pdf', $output);
    }

    private function generate_wc_data_order()
    {
        $content = "
        <table class='w-full mt-6 border'>
            <tr>
                <td colspan=2 class='font-bold border bg-slate-200 text-sm p-2'>Dettagli ordine</td>
            </tr>
            <tr>
                <td class='font-bold border text-xs p-2'>Data</td>
                <td class='font-bold border text-xs text-right p-2'>" . $this->order->get_date_created()->date('d-m-Y H:i:s') . "</td>
            </tr>
            <tr>
                <td class='font-bold border text-xs p-2'>Totale</td>
                <td class='font-bold border text-xs text-right p-2'>" . wc_price($this->order->get_total()) . "</td>
            </tr>
            <tr>
                <td class='font-bold border text-xs p-2'>Stato</td>
                <td class='font-bold border text-xs text-right p-2'>" . ucfirst($this->order->get_status()) . "</td>
            </tr>
            <tr>
                <td class='font-bold border text-xs p-2'>Metodo di pagamento</td>
                <td class='font-bold border text-xs text-right p-2'>" . ($this->order->get_payment_method_title() ? $this->order->get_payment_method_title() : "Guarda ordine woocommerce") . "</td>
            </tr>
            <tr>
                <td class='font-bold border text-xs p-2'>Metodo di spedizione</td>
                <td class='font-bold border text-xs text-right p-2'>" . ($this->order->get_shipping_method() ? $this->order->get_shipping_method() : "Guarda ordine woocommerce") . "</td>
            </tr>
        </table>
        ";

        // TODO aggiungere dinamicamente i metodi di spedizione nel form di checkout

        return $content;
    }

    private function generate_order_summary()
    {

        $content = "<hr class='my-6'><h3 class='font-black'>Rilegature</h3>";

        foreach ($this->cart_items['rilegature'] as $rilegatura) {
            $rilegatura_db = new Rilegatura;
            $rilegatura_db = $rilegatura_db->get_rilegature($rilegatura['id_rilegatura']);
            $rilegatura_db = json_decode($rilegatura_db);

            $variante_db = new Variante;
            $variante_db = $variante_db->get_variante($rilegatura['id_variante']);
            $variante_db = json_decode($variante_db);

            $colore_db = new CharColors;
            $colore_db = $colore_db->get_char_colors($rilegatura['id_colore']);
            $colore_db = json_decode($colore_db);

            $nome_rilegatura = $rilegatura_db[0]->nome_rilegatura;
            $prezzo_rilegatura = $rilegatura_db[0]->prezzo_rilegatura;
            $nome_variante = $variante_db[0]->nome_variante;
            $colore_carattere = $colore_db[0]->nome_colore;
            $angoli = isset($rilegatura['id_angolo']) ? $rilegatura['id_angolo'] : 0;
            $segnalibri = isset($rilegatura['id_segnalibro']) ? $rilegatura['id_segnalibro'] : 0;

            if ($segnalibri != 0) {
                $segnalibri_db = new Segnalibro;
                $segnalibri_db = $segnalibri_db->get_segnalibri($segnalibri);
                $segnalibri_db = json_decode($segnalibri_db);

                $segnalibri = $segnalibri_db[0]->nome_colore;
            }

            if ($angoli != 0) {
                $angoli_db = new Angolo;
                $angoli_db = $angoli_db->get_angoli($angoli);
                $angoli_db = json_decode($angoli_db);

                $angoli = $angoli_db[0]->nome_angolo;
            }

            //  $immagine = isset($rilegatura['rilegatura_thumbnail']) ? $rilegatura['rilegatura_thumbnail'] : '';
            $quantity = $rilegatura['qty'];

            $totale = $prezzo_rilegatura;

            $content .= "
            <div class='rilegatura rounded-md border border-neutral-100 p-4 my-4'>
                <h1 class='font-bold text-base m-0'><span class=''>" . $quantity . " x</span> " . $nome_rilegatura . "</h1>
                <ul class='rilegatura__details'>
                    <li class='rilegatura__detail'>Variante: " . $nome_variante . "</li>
                    <li class='rilegatura__detail'>Colore carattere: " . $colore_carattere . "</li>
                    <li class='rilegatura__angoli'>Angoli: " . ($angoli != 0 ? $angoli : "Nessun angolo") . "</li>
                    <li class='rilegatura__segnalibri'>Segnalibro: " . ($segnalibri != 0 ? $segnalibri : "Nessun segnalibro") . "</li>
                </ul>
            </div>
            ";
        }

        $content .= "<hr class='my-6'><h3 class='font-black'>Pagine</h3>";

        $pagine = $this->cart_items['pagine'];

        $formato_id = $pagine['id_formato'];

        if ($formato_id == "formato-a4") {
            $formato = "A4";
        } else {
            $formato = "A3";
        }


        /* if ($formato[$formato_id] == 'formato-a4') {
            $nome_formato = 'A4';
        } else {
            $nome_formato = 'A3';
        } */


        $grammatura = $pagine['id_grammatura'];
        $grammatura_db = new Grammatura;
        $grammatura_db = $grammatura_db->get_grammature($grammatura);
        $grammatura_db = json_decode($grammatura_db);

        $grammatura = $grammatura_db[0]->nome_grammatura;

        $bn_pages = isset($pagine['bn']) ? $pagine['bn'] : array();
        $colorate_pages = isset($pagine['colorate']) ? $pagine['colorate'] : array();

        $bn_pages = array_map(function ($page) {
            return $page + 1;
        }, $bn_pages);

        $colorate_pages = array_map(function ($page) {
            return $page + 1;
        }, $colorate_pages);

        $total_bn_pages = count($bn_pages);
        $total_colorate_pages = count($colorate_pages);

        $content .= "
        <div class='pagine rounded-md border border-neutral-100 p-4 my-4'>
            <h1 class='font-bold text-base m-0'>Totale pagine: " . ($total_bn_pages + $total_colorate_pages) . "</h1>
            <ul class='pagine__details my-2'>
                <li class='pagine__detail'>Pagine monocolore: " . $total_bn_pages . "</li>
                <li class='pagine__detail'>Pagine multicolore: " . $total_colorate_pages . "</li>
                <li class='pagine__detail'>Formato: " . $formato . " (+" . ($formato != "A4" ? get_option("prezzo_a3") : get_option("prezzo_a4")) . ") </li>
                <li class='pagine__detail'>Grammatura: " . $grammatura . " (+" . ($grammatura_db[0]->prezzo_grammatura > 0 ? $grammatura_db[0]->prezzo_grammatura : "0.00") . ") </li>
            </ul>
        </div>
        <div style='page-break-before: always;'></div>
        <div class='pagine rounded-md border border-neutral-100 p-4'>
        <h1 class='font-bold text-base mb-4'>Indici delle pagine per tipo</h1>
            <table class='pagine__indici w-full border'>
                <tr>
                    <td class='border p-2'>Pagine monocolore</td>
                    <td class='border p-2'>" . implode(', ', $bn_pages) . "</td>
                </tr>
                <tr>
                    <td class='border p-2'>Pagine multicolore</td>
                    <td class='border p-2'>" . implode(', ', $colorate_pages) . "</td>
                </tr>
                <tr>
                    <td class='border p-2 font-bold'>Tipo di stampa</td>
                    <td class='border p-2 font-bold'>" . $this->cart_items['tipologia'] . "</td>
                </tr>
            </table>
        </div>
        ";

        return $content;
    }

    private function generate_user_data()
    {
        $content = "
        <table class='w-full border'>
            <tr>
                <td colspan=2 class='font-bold border bg-slate-200 text-sm p-2'>Dettagli cliente</td>
            </tr>
            <tr>
                <td class='font-bold border text-xs p-2'>Nome</td>
                <td class='font-bold border text-xs text-right p-2'>" . $this->order->get_billing_first_name() . "</td>
            </tr>
            <tr>
                <td class='font-bold border text-xs p-2'>Cognome</td>
                <td class='font-bold border text-xs text-right p-2'>" . $this->order->get_billing_last_name() . "</td>
            </tr>
            <tr>
                <td class='font-bold border text-xs p-2'>Email</td>
                <td class='font-bold border text-xs text-right p-2'>" . $this->order->get_billing_email() . "</td>
            </tr>
            <tr>
                <td class='font-bold border text-xs p-2'>Telefono</td>
                <td class='font-bold border text-xs text-right p-2'>" . $this->order->get_billing_phone() . "</td>
            </tr>
            <tr>
                <td class='font-bold border text-xs p-2'>Indirizzo</td>
                <td class='font-bold border text-xs text-right p-2'>" . $this->order->get_billing_address_1() . "</td>
            </tr>
            <tr>
                <td class='font-bold border text-xs p-2'>Citt&agrave;</td>
                <td class='font-bold border text-xs text-right p-2'>" . $this->order->get_billing_city() . "</td>
            </tr>
            <tr>
                <td class='font-bold border text-xs p-2'>CAP</td>
                <td class='font-bold border text-xs text-right p-2'>" . $this->order->get_billing_postcode() . "</td>
            </tr>
            <tr>
                <td class='font-bold border text-xs p-2'>Provincia</td>
                <td class='font-bold border text-xs text-right p-2'>" . $this->order->get_billing_state() . "</td>
            </tr>
        </table>
        ";

        return $content;
    }
}
