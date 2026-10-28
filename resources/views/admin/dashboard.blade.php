<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin Dashboard</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white p-5 rounded-lg shadow">
                    <p class="text-sm text-gray-500">Total orders</p>
                    <p class="text-2xl font-bold">{{ $totalOrders }}</p>
                </div>
                <div class="bg-white p-5 rounded-lg shadow">
                    <p class="text-sm text-gray-500">Today's orders</p>
                    <p class="text-2xl font-bold">{{ $todayOrders }}</p>
                </div>
                <div class="bg-white p-5 rounded-lg shadow">
                    <p class="text-sm text-gray-500">Active orders</p>
                    <p class="text-2xl font-bold">{{ $activeOrders }}</p>
                </div>
                <div class="bg-white p-5 rounded-lg shadow">
                    <p class="text-sm text-gray-500">Revenue (completed)</p>
                    <p class="text-2xl font-bold">Rp {{ number_format($revenue, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="bg-white p-5 rounded-lg shadow">
                <h3 class="font-semibold mb-3">Best-selling menus</h3>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-gray-500">
                            <th class="py-2">Menu</th>
                            <th class="py-2">Sold</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($topMenus as $menu)
                            <tr class="border-t">
                                <td class="py-2">{{ $menu->name }}</td>
                                <td class="py-2">{{ $menu->total_sold }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="2" class="py-3 text-gray-500">No data yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="bg-white p-5 rounded-lg shadow">
                <h3 class="font-semibold mb-3">Recent orders</h3>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-gray-500">
                            <th class="py-2">No</th>
                            <th class="py-2">Customer</th>
                            <th class="py-2">Table</th>
                            <th class="py-2">Total</th>
                            <th class="py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentOrders as $order)
                            <tr class="border-t">
                                <td class="py-2">#{{ $order->id }}</td>
                                <td class="py-2">{{ $order->name }}</td>
                                <td class="py-2">{{ $order->table_number }}</td>
                                <td class="py-2">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td class="py-2">{{ $order->status }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="py-3 text-gray-500">No orders yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>