<x-app-layout>
    <div class="mx-auto max-w-3xl px-6 py-12">

        <section class="mb-10">
            <h1 class="font-playfair mb-2 text-4xl font-extrabold italic sm:text-5xl">
                Rate and Review
            </h1>
            <p class="text-lg font-bold sm:text-xl">
                Order #{{ $order->id }} · Table {{ $order->table_number }}
            </p>
        </section>

        <div class="rounded-2xl border border-brown bg-sky p-6 shadow-lg">

            <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-terracotta">You ordered</p>
            <ul class="mb-6 text-sm text-brown/80">
                @foreach ($order->items as $item)
                    <li>{{ $item->quantity }}× {{ $item->menu->name }}</li>
                @endforeach
            </ul>

            <form method="POST" action="{{ route('review.store', $order) }}"
                x-data="{ rating: {{ (float) old('rating', 0) }}, hover: 0 }">
                @csrf

                <div class="mb-5">
                    <label class="mb-2 block text-sm font-medium text-terracotta">Rating</label>

                    <input type="hidden" name="rating" :value="rating">

                    <div class="flex items-center gap-1" @mouseleave="hover = 0">
                        @for ($i = 1; $i <= 5; $i++)
                            <div class="relative inline-block text-4xl leading-none">

                                <span class="text-brown/30">★</span>

                                <span class="pointer-events-none absolute inset-y-0 left-0 overflow-hidden whitespace-nowrap text-terracotta"
                                    :style="`width: ${Math.min(Math.max((hover || rating) - {{ $i - 1 }}, 0), 1) * 100}%`">★</span>

                                <button type="button"
                                        @click="rating = {{ $i - 0.5 }}"
                                        @mouseenter="hover = {{ $i - 0.5 }}"
                                        aria-label="{{ $i - 0.5 }} bintang"
                                        class="absolute inset-y-0 left-0 w-1/2"></button>

                                <button type="button"
                                        @click="rating = {{ $i }}"
                                        @mouseenter="hover = {{ $i }}"
                                        aria-label="{{ $i }} bintang"
                                        class="absolute inset-y-0 right-0 w-1/2"></button>
                            </div>
                        @endfor

                        <span class="ms-3 text-sm font-semibold text-brown/80"
                            x-text="(hover || rating) ? (hover || rating).toFixed(1) + ' / 5' : ''"></span>
                    </div>

                    @error('rating')
                        <p class="mt-2 text-sm font-semibold text-terracotta-dark">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="comment" class="mb-2 block text-sm font-medium text-terracotta">
                        Comment <span class="text-brown/60">(optional)</span>
                    </label>
                    <textarea id="comment" name="comment" rows="3" maxlength="255"
                              placeholder="How was your food and service?"
                              class="w-full rounded-xl border border-brown/30 bg-white px-4 py-3 outline-none transition focus:border-brown focus:ring-2 focus:ring-brown">{{ old('comment') }}</textarea>
                    @error('comment')
                        <p class="mt-2 text-sm font-semibold text-terracotta-dark">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-4">
                    <button type="submit"
                            class="rounded-lg bg-brown px-5 py-3 text-sm font-semibold text-cream transition hover:bg-brown-dark active:scale-95 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brown">
                        Submit Review
                    </button>
                    <a href="{{ route('customer.order') }}"
                       class="text-sm font-semibold text-brown underline transition hover:text-brown-dark">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>