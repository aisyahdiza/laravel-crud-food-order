<x-app-layout>
    <div class="mx-auto max-w-7xl px-6 py-12"
         x-data="{
            items: [
                { id: 1, name: 'Cream Soup',             category: 'Appetizer',   price: 23000, qty: 1 },
                { id: 2, name: 'Special Fried Rice',     category: 'Main Course', price: 18000, qty: 2 },
                { id: 3, name: 'Caramel Pudding',        category: 'Dessert',     price: 12000, qty: 1 },
            ],
            rupiah(n) { return 'Rp' + n.toLocaleString('id-ID'); },
            get totalItems() { return this.items.reduce((s, i) => s + i.qty, 0); },
            get subtotal() { return this.items.reduce((s, i) => s + i.price * i.qty, 0); },
            remove(id) { this.items = this.items.filter(i => i.id !== id); },
         }">

        {{-- HERO --}}
        <section class="mb-10">
            <h1 class="font-playfair mb-2 text-4xl font-extrabold italic sm:text-5xl lg:text-6xl">
                YOUR CART
            </h1>
            <p class="text-lg font-bold sm:text-xl">Check your orders before checkout.</p>
        </section>

        {{-- EMPTY STATE --}}
        <section x-show="items.length === 0" x-cloak
                 class="rounded-2xl border border-brown bg-sky p-10 text-center shadow-lg">
            <p class="font-playfair mb-2 text-2xl font-bold italic">Your cart is empty</p>
            <p class="mb-6 text-sm text-brown/80">Looks like you haven't picked anything yet.</p>
            <a href="{{ route('customer.catalog') }}"
               class="inline-block rounded-lg bg-brown px-5 py-2 text-sm font-semibold text-cream transition hover:bg-brown-dark active:scale-95">
                Browse Menu
            </a>
        </section>

        {{-- CART CONTENT --}}
        <section x-show="items.length > 0" class="grid grid-cols-1 gap-8 lg:grid-cols-3">

            {{-- ITEM LIST --}}
            <div class="space-y-4 lg:col-span-2">
                <div class="mb-2 flex items-center justify-between">
                    <h2 class="text-2xl font-bold">Order Items</h2>
                    <span class="text-sm text-brown/80" x-text="totalItems + ' item(s)'"></span>
                </div>

                <template x-for="item in items" :key="item.id">
                    <article class="flex flex-col gap-4 overflow-hidden rounded-2xl border border-brown bg-sky p-4 shadow-lg sm:flex-row sm:items-center">

                        <div class="flex h-24 w-full shrink-0 items-center justify-center rounded-xl bg-white text-sm sm:w-24">
                            ini buat gambarr
                        </div>

                        <div class="flex-1">
                            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-terracotta" x-text="item.category"></p>
                            <h3 class="text-lg font-bold" x-text="item.name"></h3>
                            <p class="font-bold text-terracotta" x-text="rupiah(item.price)"></p>
                        </div>

                        <div class="flex items-center justify-between gap-4 sm:flex-col sm:items-end">
                            {{-- Quantity --}}
                            <div class="flex items-center rounded-lg border border-brown bg-white">
                                <button type="button"
                                        x-on:click="item.qty = Math.max(1, item.qty - 1)"
                                        aria-label="Kurangi jumlah"
                                        class="px-3 py-1 font-bold transition hover:bg-cream active:scale-95">−</button>
                                <span class="min-w-8 text-center text-sm font-semibold" x-text="item.qty"></span>
                                <button type="button"
                                        x-on:click="item.qty++"
                                        aria-label="Tambah jumlah"
                                        class="px-3 py-1 font-bold transition hover:bg-cream active:scale-95">+</button>
                            </div>

                            <div class="text-right">
                                <p class="text-sm font-bold" x-text="rupiah(item.price * item.qty)"></p>
                                <button type="button"
                                        x-on:click="remove(item.id)"
                                        class="text-xs font-semibold text-terracotta underline transition hover:text-terracotta-dark">
                                    Remove
                                </button>
                            </div>
                        </div>
                    </article>
                </template>
            </div>

            {{-- SUMMARY --}}
            <aside class="h-fit rounded-2xl border border-brown bg-sky p-6 shadow-lg lg:sticky lg:top-6">
                <h2 class="font-playfair mb-4 text-2xl font-bold italic">Order Summary</h2>

                <div class="mb-2 flex justify-between text-sm">
                    <span class="text-brown/80">Total items</span>
                    <span class="font-semibold" x-text="totalItems"></span>
                </div>
                <div class="mb-4 flex justify-between text-sm">
                    <span class="text-brown/80">Subtotal</span>
                    <span class="font-semibold" x-text="rupiah(subtotal)"></span>
                </div>

                <div class="mb-6 flex items-center justify-between border-t border-brown/30 pt-4">
                    <span class="font-bold">Total</span>
                    <span class="text-xl font-bold text-terracotta" x-text="rupiah(subtotal)"></span>
                </div>

                <button type="button"
                        class="w-full rounded-lg bg-brown px-4 py-3 text-sm font-semibold text-cream transition hover:bg-brown-dark active:scale-95 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brown">
                    Checkout
                </button>

                <a href="{{ route('customer.catalog') }}"
                   class="mt-3 block text-center text-sm font-semibold text-brown underline transition hover:text-brown-dark">
                    Continue shopping
                </a>
            </aside>
        </section>
    </div>
</x-app-layout>