<div id="cd_step" class="p-12 flex flex-col gap-4 h-3/4">
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
            <div class="flex flex-col gap-4">
                <label for="contenuto">Contenuto del disco:</label>
                <select name="contenuto" id="contenuto" class="p-2 rounded-md" required>
                    <option value="" selected disabled>Seleziona il contenuto del CD</option>
                    <option value="tesi">Solo la tesi</option>
                    <option value="file">Tesi e file aggiuntivi</option>
                </select>
            </div>
            <div class="flex flex-col gap-4 mt-4 p-4 border rounded-md opacity-50" id="file_list_wrapper">
                <label for="file_cd" class="font-bold text-2xl flex items-center justify-between cursor-pointer"><span>File</span><span id="add_file_cd" class="material-symbols-outlined rounded-full flex items-center justify-center !text-white bg-amber-500">add</span></label>
                <input type="file" name="file_cd" id="file_cd" class="hidden rounded-md" disabled accept=".doc,.docx,.ppt,.pptx,.xls,.xlsx,.mp4,.mp3,.png,.jpg" />
                <div id="file_list_cd" class="min-h-16 flex flex-col gap-2">
                    <p class="opacity-50">Nessun file selezionato</p>
                </div>
            </div>
            <p class="text-sm opacity-50">Formati accettati: .doc, .docx, .ppt, .pptx, .xls, .xlsx, .mp4, .mp3, .png, .jpg</p>
            <div class="flex flex-col gap-4 mt-4">
                <label for="quantita_cd">Quantità:</label>
                <input type="number" name="quantita_cd" id="quantita_cd" class="p-2 rounded-md" min="1" value="1" required/>
            </div>
            <button type="submit" class="rounded-md bg-slate-600 hover:bg-slate-400 text-white border-none focus:bg-yellow-400 w-full">AGGIUNGI AL CARRELLO</button>
            <button type="button" class="rounded-md bg-neutral-300 hover:bg-neutral-400 text-neutral-800 border-none focus:bg-yellow-400 w-full" id="no_cd">NO, GRAZIE</button>
        </form>
</div>