# Thesis
### Plugin per personalizzare le tesi

Per inizializzare il plugin, installa le dependencies con

`cd app/vendor && composer require tecnickcom/tcpdf`

Per integrare nuove classe di Tailwind, è necessario eseguire il comando

`cd app/vendor && npx tailwindcss -i ../assets/css/main.css -o ../assets/css/tailwind.css --watch`