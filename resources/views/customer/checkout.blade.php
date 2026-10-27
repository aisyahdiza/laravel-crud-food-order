<x-app-layout>
    <div class="mx-auto max-w-7xl px-6 py-12">

        {{-- HERO --}}
        <section class="mb-10">
            <h1 class="font-playfair mb-2 text-4xl font-extrabold italic sm:text-5xl lg:text-6xl">
                CHECKOUT
            </h1>
            <p class="text-lg font-bold sm:text-xl">Choose your table and confirm your order.</p>
        </section>

        <form method="POST" action="{{ route('checkout.store') }}" class="grid grid-cols-1 gap-8 lg:grid-cols-3">
            @csrf

            {{-- LEFT: table + notes --}}
            <div class="space-y-6 lg:col-span-2">

                <div class="rounded-2xl border border-brown bg-sky p-6 shadow-lg">
                    <h2 class="font-playfair mb-4 text-2xl font-bold italic">Order Details</h2>

                    {{-- Table number --}}
                    <div class="mb-5">
                        <label for="table_number" class="mb-2 block text-sm font-medium text-terracotta">Table number</label>
                        <select id="table_number" name="table_number" required
                                class="w-full rounded-xl border border-brown/30 bg-white px-4 py-3 outline-none transition focus:border-brown focus:ring-2 focus:ring-brown md:max-w-xs">
                            <option value="" disabled @selected(! old('table_number'))>Select table...</option>
                            @for ($i = 1; $i <= $tableCount; $i++)
                                <option value="{{ $i }}" @selected((string) old('table_number') === (string) $i)>
                                    Table {{ $i }}
                                </option>
                            @endfor
                        </select>
                        @error('table_number')
                            <p class="mt-2 text-sm font-semibold text-terracotta-dark">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Notes --}}
                    <div>
                        <label for="notes" class="mb-2 block text-sm font-medium text-terracotta">
                            Notes <span class="text-brown/60">(optional)</span>
                        </label>
                        <textarea id="notes" name="notes" rows="3" maxlength="255"
                                  placeholder="Example: no chili, less ice..."
                                  class="w-full rounded-xl border border-brown/30 bg-white px-4 py-3 outline-none transition focus:border-brown focus:ring-2 focus:ring-brown">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="mt-2 text-sm font-semibold text-terracotta-dark">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Items --}}
                <div class="rounded-2xl border border-brown bg-sky p-6 shadow-lg">
                    <h2 class="font-playfair mb-4 text-2xl font-bold italic">Your Items</h2>

                    <ul class="divide-y divide-brown/20">
                        @foreach ($items as $item)
                            <li class="flex items-center justify-between gap-4 py-3">
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-wide text-terracotta">
                                        {{ $item->menu->category->name }}
                                    </p>
                                    <p class="font-bold">{{ $item->menu->name }}</p>
                                    <p class="text-sm text-brown/80">
                                        {{ $item->quantity }} × Rp{{ number_format($item->menu->price, 0, ',', '.') }}
                                    </p>
                                </div>
                                <p class="font-bold">
                                    Rp{{ number_format($item->menu->price * $item->quantity, 0, ',', '.') }}
                                </p>
                            </li>
                        @endforeach
                    </ul>

                    <a href="{{ route('customer.cart') }}"
                       class="mt-4 inline-block text-sm font-semibold text-brown underline transition hover:text-brown-dark">
                        Edit cart
                    </a>
                </div>
            </div>

            {{-- RIGHT: summary --}}
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

                <button type="submit"
                        class="w-full rounded-lg bg-brown px-4 py-3 text-sm font-semibold text-cream transition hover:bg-brown-dark active:scale-95 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brown">
                    Place Order
                </button>

                <a href="{{ route('customer.cart') }}"
                   class="mt-3 block text-center text-sm font-semibold text-brown underline transition hover:text-brown-dark">
                    Back to cart
                </a>
            </aside>
        </form>
    </div>
</x-app-layout>