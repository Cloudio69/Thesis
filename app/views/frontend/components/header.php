<div class="thesis--header fixed w-full z-50 bg-white top-0 overflow-auto md:top-auto md:overflow-visible">
    <section class="thesis--navigation flex items-center justify-between divide-x border-b shadow-sm">
        <div id="frontespizio" class="active route flex items-center gap-4 p-4 flex-1 justify-center cursor-pointer">
            <span class="material-symbols-outlined !text-2xl">description</span>
            <h1 class="font-medium">FRONTESPIZIO</h1>
        </div>
        <div id="tipologia" class="route flex items-center gap-4 p-4 flex-1 justify-center cursor-pointer">
            <span class="material-symbols-outlined !text-2xl">copy_all</span>
            <h1 class="font-medium">TIPOLOGIA</h1>
        </div>
        <div id="rilegature" class="route flex items-center gap-4 p-4 flex-1 justify-center cursor-pointer">
            <span class="material-symbols-outlined !text-2xl">book_2</span>
            <h1 class="font-medium">RILEGATURE</h1>
        </div>
        <div id="pagine" class="route flex items-center gap-4 p-4 flex-1 justify-center cursor-pointer">
            <span class="material-symbols-outlined !text-2xl">auto_stories</span>
            <h1 class="font-medium">PAGINE</h1>
        </div>
        <div id="cd" class="route flex items-center gap-4 p-4 flex-1 justify-center cursor-pointer">
            <span class="material-symbols-outlined !text-2xl">album</span>
            <h1 class="font-medium">CD</h1>
        </div>
        <div id="finalizza" class="route flex items-center gap-4 p-4 flex-1 justify-center cursor-pointer">
            <span class="material-symbols-outlined !text-2xl">done_all</span>
            <h1 class="font-medium">FINALIZZA</h1>
        </div>
        <div id="checkout" class="route flex items-center gap-4 p-4 flex-1 justify-center cursor-pointer">
            <span class="material-symbols-outlined !text-2xl">shopping_cart_checkout</span>
            <h1 class="font-medium">CHECKOUT</h1>
        </div>
    </section>
    <section class="thesis--cart relative flex flex-col items-start">
    <button class="flex mx-4 my-2 open-cart-dialog absolute shadow-md items-center gap-2 py-2 px-4 justify-center border-none hover:bg-black focus:bg-white bg-white w-fit text-black font-bold text-left focus:outline-none focus:text-black rounded-md outline-none text-sm"><span class="material-symbols-outlined text-xl">
            shopping_bag
        </span>CARRELLO</button>
        <div class="thesis--cart-dialog top-14 mx-4 absolute hidden rounded-md bg-white shadow-md border border-gray-200 z-50 w-[25vw]">
            <div class="flex items-center justify-between p-4 border-b">
                <h1 class="font-bold text-xl">Carrello</h1>
                <a class="close-cart-dialog cursor-pointer">
                    <span class="material-symbols-outlined text-xl">close</span>
                </a>
            </div>
            <div class="thesis--cart-items p-4 flex flex-col gap-4 max-h-[60vh] overflow-auto">
                <p class="placeholder-cart opacity-50">Nessun prodotto nel carrello.</p>
            </div>
        </div>
    </section>
</div>
