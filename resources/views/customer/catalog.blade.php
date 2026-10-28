<x-app-layout>
    <div class="mx-auto max-w-7xl px-6 py-12">

        <section class="mb-10">
            <h1 class="font-playfair mb-2 text-4xl font-extrabold italic sm:text-5xl lg:text-6xl">
                What's For Today?
            </h1>
            <p class="text-lg font-bold sm:text-xl">Find your menu and order easily.</p>
        </section>

        <section class="mb-8">
            <form method="GET" action="{{ route('customer.catalog') }}">
                <label for="search" class="mb-2 block text-sm font-medium text-terracotta">Search menu</label>

                <div class="relative md:max-w-lg">
                    <svg class="pointer-events-none absolute left-4 top-1/2 size-5 -translate-y-1/2 text-brown/60"
                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="11" cy="11" r="7" /><path d="m21 21-4.3-4.3" />
                    </svg>

                    <input id="search" type="search" name="q" value="{{ request('q') }}" autocomplete="off"
                           placeholder="Example: Fried Rice..."
                           class="w-full rounded-xl border border-brown/30 bg-white py-3 pl-12 pr-4 outline-none transition focus:border-brown focus:ring-2 focus:ring-brown">
                </div>

                @if (request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
            </form>

            <div class="mt-4 flex flex-wrap gap-2">
                @php
                    $chip = 'rounded-full border border-brown px-4 py-1.5 text-sm font-semibold transition';
                @endphp

                <a href="{{ route('customer.catalog', array_filter(['q' => request('q')])) }}"
                   class="{{ $chip }} {{ request('category') ? 'bg-white hover:bg-sky' : 'bg-brown text-cream' }}">
                    All
                </a>

                @foreach ($categories as $category)
                    <a href="{{ route('customer.catalog', array_filter(['q' => request('q'), 'category' => $category->id])) }}"
                       class="{{ $chip }} {{ (string) request('category') === (string) $category->id ? 'bg-brown text-cream' : 'bg-white hover:bg-sky' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </section>

        <section>
            <div class="mb-6 flex items-center justify-between">
                <h2 class="text-2xl font-bold">Menu Catalog</h2>
                <span class="text-sm text-brown/80">{{ $menus->count() }} menu</span>
            </div>

            @if ($menus->isEmpty())
                <div class="rounded-2xl border border-brown bg-sky p-10 text-center shadow-lg">
                    <p class="font-playfair mb-1 text-2xl font-bold italic">Menu not found</p>
                    <p class="text-sm text-brown/80">Try another keyword or category.</p>
                </div>
            @else
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($menus as $menu)
                        <article class="flex h-full flex-col overflow-hidden rounded-2xl border border-brown bg-sky shadow-lg transition hover:-translate-y-1 hover:shadow-xl motion-reduce:transition-none motion-reduce:hover:translate-y-0 {{ $menu->is_available ? '' : 'opacity-70' }}">
                            <div class="flex h-44 items-center justify-center overflow-hidden bg-white text-sm text-brown/60">
                                @if ($menu->image_url)
                                    <img src="{{ $menu->image_url }}" alt="{{ $menu->name }}" class="h-full w-full object-cover">
                                @else
                                    No image
                                @endif
                            </div>

                            <div class="flex flex-1 flex-col p-5">
                                <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-terracotta">
                                    {{ $menu->category->name }}
                                </p>

                                <h3 class="mb-2 text-lg font-bold">{{ $menu->name }}</h3>

                                <p class="mb-5 line-clamp-2 text-sm text-brown/80">{{ $menu->description }}</p>

                                <div class="mt-auto flex items-center justify-between gap-3">
                                    <span class="font-bold text-terracotta">
                                        Rp{{ number_format($menu->price, 0, ',', '.') }}
                                    </span>
                                    
                                    @if ($menu->is_available)
                                        @php $cart = $carts[$menu->id] ?? null; @endphp

                                        @if ($cart)
                                            <div class="flex items-center rounded-lg border border-brown bg-white">
                                                <form method="POST" action="{{ route('cart.update', $cart) }}">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="quantity" value="{{ $cart->quantity - 1 }}">
                                                    <button type="submit" aria-label="Kurangi {{ $menu->name }}"
                                                            class="px-3 py-1.5 font-bold transition hover:bg-cream active:scale-95">−</button>
                                                </form>

                                                <span class="min-w-8 text-center text-sm font-semibold">{{ $cart->quantity }}</span>

                                                <form method="POST" action="{{ route('cart.update', $cart) }}">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="quantity" value="{{ $cart->quantity + 1 }}">
                                                    <button type="submit" @disabled($cart->quantity >= 99)
                                                            aria-label="Tambah {{ $menu->name }}"
                                                            class="px-3 py-1.5 font-bold transition hover:bg-cream active:scale-95 disabled:cursor-not-allowed disabled:opacity-40">+</button>
                                                </form>
                                            </div>
                                        @else
                                            <form method="POST" action="{{ route('cart.store') }}">
                                                @csrf
                                                <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                                                <button type="submit"
                                                        aria-label="Tambah {{ $menu->name }} ke keranjang"
                                                        class="rounded-lg bg-brown px-4 py-2 text-sm font-semibold text-cream transition hover:bg-brown-dark active:scale-95 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brown">
                                                    + Cart
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        <span class="rounded-lg border border-brown/40 bg-white px-4 py-2 text-sm font-semibold text-brown/60">
                                            Sold out
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>
    </div>
</x-app-layout>