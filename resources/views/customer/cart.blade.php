<x-app-layout>
    <div class="mx-auto max-w-7xl px-6 py-12">

        {{-- HERO --}}
        <section class="mb-10">
            <h1 class="font-playfair mb-2 text-4xl font-extrabold italic sm:text-5xl lg:text-6xl">
                YOUR CART
            </h1>
            <p class="text-lg font-bold sm:text-xl">Check your orders before checkout.</p>
        </section>

        @if ($items->isEmpty())
            {{-- EMPTY STATE --}}
            <section class="rounded-2xl border border-brown bg-sky p-10 text-center shadow-lg">
                <p class="font-playfair mb-2 text-2xl font-bold italic">Your cart is empty</p>
                <p class="mb-6 text-sm text-brown/80">Looks like you haven't picked anything yet.</p>
                <a href="{{ route('customer.catalog') }}"
                   class="inline-block rounded-lg bg-brown px-5 py-2 text-sm font-semibold text-cream transition hover:bg-brown-dark active:scale-95">
                    Browse Menu
                </a>
            </section>
        @else
            <section class="grid grid-cols-1 gap-8 lg:grid-cols-3">

                {{-- ITEM LIST --}}
                <div class="space-y-4 lg:col-span-2">
                    <div class="mb-2 flex items-center justify-between">
                        <h2 class="text-2xl font-bold">Order Items</h2>
                        <span class="text-sm text-brown/80">{{ $totalItems }} item(s)</span>
                    </div>

                    @foreach ($items as $item)
                        @php $menu = $item->menu; @endphp

                        <article class="flex flex-col gap-4 overflow-hidden rounded-2xl border border-brown bg-sky p-4 shadow-lg sm:flex-row sm:items-center">

                            <div class="flex h-24 w-full shrink-0 items-center justify-center overflow-hidden rounded-xl bg-white text-sm text-brown/60 sm:w-24">
                                @if ($menu->image_link)
                                    <img src="{{ $menu->image_link }}" alt="{{ $menu->name }}" class="h-full w-full object-cover">
                                @else
                                    No image
                                @endif
                            </div>

                            <div class="flex-1">
                                <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-terracotta">
                                    {{ $menu->category->name }}
                                </p>
                                <h3 class="text-lg font-bold">{{ $menu->name }}</h3>
                                <p class="font-bold text-terracotta">
                                    Rp{{ number_format($menu->price, 0, ',', '.') }}
                                </p>
                                @unless ($menu->is_available)
                                    <p class="mt-1 text-xs font-semibold text-terracotta-dark">Currently unavailable</p>
                                @endunless
                            </div>

                            <div class="flex items-center justify-between gap-4 sm:flex-col sm:items-end">
                                {{-- Quantity --}}
                                <div class="flex items-center rounded-lg border border-brown bg-white">
                                    <form method="POST" action="{{ route('cart.update', $item) }}">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="quantity" value="{{ $item->quantity - 1 }}">
                                        <button type="submit" @disabled($item->quantity <= 1)
                                                aria-label="Kurangi jumlah"
                                                class="px-3 py-1 font-bold transition hover:bg-cream active:scale-95 disabled:cursor-not-allowed disabled:opacity-40">−</button>
                                    </form>

                                    <span class="min-w-8 text-center text-sm font-semibold">{{ $item->quantity }}</span>

                                    <form method="POST" action="{{ route('cart.update', $item) }}">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="quantity" value="{{ $item->quantity + 1 }}">
                                        <button type="submit" @disabled($item->quantity >= 99)
                                                aria-label="Tambah jumlah"
                                                class="px-3 py-1 font-bold transition hover:bg-cream active:scale-95 disabled:cursor-not-allowed disabled:opacity-40">+</button>
                                    </form>
                                </div>

                                <div class="text-right">
                                    <p class="text-sm font-bold">
                                        Rp{{ number_format($menu->price * $item->quantity, 0, ',', '.') }}
                                    </p>

                                    <form method="POST" action="{{ route('cart.destroy', $item) }}">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="text-xs font-semibold text-terracotta underline transition hover:text-terracotta-dark">
                                            Remove
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                {{-- SUMMARY --}}
                <aside class="h-fit rounded-2xl border border-brown bg-sky p-6 shadow-lg lg:sticky lg:top-6">
                    <h2 class="font-playfair mb-4 text-2xl font-bold italic">Order Summary</h2>

                    <div class="mb-2 flex justify-between text-sm">
                        <span class="text-brown/80">Total items</span>
                        <span class="font-semibold">{{ $totalItems }}</span>
                    </div>
                    <div class="mb-4 flex justify-between text-sm">
                        <span class="text-brown/80">Subtotal</span>
                        <span class="font-semibold">Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>

                    <div class="mb-6 flex items-center justify-between border-t border-brown/30 pt-4">
                        <span class="font-bold">Total</span>
                        <span class="text-xl font-bold text-terracotta">Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>

                    <a href="{{ route('checkout.index') }}"
                    class="block w-full rounded-lg bg-brown px-4 py-3 text-center text-sm font-semibold text-cream transition hover:bg-brown-dark active:scale-95 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brown">
                        Checkout
                    </a>

                    <a href="{{ route('customer.catalog') }}"
                       class="mt-3 block text-center text-sm font-semibold text-brown underline transition hover:text-brown-dark">
                        Continue shopping
                    </a>
                </aside>
            </section>
        @endif
    </div>
</x-app-layout>