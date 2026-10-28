<x-app-layout>
    <div class="mx-auto max-w-7xl px-6 py-12">

        {{-- HERO --}}
        <section class="mb-8">
            <h1 class="font-playfair mb-2 text-4xl font-extrabold italic sm:text-5xl lg:text-6xl">Orders</h1>
            <p class="text-lg font-bold sm:text-xl">Track and update incoming orders.</p>
        </section>

        {{-- STATUS FILTER --}}
        @php $tabs = ['' => 'All'] + \App\Models\Order::STATUSES; @endphp
        <div class="mb-6 flex flex-wrap gap-2">
            @foreach ($tabs as $key => $label)
                @php
                    $key = (string) $key;
                    $isActive = (string) ($status ?? '') === $key;
                    $count = $key === '' ? $counts->sum() : ($counts[$key] ?? 0);
                @endphp
                <a href="{{ route('admin.orders.index', $key === '' ? [] : ['status' => $key]) }}"
                    class="rounded-full border px-4 py-1.5 text-sm font-semibold transition active:scale-95
                        {{ $isActive ? 'border-brown bg-brown text-cream' : 'border-brown/40 bg-white text-brown hover:bg-sky' }}">
                    {{ $label }} <span class="opacity-70">({{ $count }})</span>
                </a>
            @endforeach
        </div>

        {{-- TABLE --}}
        <section>
            <div class="overflow-hidden rounded-2xl border border-brown bg-sky shadow-lg">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-sky-dark/30 text-xs uppercase tracking-wide">
                            <tr>
                                <th class="px-5 py-3 font-semibold">Order</th>
                                <th class="px-5 py-3 font-semibold">Customer</th>
                                <th class="px-5 py-3 font-semibold">Table</th>
                                <th class="px-5 py-3 font-semibold">Items</th>
                                <th class="px-5 py-3 font-semibold">Total</th>
                                <th class="px-5 py-3 font-semibold">Status</th>
                                <th class="px-5 py-3 font-semibold">Placed</th>
                                <th class="px-5 py-3 text-right font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                                <tr class="border-t border-brown/20 transition hover:bg-white/50">
                                    <td class="px-5 py-4 font-bold">#{{ $order->id }}</td>
                                    <td class="px-5 py-4">
                                        <p class="font-bold">{{ $order->user->name }}</p>
                                        <p class="text-xs text-brown/70">{{ $order->user->email }}</p>
                                    </td>
                                    <td class="whitespace-nowrap px-5 py-4">Table {{ $order->table_number }}</td>
                                    <td class="whitespace-nowrap px-5 py-4">{{ $order->items_count }} {{ Str::plural('item', $order->items_count) }}</td>
                                    <td class="px-5 py-4 font-bold text-terracotta">
                                        Rp{{ number_format($order->total_price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-5 py-4"><x-status-badge :status="$order->status" /></td>
                                    <td class="whitespace-nowrap px-5 py-4 text-xs text-brown/80">{{ $order->created_at->format('d M Y, H:i') }}</td>
                                    <td class="px-5 py-4 text-right">
                                        <a href="{{ route('admin.orders.show', $order) }}"
                                            class="rounded-lg border border-brown/40 px-3 py-1.5 text-xs font-semibold text-brown transition hover:bg-white/50">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-5 py-12 text-center text-brown/80">
                                        No orders found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6">{{ $orders->links() }}</div>
        </section>
    </div>
</x-app-layout>