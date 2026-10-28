<x-app-layout>
    <div class="mx-auto max-w-7xl px-6 py-12"
        x-data="{ cancelOpen: false }"
        @keydown.escape.window="cancelOpen = false">

        <a href="{{ route('admin.orders.index') }}"
            class="text-sm font-medium text-terracotta transition hover:text-terracotta-dark">&larr; Back to orders</a>

        <section class="mb-8 mt-4 flex flex-wrap items-end justify-between gap-4">
            <div>
                <h1 class="font-playfair mb-2 text-4xl font-extrabold italic sm:text-5xl">Order #{{ $order->id }}</h1>
                <p class="text-lg font-bold">Placed {{ $order->created_at->format('d M Y, H:i') }}</p>
            </div>
            <x-status-badge :status="$order->status" class="px-4 py-1.5 text-sm" />
        </section>

        <div class="grid gap-6 lg:grid-cols-3">

            {{-- ITEMS --}}
            <div class="overflow-hidden rounded-2xl border border-brown bg-sky shadow-lg lg:col-span-2">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-sky-dark/30 text-xs uppercase tracking-wide">
                            <tr>
                                <th class="px-5 py-3 font-semibold">Menu</th>
                                <th class="px-5 py-3 font-semibold">Qty</th>
                                <th class="px-5 py-3 font-semibold">Price</th>
                                <th class="px-5 py-3 text-right font-semibold">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $item)
                                <tr class="border-t border-brown/20">
                                    <td class="px-5 py-4 font-bold">{{ $item->menu->name }}</td>
                                    <td class="px-5 py-4">{{ $item->quantity }}</td>
                                    <td class="px-5 py-4">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="px-5 py-4 text-right font-bold text-terracotta">
                                        Rp{{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="border-t border-brown bg-white/40">
                                <td colspan="3" class="px-5 py-4 text-right font-bold uppercase tracking-wide">Total</td>
                                <td class="px-5 py-4 text-right text-lg font-bold text-terracotta">
                                    Rp{{ number_format($order->total_price, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            {{-- DETAILS & ACTIONS --}}
            <div class="space-y-6">

                {{-- Progress --}}
                <div class="rounded-2xl border border-brown bg-sky p-6 shadow-lg">
                    <h2 class="mb-4 text-sm font-bold uppercase tracking-wide text-terracotta">Progress</h2>

                    @if ($order->status === \App\Models\Order::STATUS_CANCELLED)
                        <x-status-badge :status="$order->status" class="px-4 py-1.5 text-sm" />
                        <p class="mt-3 text-sm text-brown/80">This order was cancelled.</p>
                    @else
                        @php
                            $steps = ['pending', 'processing', 'ready', 'completed'];
                            $currentIndex = array_search($order->status, $steps);
                        @endphp
                        <ol class="flex items-start gap-2">
                            @foreach ($steps as $i => $step)
                                @php $reached = $currentIndex !== false && $i <= $currentIndex; @endphp
                                <li class="flex-1">
                                    <div class="h-2 rounded-full {{ $reached ? 'bg-terracotta' : 'bg-brown/20' }}"></div>
                                    <p class="mt-1.5 text-[10px] font-semibold uppercase leading-tight {{ $reached ? 'text-brown' : 'text-brown/50' }}">
                                        {{ \App\Models\Order::STATUSES[$step] }}
                                    </p>
                                </li>
                            @endforeach
                        </ol>
                    @endif

                    <div class="mt-6 space-y-3">
                        @if ($order->next_status)
                            <form method="POST" action="{{ route('admin.orders.status', $order) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="w-full rounded-lg bg-brown px-5 py-2.5 text-sm font-semibold text-cream transition hover:bg-brown-dark active:scale-95">
                                    Mark as {{ \App\Models\Order::STATUSES[$order->next_status] }}
                                </button>
                            </form>
                        @endif

                        @if ($order->canBeCancelled())
                            <button type="button" @click="cancelOpen = true"
                                    class="w-full rounded-lg border border-terracotta px-5 py-2.5 text-sm font-semibold text-terracotta transition hover:bg-terracotta hover:text-cream active:scale-95">
                                Cancel order
                            </button>
                        @endif

                        @if (! $order->next_status && ! $order->canBeCancelled())
                            <p class="text-sm text-brown/80">No further actions available for this order.</p>
                        @endif
                    </div>
                </div>

                {{-- Details --}}
                <div class="rounded-2xl border border-brown bg-sky p-6 shadow-lg">
                    <h2 class="mb-4 text-sm font-bold uppercase tracking-wide text-terracotta">Order details</h2>

                    <dl class="space-y-3 text-sm">
                        <div>
                            <dt class="text-xs text-brown/70">Customer</dt>
                            <dd class="font-bold">{{ $order->user->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-brown/70">Email</dt>
                            <dd>{{ $order->user->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-brown/70">Phone</dt>
                            <dd>{{ $order->user->phone ?: '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-brown/70">Table number</dt>
                            <dd class="font-bold">Table {{ $order->table_number }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-brown/70">Note</dt>
                            <dd>{{ $order->note ?: '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-brown/70">Completed at</dt>
                            <dd>{{ $order->completed_at ? $order->completed_at->format('d M Y, H:i') : '-' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        {{-- CANCEL MODAL --}}
        <div x-show="cancelOpen" x-transition.opacity style="display: none;"
            class="fixed inset-0 z-50 flex items-center justify-center px-4"
            role="dialog" aria-modal="true">

            <div class="absolute inset-0 bg-brown-dark/60" @click="cancelOpen = false"></div>

            <div x-show="cancelOpen" x-transition
                class="relative w-full max-w-md rounded-2xl border border-brown bg-sky p-6 shadow-xl">
                <h2 class="font-playfair text-3xl font-extrabold italic">Cancel Order?</h2>

                <p class="mt-3 text-sm text-brown/80">
                    Are you sure you want to cancel
                    <span class="font-bold text-brown">order #{{ $order->id }}</span>?
                    This action cannot be undone.
                </p>

                <form method="POST" action="{{ route('admin.orders.cancel', $order) }}" class="mt-6 flex justify-end gap-3">
                    @csrf
                    @method('PATCH')

                    <button type="button" @click="cancelOpen = false"
                            class="rounded-lg border border-brown/40 px-5 py-2.5 text-sm font-semibold text-brown transition hover:bg-white/50">
                        Keep order
                    </button>
                    <button type="submit"
                            class="rounded-lg bg-terracotta px-5 py-2.5 text-sm font-semibold text-cream transition hover:bg-terracotta-dark active:scale-95">
                        Yes, cancel
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>