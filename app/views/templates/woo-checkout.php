<?php wp_head();?>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<?php
wp_enqueue_style('tailwind', THESIS_URL . "/app/assets/css/tailwind.css");
wp_enqueue_style('thesis-frontend', THESIS_URL . "/app/assets/css/frontend/thesis-frontend.css");
?>
<body <?php body_class(); ?>>
<div class="thesis--wrapper h-full">
    <header class="thesis--header bg-white w-full top-0 flex justify-between items-center z-[99] px-6 py-4">
        <h1 class="text-xl font-bold m-0">Checkout</h1>
        <a href="/" class="flex items-center gap-2 p-2 bg-white"><span class="!text-black font-bold">ANNULLA</span><span class="material-symbols-outlined !text-black text-xl">close</span></a>
    </header>
    <main>
        
    </main>
</div>
</body>


<?php wp_footer(); ?>

