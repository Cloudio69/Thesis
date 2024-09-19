<div class="thesis--checkout checkout flex flex-col items-center justify-center w-full">
    <form method="POST" class="w-full px-16 flex flex-col gap-4 ">
        <div class="dati--personali flex flex-col gap-4 border bg-white shadow-sm rounded-md p-4">
            <h1 class="text-2xl font-bold">Dati personali</h1>
            <div class="mb-4 flex">
                <div class="w-1/2 pr-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="firstname">Nome</label>
                    <input class="appearance-none !rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none !border-neutral-200" id="firstname" type="text" name="firstname" required>
                </div>
                <div class="w-1/2 pl-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="lastname">Cognome</label>
                    <input class="appearance-none !rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none !border-neutral-200" id="lastname" type="text" name="lastname" required>
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
                <input class="appearance-none !rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none !border-neutral-200" id="email" type="email" name="email" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="phone">Telefono</label>
                <input class="appearance-none !rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none !border-neutral-200" id="phone" type="tel" name="phone" required>
            </div>
        </div>
        <div class="dati--spedizione flex flex-col gap-4 border bg-white shadow-sm rounded-md p-4">
            <h1 class="text-2xl font-bold">Dati per la spedizione</h1>
            <div class="mb-4 flex flex-grow gap-4">
                <div class="">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="province">Provincia</label>
                    <select class="appearance-none rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none !border-neutral-200" id="province" name="province" required>
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
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="indirizzo">Indirizzo</label>
                    <input class="appearance-none !rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none !border-neutral-200" id="address" type="text" name="address" required>
                </div>
                <div class="flex-1">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="citta">Città</label>
                    <input class="appearance-none !rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none !border-neutral-200" id="city" type="text" name="city" required>
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="zipcode">Codice Postale</label>
                <input class="appearance-none !rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none !border-neutral-200" id="zipcode" type="text" name="zipcode" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="delivery">Spedizione</label>
                <select class="appearance-none rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none !border-neutral-200" id="delivery" name="delivery" required>
                    <option value="standard">Standard</option>
                    <option value="express">Express</option>
                </select>
            </div>
            <p class="alert text-sm"><b>In 24/48 ore la tesi verrà consegnata</b> all'indirizzo ed alla persona indicata in questa pagina... a patto che i dati siano corretti! Ricorda che la stampa di Rilegature in Carta Riso oppure in Seta comporta almeno un giorno in più di lavorazione.</p>
        </div>
    </form>
</div>