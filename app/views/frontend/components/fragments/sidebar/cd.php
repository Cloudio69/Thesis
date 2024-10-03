<div id="cd_step" class="p-12 flex flex-col gap-4 mb-12">
    <h1 class="text-3xl font-bold">Il tuo CD</h1>
    <p>Puoi includere con la tesi un CD serigrafato, <b>cliccando su Si, potrai modificarlo secondo le tue preferenze, scegli se aggiungere dei file sul disco o lasciare la tesi</b><br><br>Altrimenti puoi proseguire con la finalizzazione <b>cliccando su No</b></p>
    <section class="tipo--stampa-cd h-full flex-col flex justify-center items-center">
        <h2 class="text-xl text-center font-bold p-4">Vuoi aggiungere il CD?</h2>
        <div class="flex items-center justify-center gap-8 cursor-pointer">
            <div id="edit-cd" class="flex flex-col gap-2 items-center">
                <span class="material-symbols-outlined text-[10rem] p-4 rounded-xl border-2">check</span>
                <b>SI</b>
            </div>
            <div id="no-cd" class="next-step flex flex-col gap-2 items-center cursor-pointer">
                <span class="material-symbols-outlined text-[10rem] p-4 rounded-xl border-2">close</span>
                <b>NO</b>
            </div>
        </div>
    </section>
    <form class="hidden mt-4 flex-col gap-4" id="form_cd">
            <h1 class="font-bold text-xl">
                Puoi cliccare sui testi presenti sul CD a sinistra per modificarli
            </h1>
            <p>
                Dopo aver cambiato il contenuto del CD, clicca su "Aggiungi al carrello" per confermare le modifiche
            </p>
            <div class="flex flex-col gap-4 mt-4">
                <label for="contenuto">Contenuto del disco:</label>
                <select name="contenuto" id="contenuto" class="p-2 rounded-md" required>
                    <option value="" selected disabled>Seleziona il contenuto del CD</option>
                    <option value="tesi">Solo la tesi</option>
                    <option value="file">Tesi e file aggiuntivi</option>
                </select>
            </div>
            <div class="flex-col gap-4 mt-4 p-4 border rounded-md hidden" id="file_list_wrapper">
                <label for="file_cd" class="font-bold text-2xl flex items-center justify-between cursor-pointer"><span>File</span><span id="add_file_cd" class="material-symbols-outlined rounded-full flex items-center justify-center !text-white bg-amber-500">add</span></label>
                <input type="file" name="file_cd" id="file_cd" class="hidden rounded-md" disabled accept=".doc,.docx,.ppt,.pptx,.xls,.xlsx,.mp4,.mp3,.png,.jpg" />
                <div id="file_list_cd" class="min-h-16 flex flex-col gap-2">
                    <p class="opacity-50">Nessun file selezionato</p>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div class="bg-blue-600 h-2.5 rounded-full w-0" id="progress-bar"></div>
                </div>
            </div>
            <p class="text-sm opacity-50 hidden formati-accettati">Formati accettati: .doc, .docx, .ppt, .pptx, .xls, .xlsx, .mp4, .mp3, .png, .jpg</p>
            <div class="flex flex-col gap-4">
                <div class="flex flex-col p-4 gap-4 border rounded-md info_universita">
                    <h1 class="text-xl font-bold">Dettagli università</h1>
                <div class="flex flex-col">
                    <label for="nome_universita" class="text-sm py-2">Nome Università:</label>
                    <input type="text" name="nome_universita" id="nome_universita" class="p-2 !rounded-md" required placeholder="Università degli Studi di Milano"/>
                </div>
                <div class="flex flex-col">
                    <label for="nome_facolta" class="text-sm py-2">Nome Facoltà</label>
                    <input type="text" name="nome_facolta" id="nome_facolta" class="p-2 !rounded-md" required placeholder="Facoltà di Ingegneria Informatica"/>
                </div>
                <div class="flex flex-col">
                    <label for="corso_laurea" class="text-sm py-2">Corso di Laurea</label>
                    <input type="text" name="corso_laurea" id="corso_laurea" class="p-2 !rounded-md" required placeholder="Corso di Laurea in Ingegneria"/>
                </div>
                </div>
                <div class="flex flex-col p-4 gap-4 border rounded-md info_figure">
                    <h1 class="text-xl font-bold">Dettagli Studente/Relatori</h1>
                    <div class="flex flex-col">
                        <label for="nome_studente" class="text-sm py-2">Nome e Cognome Studente:</label>
                        <input type="text" name="nome_studente" id="nome_studente" class="p-2 !rounded-md" required placeholder="Claudio Caso"/>
                    </div>
                    <div class="flex flex-col">
                        <label for="numero_matricola" class="text-sm py-2">Numero Matricola</label>
                        <input type="text" name="numero_matricola" id="numero_matricola" class="p-2 !rounded-md" required placeholder="735734"/>
                    </div>
                    <div class="flex flex-col">
                        <label for="nome_relatori" class="text-sm py-2">Nome e Cognome Relatori</label>
                        <input type="text" name="nome_relatori" id="nome_relatori" class="p-2 !rounded-md" required placeholder="Giorgio Bianchi, Mario Rossi"/>
                        <span class="text-sm opacity-50">Separare i nomi con una virgola</span>
                    </div>
                    <div class="flex flex-col">
                        <label for="nome_controrelatori" class="text-sm py-2">Nome e Cognome Contro relatori</label>
                        <input type="text" name="nome_controrelatori" id="nome_controrelatori" class="p-2 !rounded-md" required placeholder="John Doe, Giuseppe Scaringi"/>
                        <span class="text-sm opacity-50">Separare i nomi con una virgola</span>
                    </div>
                </div>
                <div class="flex flex-col p-4 gap-4 border rounded-md info_tesi">
                    <h1 class="text-xl font-bold">Dettagli Tesi</h1>
                    <div class="flex flex-col">
                        <label for="titolo_tesi" class="text-sm py-2">Titolo Tesi:</label>
                        <textarea name="titolo_tesi" id="titolo_tesi" class="p-2 !rounded-md" required placeholder="Sviluppo di un'applicazione web"></textarea>
                    </div>
                    <div class="flex flex-col">
                        <label for="anno_accademico" class="text-sm py-2">Anno Accademico</label>
                        <input type="text" name="anno_accademico" id="anno_accademico" class="p-2 !rounded-md" required placeholder="2021/2022"/>
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-4 mt-4">
                <label for="quantita_cd">Quantità:</label>
                <input type="number" name="quantita_cd" id="quantita_cd" class="p-2 rounded-md" min="1" value="1" required/>
            </div>
            <div class="flex justify-between">
            <h1 class="font-bold text-xl flex gap-2 items-center"><span class="material-symbols-outlined">euro_symbol</span>Subtotale</h1>
            <p class="font-bold text-2xl" id="subtotale_cd"><?php echo get_option('prezzo_cd'); ?>€</p>
            </div>
            <button type="submit" class="rounded-md bg-[#f4b424] hover:bg-slate-400 text-white border-none focus:bg-yellow-400 w-full" disabled>AGGIUNGI E PROSEGUI</button>
            <button type="button" class="rounded-md bg-neutral-300 hover:bg-neutral-400 text-neutral-800 border-none focus:bg-yellow-400 w-full next-step" id="no_cd">NO, GRAZIE</button>
        </form>
</div>