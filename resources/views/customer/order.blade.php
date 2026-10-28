<x-app-layout>
    <div class="mx-auto max-w-7xl px-6 py-12">

        <section class="mb-10">
            <h1 class="font-playfair mb-2 text-4xl font-extrabold italic sm:text-5xl lg:text-6xl">
                Order History
            </h1>
            <p class="text-lg font-bold sm:text-xl">See your past orders and leave a review.</p>
        </section>

        @if ($orders->isEmpty())
            <section class="rounded-2xl border border-brown bg-sky p-10 text-center shadow-lg">
                <p class="font-playfair mb-2 text-2xl font-bold italic">No orders yet</p>
                <p class="mb-6 text-sm text-brown/80">Your orders will show up here.</p>
                <a href="{{ route('customer.catalog') }}"
                   class="inline-block rounded-lg bg-brown px-5 py-2 text-sm font-semibold text-cream transition hover:bg-brown-dark active:scale-95">
                    Browse Menu
                </a>
            </section>
        @else
            <section class="space-y-4">
                @foreach ($orders as $order)
                    <article class="overflow-hidden rounded-2xl border border-brown bg-sky p-5 shadow-lg">

                        <div class="flex flex-wrap items-start justify-between gap-3">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-terracotta">
                                    Order #{{ $order->id }} · Table {{ $order->table_number }}
                                </p>
                                <p class="text-sm text-brown/80">
                                    {{ $order->created_at->format('d M Y, H:i') }}
                                </p>
                            </div>
                            <x-status-badge :status="$order->status" />
                        </div>

                        <div class="mt-3 flex items-center justify-between">
                            <span class="text-sm text-brown/80">{{ $order->items->sum('quantity') }} item(s)</span>
                            <span class="text-lg font-bold text-terracotta">
                                Rp{{ number_format($order->total_price, 0, ',', '.') }}
                            </span>
                        </div>

                        <details class="group mt-4 border-t border-brown/30 pt-3">
                            <summary class="cursor-pointer text-sm font-semibold underline transition hover:text-brown-dark">
                                <span class="group-open:hidden">View details</span>
                                <span class="hidden group-open:inline">Hide details</span>
                            </summary>

                            <ul class="mt-3 divide-y divide-brown/20 rounded-xl bg-white px-4">
                                @foreach ($order->items as $item)
                                    <li class="flex items-center justify-between gap-4 py-3">
                                        <div>
                                            <p class="font-bold">{{ $item->menu->name }}</p>
                                            <p class="text-sm text-brown/80">
                                                {{ $item->quantity }} × Rp{{ number_format($item->price, 0, ',', '.') }}
                                            </p>
                                        </div>
                                        <p class="font-bold">
                                            Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                        </p>
                                    </li>
                                @endforeach
                            </ul>

                            @if ($order->note)
                                <p class="mt-3 text-sm">
                                    <span class="font-semibold text-terracotta">Notes:</span>
                                    {{ $order->note }}
                                </p>
                            @endif
                        </details>

                        @if ($order->status === \App\Models\Order::STATUS_COMPLETED)
                            <div class="mt-4 border-t border-brown/30 pt-3">
                                @if ($order->review)
                                    <p class="text-xs font-semibold uppercase tracking-wide text-terracotta">Your review</p>
                                    @php $r = (float) $order->review->rating; @endphp

                                    <p class="flex items-center text-xl">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <span class="relative inline-block text-brown/30">★
                                                <span class="absolute inset-y-0 left-0 overflow-hidden whitespace-nowrap text-terracotta"
                                                    style="width: {{ max(0, min(1, $r - ($i - 1))) * 100 }}%">★</span>
                                            </span>
                                        @endfor
                                        <span class="ms-2 text-sm text-brown/80">{{ number_format($r, 1) }}/5</span>
                                    </p>
                                    @if ($order->review->comment)
                                        <p class="text-sm text-brown/80">{{ $order->review->comment }}</p>
                                    @endif
                                @else
                                    <a href="{{ route('review.create', $order) }}"
                                       class="inline-block rounded-lg bg-brown px-4 py-2 text-sm font-semibold text-cream transition hover:bg-brown-dark active:scale-95">
                                        Give Review
                                    </a>
                                @endif
                            </div>
                        @endif
                    </article>
                @endforeach
            </section>
        @endif
    </div>
</x-app-layout>