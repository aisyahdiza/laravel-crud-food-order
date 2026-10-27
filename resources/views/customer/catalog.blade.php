<x-app-layout>
    <div class="mx-auto max-w-7xl px-6 py-12">

        {{-- HERO --}}
        <section class="mb-10">
            <h1 class="font-playfair mb-2 text-4xl font-extrabold italic sm:text-5xl lg:text-6xl">
                WHAT'S FOR TODAY?
            </h1>
            <p class="text-lg font-bold sm:text-xl">Find your menu and orders easily.</p>
        </section>

        {{-- SEARCH --}}
        <section class="mb-8">
            <label for="search" class="mb-2 block text-sm font-medium text-terracotta">Search menu</label>

            <div class="relative md:max-w-lg">
                <svg class="pointer-events-none absolute left-4 top-1/2 size-5 -translate-y-1/2 text-brown/60"
                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="11" cy="11" r="7" /><path d="m21 21-4.3-4.3" />
                </svg>

                <input id="search" type="search" autocomplete="off"
                       placeholder="Example: Fried Rice..."
                       class="w-full rounded-xl border border-brown/30 bg-white py-3 pl-12 pr-4 outline-none transition focus:border-brown focus:ring-2 focus:ring-brown">
            </div>
        </section>

        {{-- CATALOG --}}
        <section>
            <div class="mb-6 flex items-center justify-between">
                <h2 class="text-2xl font-bold">Menu Catalog</h2>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">

                {{-- 1. Cream Soup --}}
                <article class="flex h-full flex-col overflow-hidden rounded-2xl border border-brown bg-sky shadow-lg transition hover:-translate-y-1 hover:shadow-xl motion-reduce:transition-none motion-reduce:hover:translate-y-0">
                    <div class="flex h-44 items-center justify-center bg-white">
                        ini buat gambarr
                    </div>

                    <div class="flex flex-1 flex-col p-5">
                        <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-terracotta">Appetizer</p>

                        <h3 class="mb-2 text-lg font-bold">Cream Soup</h3>

                        <p class="mb-5 line-clamp-2 text-sm text-brown/80">
                            Creamy soup with chicken and mushroom
                        </p>

                        <div class="mt-auto flex items-center justify-between gap-3">
                            <span class="font-bold text-terracotta">Rp23.000</span>

                            <button type="button"
                                    aria-label="Tambah Cream Soup ke keranjang"
                                    class="rounded-lg bg-brown px-4 py-2 text-sm font-semibold text-cream transition hover:bg-brown-dark active:scale-95 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brown">
                                + Cart
                            </button>
                        </div>
                    </div>
                </article>

                {{-- 2. Special Fried Rice --}}
                <article class="flex h-full flex-col overflow-hidden rounded-2xl border border-brown bg-sky shadow-lg transition hover:-translate-y-1 hover:shadow-xl motion-reduce:transition-none motion-reduce:hover:translate-y-0">
                    <div class="flex h-44 items-center justify-center bg-white">
                        ini buat gambarr
                    </div>

                    <div class="flex flex-1 flex-col p-5">
                        <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-terracotta">Main Course</p>

                        <h3 class="mb-2 text-lg font-bold">Special Fried Rice</h3>

                        <p class="mb-5 line-clamp-2 text-sm text-brown/80">
                            Fried rice with sunny side up egg and sambal
                        </p>

                        <div class="mt-auto flex items-center justify-between gap-3">
                            <span class="font-bold text-terracotta">Rp18.000</span>

                            <button type="button"
                                    aria-label="Tambah Special Fried Rice ke keranjang"
                                    class="rounded-lg bg-brown px-4 py-2 text-sm font-semibold text-cream transition hover:bg-brown-dark active:scale-95 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brown">
                                + Cart
                            </button>
                        </div>
                    </div>
                </article>

                {{-- 3. Chicken Katsu Ricebowl --}}
                <article class="flex h-full flex-col overflow-hidden rounded-2xl border border-brown bg-sky shadow-lg transition hover:-translate-y-1 hover:shadow-xl motion-reduce:transition-none motion-reduce:hover:translate-y-0">
                    <div class="flex h-44 items-center justify-center bg-white">
                        ini buat gambarr
                    </div>

                    <div class="flex flex-1 flex-col p-5">
                        <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-terracotta">Main Course</p>

                        <h3 class="mb-2 text-lg font-bold">Chicken Katsu Ricebowl</h3>

                        <p class="mb-5 line-clamp-2 text-sm text-brown/80">
                            Ricebowl with chicken katsu and signature sauce
                        </p>

                        <div class="mt-auto flex items-center justify-between gap-3">
                            <span class="font-bold text-terracotta">Rp20.000</span>

                            <button type="button"
                                    aria-label="Tambah Chicken Katsu Ricebowl ke keranjang"
                                    class="rounded-lg bg-brown px-4 py-2 text-sm font-semibold text-cream transition hover:bg-brown-dark active:scale-95 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brown">
                                + Cart
                            </button>
                        </div>
                    </div>
                </article>

                {{-- 4. French Fries --}}
                <article class="flex h-full flex-col overflow-hidden rounded-2xl border border-brown bg-sky shadow-lg transition hover:-translate-y-1 hover:shadow-xl motion-reduce:transition-none motion-reduce:hover:translate-y-0">
                    <div class="flex h-44 items-center justify-center bg-white">
                        ini buat gambarr
                    </div>

                    <div class="flex flex-1 flex-col p-5">
                        <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-terracotta">Snack</p>

                        <h3 class="mb-2 text-lg font-bold">French Fries</h3>

                        <p class="mb-5 line-clamp-2 text-sm text-brown/80">
                            Deep fried straight-cut potatoes
                        </p>

                        <div class="mt-auto flex items-center justify-between gap-3">
                            <span class="font-bold text-terracotta">Rp10.000</span>

                            <button type="button"
                                    aria-label="Tambah French Fries ke keranjang"
                                    class="rounded-lg bg-brown px-4 py-2 text-sm font-semibold text-cream transition hover:bg-brown-dark active:scale-95 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brown">
                                + Cart
                            </button>
                        </div>
                    </div>
                </article>

                {{-- 5. Salt and Pepper Fried Tofu --}}
                <article class="flex h-full flex-col overflow-hidden rounded-2xl border border-brown bg-sky shadow-lg transition hover:-translate-y-1 hover:shadow-xl motion-reduce:transition-none motion-reduce:hover:translate-y-0">
                    <div class="flex h-44 items-center justify-center bg-white">
                        ini buat gambarr
                    </div>

                    <div class="flex flex-1 flex-col p-5">
                        <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-terracotta">Snack</p>

                        <h3 class="mb-2 text-lg font-bold">Salt and Pepper Fried Tofu</h3>

                        <p class="mb-5 line-clamp-2 text-sm text-brown/80">
                            Crispy fried tofu with salt and pepper seasoning
                        </p>

                        <div class="mt-auto flex items-center justify-between gap-3">
                            <span class="font-bold text-terracotta">Rp10.000</span>

                            <button type="button"
                                    aria-label="Tambah Salt and Pepper Fried Tofu ke keranjang"
                                    class="rounded-lg bg-brown px-4 py-2 text-sm font-semibold text-cream transition hover:bg-brown-dark active:scale-95 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brown">
                                + Cart
                            </button>
                        </div>
                    </div>
                </article>

                {{-- 6. Caramel Pudding --}}
                <article class="flex h-full flex-col overflow-hidden rounded-2xl border border-brown bg-sky shadow-lg transition hover:-translate-y-1 hover:shadow-xl motion-reduce:transition-none motion-reduce:hover:translate-y-0">
                    <div class="flex h-44 items-center justify-center bg-white">
                        ini buat gambarr
                    </div>

                    <div class="flex flex-1 flex-col p-5">
                        <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-terracotta">Dessert</p>

                        <h3 class="mb-2 text-lg font-bold">Caramel Pudding</h3>

                        <p class="mb-5 line-clamp-2 text-sm text-brown/80">
                            Vanilla pudding with caramel sauce
                        </p>

                        <div class="mt-auto flex items-center justify-between gap-3">
                            <span class="font-bold text-terracotta">Rp12.000</span>

                            <button type="button"
                                    aria-label="Tambah Caramel Pudding ke keranjang"
                                    class="rounded-lg bg-brown px-4 py-2 text-sm font-semibold text-cream transition hover:bg-brown-dark active:scale-95 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brown">
                                + Cart
                            </button>
                        </div>
                    </div>
                </article>
            </div>
        </section>
    </div>
</x-app-layout>