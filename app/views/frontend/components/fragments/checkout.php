<div class="thesis--checkout checkout flex flex-col w-full h-full p-4">
    <form method="POST" class="w-full px-4 flex flex-col gap-4 justify-center m-0 overflow-auto" id="checkout_form">
        <div class="dati--personali flex flex-col gap-4 border bg-white shadow-sm rounded-md p-4">
            <h1 class="text-2xl font-bold">Dati personali</h1>
            <div class="mb-4 flex">
                <div class="w-1/2 pr-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="nome"><span>Nome</span><span id="nome_error" class="hidden text-red-500 text-xs">Campo non valido</span></label>
                    <input class="appearance-none !rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none !border-neutral-200" id="nome" type="text" name="nome" required autocomplete="given-name" placeholder="Alberto">
                </div>
                <div class="w-1/2 pl-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="cognome"><span>Cognome</span><span id="cognome_error" class="hidden text-red-500 text-xs">Campo non valido</span></label>
                    <input class="appearance-none !rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none !border-neutral-200" id="cognome" type="text" name="cognome" required autocomplete="family-name" placeholder="Patella">
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email"><span>Email</span><span id="email_error" class="hidden text-red-500 text-xs">Campo non valido</span></label>
                <input class="appearance-none !rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none !border-neutral-200" id="email" type="email" name="email" required autocomplete="email" placeholder="patella@gmail.com">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="telefono"><span>Telefono</span><span id="telefono_error" class="hidden text-red-500 text-xs">Campo non valido</span></label>
                <input class="appearance-none !rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none !border-neutral-200" id="telefono" type="tel" name="telefono" required autocomplete="tel" placeholder="(+39) 331 ...">
            </div>
        </div>
        <div class="dati--spedizione flex flex-col gap-4 border bg-white shadow-sm rounded-md p-4">
            <h1 class="text-2xl font-bold">Dati per la spedizione</h1>
            <div class="mb-4 flex flex-grow gap-4">
                <div class="">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="provincia"><span>Provincia</span><span id="provincia_error" class="hidden text-red-500 text-xs">Campo non valido</span></label>
                    <select class="appearance-none rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none !border-neutral-200" id="provincia" name="provincia" required autocomplete="address-level1">
                        <option value="" selected disabled>Seleziona...</option>
                        <option value="AG">Agrigento</option>
                        <option value="AL">Alessandria</option>
                        <option value="AN">Ancona</option>
                        <option value="AO">Aosta</option>
                        <option value="AR">Arezzo</option>
                        <option value="AP">Ascoli Piceno</option>
                        <option value="AT">Asti</option>
                        <option value="AV">Avellino</option>
                        <option value="BA">Bari</option>
                        <option value="BT">Barletta-Andria-Trani</option>
                        <option value="BL">Belluno</option>
                        <option value="BN">Benevento</option>
                        <option value="BG">Bergamo</option>
                        <option value="BI">Biella</option>
                        <option value="BO">Bologna</option>
                        <option value="BZ">Bolzano</option>
                        <option value="BS">Brescia</option>
                        <option value="BR">Brindisi</option>
                        <option value="CA">Cagliari</option>
                        <option value="CL">Caltanissetta</option>
                        <option value="CB">Campobasso</option>
                        <option value="CI">Carbonia-Iglesias</option>
                        <option value="CE">Caserta</option>
                        <option value="CT">Catania</option>
                        <option value="CZ">Catanzaro</option>
                        <option value="CH">Chieti</option>
                        <option value="CO">Como</option>
                        <option value="CS">Cosenza</option>
                        <option value="CR">Cremona</option>
                        <option value="KR">Crotone</option>
                        <option value="CN">Cuneo</option>
                        <option value="EN">Enna</option>
                        <option value="FM">Fermo</option>
                        <option value="FE">Ferrara</option>
                        <option value="FI">Firenze</option>
                        <option value="FG">Foggia</option>
                        <option value="FC">Forlì-Cesena</option>
                        <option value="FR">Frosinone</option>
                        <option value="GE">Genova</option>
                        <option value="GO">Gorizia</option>
                        <option value="GR">Grosseto</option>
                        <option value="IM">Imperia</option>
                        <option value="IS">Isernia</option>
                        <option value="SP">La Spezia</option>
                        <option value="AQ">L'Aquila</option>
                        <option value="LT">Latina</option>
                        <option value="LE">Lecce</option>
                        <option value="LC">Lecco</option>
                        <option value="LI">Livorno</option>
                        <option value="LO">Lodi</option>
                        <option value="LU">Lucca</option>
                        <option value="MC">Macerata</option>
                        <option value="MN">Mantova</option>
                        <option value="MS">Massa-Carrara</option>
                        <option value="MT">Matera</option>
                        <option value="VS">Medio Campidano</option>
                        <option value="ME">Messina</option>
                        <option value="MI">Milano</option>
                        <option value="MO">Modena</option>
                        <option value="MB">Monza e Brianza</option>
                        <option value="NA">Napoli</option>
                        <option value="NO">Novara</option>
                        <option value="NU">Nuoro</option>
                        <option value="OR">Oristano</option>
                        <option value="PD">Padova</option>
                        <option value="PA">Palermo</option>
                        <option value="PR">Parma</option>
                        <option value="PV">Pavia</option>
                        <option value="PG">Perugia</option>
                        <option value="PU">Pesaro e Urbino</option>
                        <option value="PE">Pescara</option>
                        <option value="PC">Piacenza</option>
                        <option value="PI">Pisa</option>
                        <option value="PT">Pistoia</option>
                        <option value="PN">Pordenone</option>
                        <option value="PZ">Potenza</option>
                        <option value="PO">Prato</option>
                        <option value="RG">Ragusa</option>
                        <option value="RA">Ravenna</option>
                        <option value="RC">Reggio Calabria</option>
                        <option value="RE">Reggio Emilia</option>
                        <option value="RI">Rieti</option>
                        <option value="RN">Rimini</option>
                        <option value="RM">Roma</option>
                        <option value="RO">Rovigo</option>
                        <option value="SA">Salerno</option>
                        <option value="SS">Sassari</option>
                        <option value="SV">Savona</option>
                        <option value="SI">Siena</option>
                        <option value="SR">Siracusa</option>
                        <option value="SO">Sondrio</option>
                        <option value="TA">Taranto</option>
                        <option value="TE">Teramo</option>
                        <option value="TR">Terni</option>
                        <option value="TO">Torino</option>
                        <option value="TP">Trapani</option>
                        <option value="TN">Trento</option>
                        <option value="TV">Treviso</option>
                        <option value="TS">Trieste</option>
                        <option value="UD">Udine</option>
                        <option value="VA">Varese</option>
                        <option value="VE">Venezia</option>
                        <option value="VB">Verbano-Cusio-Ossola</option>
                        <option value="VC">Vercelli</option>
                        <option value="VR">Verona</option>
                        <option value="VV">Vibo Valentia</option>
                        <option value="VI">Vicenza</option>
                        <option value="VT">Viterbo</option>
                    </select>
                </div>
                <div class="flex-1">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="indirizzo"><span>Indirizzo</span><span id="indirizzo_error" class="hidden text-red-500 text-xs">Campo non valido</span></label>
                    <input class="appearance-none !rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none !border-neutral-200" id="indirizzo" type="text" name="indirizzo" required autocomplete="street-address" placeholder="Via Delle Nazioni 4">
                </div>
                <div class="flex-1">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="citta"><span>Città</span><span id="citta_error" class="hidden text-red-500 text-xs">Campo non valido</span></label>
                    <input class="appearance-none !rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none !border-neutral-200" id="citta" type="text" name="citta" required autocomplete="address-level2" placeholder="Roma">
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="codice_postale"><span>Codice Postale</span><span id="codice_postale_error" class="hidden text-red-500 text-xs">Campo non valido</span></label>
                <input class="appearance-none !rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none !border-neutral-200" id="codice_postale" type="text" name="codice_postale" required autocomplete="postal-code" placeholder="00042">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="spedizione">Spedizione</label>
                <select class="appearance-none rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none !border-neutral-200" id="spedizione" name="spedizione" required autocomplete="shipping">
                    <?php
                    $data_store = WC_Data_Store::load('shipping-zone');
                    $raw_zones = $data_store->get_zones();
                    foreach ($raw_zones as $raw_zone) {
                        $zones[] = new WC_Shipping_Zone($raw_zone);
                    }
                    $zones[] = new WC_Shipping_Zone(0);

                    if (!empty($zones)) {
                        foreach ($zones as $zone) {
                            $shipping_methods = $zone->get_shipping_methods();
                            foreach ($shipping_methods as $shipping_method) {
                                $instance = $shipping_method->instance_settings;
                                if ($shipping_method->is_enabled()) {
                                    if (isset($instance) && isset($instance['cost'])) {
                                        $cost = $instance['cost'];
                                        echo '<option value="' . esc_html($shipping_method->get_instance_id()) . '">' . esc_html($shipping_method->get_title()) . ' (' . wc_price($shipping_method->cost) . ')</option>';
                                    } else {
                                        echo '<option value="' . esc_html($shipping_method->get_instance_id()) . '">' . esc_html($shipping_method->get_title()) . ' (' . wc_price(0.00) . ')</option>';
                                    }
                                }
                            }
                        }
                    } else {
                    ?>
                        <option value="standard">Ritiro in sede (Gratuita)</option>
                        <option value="express">Express (+7.90 €)</option>
                    <?php
                    }

                    ?>
                </select>
            </div>
            <p class="alert text-sm"><b>In 24/48 ore la tesi verrà consegnata</b> all'indirizzo ed alla persona indicata in questa pagina... a patto che i dati siano corretti! Ricorda che la stampa di Rilegature in Carta Riso oppure in Seta comporta almeno un giorno in più di lavorazione.</p>
        </div>
    </form>
</div>