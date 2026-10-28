<x-app-layout>
    <div class="mx-auto max-w-7xl px-6 py-12"
        x-data="{ open: false, url: '', name: '' }"
        @keydown.escape.window="open = false">

        {{-- HERO --}}
        <section class="mb-10 flex flex-wrap items-end justify-between gap-4">
            <div>
                <h1 class="font-playfair mb-2 text-4xl font-extrabold italic sm:text-5xl lg:text-6xl">Menus</h1>
                <p class="text-lg font-bold sm:text-xl">Manage the dishes customers can order.</p>
            </div>

            <a href="{{ route('admin.menus.create') }}"
                class="rounded-lg bg-brown px-5 py-2.5 text-sm font-semibold text-cream transition hover:bg-brown-dark active:scale-95">
                + Add Menu
            </a>
        </section>

        {{-- FILTERS --}}
        @php
            $categoryOptions = collect([['value' => '', 'label' => 'All categories']])
                ->concat($categories->map(fn ($c) => ['value' => (string) $c->id, 'label' => $c->name]))
                ->values();

            $statusOptions = [
                ['value' => '', 'label' => 'All status'],
                ['value' => 'available', 'label' => 'Available'],
                ['value' => 'sold_out', 'label' => 'Sold out'],
            ];

            $sortOptions = [
                ['value' => 'name_asc', 'label' => 'Name (A to Z)'],
                ['value' => 'name_desc', 'label' => 'Name (Z to A)'],
                ['value' => 'price_asc', 'label' => 'Price (low to high)'],
                ['value' => 'price_desc', 'label' => 'Price (high to low)'],
                ['value' => 'newest', 'label' => 'Newest first'],
            ];

            $hasFilter = $search !== '' || $categoryId || $availability || $sort !== 'name_asc';
        @endphp

        <form method="GET" action="{{ route('admin.menus.index') }}"
            class="mb-6 rounded-2xl border border-brown bg-sky p-5 shadow-lg">

            <div class="mb-4">
                <label for="search" class="mb-2 block text-sm font-medium text-terracotta">Search menu</label>
                <div class="relative">
                    <svg class="pointer-events-none absolute left-4 top-1/2 size-5 -translate-y-1/2 text-brown/60"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="11" cy="11" r="7" /><path d="m21 21-4.3-4.3" />
                    </svg>
                    <input id="search" name="search" type="search" value="{{ $search }}" autocomplete="off"
                        placeholder="Example: Fried Rice..."
                        class="w-full rounded-xl border border-brown/30 bg-white py-3 pl-12 pr-4 outline-none transition focus:border-brown focus:ring-2 focus:ring-brown">
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-3">
                <div>
                    <label class="mb-2 block text-sm font-medium text-terracotta">Category</label>
                    <x-custom-select name="category" :options="$categoryOptions" :selected="$categoryId" />
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-terracotta">Status</label>
                    <x-custom-select name="status" :options="$statusOptions" :selected="$availability" />
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-terracotta">Sort by</label>
                    <x-custom-select name="sort" :options="$sortOptions" :selected="$sort" />
                </div>
            </div>

            <div class="mt-5 flex flex-wrap items-center gap-3">
                <button type="submit"
                        class="rounded-lg bg-brown px-5 py-2.5 text-sm font-semibold text-cream transition hover:bg-brown-dark active:scale-95">
                    Apply filters
                </button>

                @if ($hasFilter)
                    <a href="{{ route('admin.menus.index') }}"
                    class="rounded-lg border border-brown/40 px-5 py-2.5 text-sm font-semibold text-brown transition hover:bg-white/50">
                        Reset
                    </a>
                @endif
            </div>
        </form>

        @if ($hasFilter)
            <p class="mb-3 text-sm text-brown/80">
                Showing <span class="font-bold text-brown">{{ $menus->total() }}</span>
                of <span class="font-bold text-brown">{{ $total }}</span> menus
            </p>
        @endif

        {{-- TABLE --}}
        <section>
            <div class="overflow-hidden rounded-2xl border border-brown bg-sky shadow-lg">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-sky-dark/30 text-xs uppercase tracking-wide">
                            <tr>
                                <th class="px-5 py-3 font-semibold">No</th>
                                <th class="px-5 py-3 font-semibold">Photo</th>
                                <th class="px-5 py-3 font-semibold">Menu</th>
                                <th class="px-5 py-3 font-semibold">Category</th>
                                <th class="px-5 py-3 font-semibold">Price</th>
                                <th class="px-5 py-3 font-semibold">Status</th>
                                <th class="px-5 py-3 text-right font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($menus as $menu)
                                <tr class="border-t border-brown/20 transition hover:bg-white/50">
                                    <td class="px-5 py-4">{{ $menus->firstItem() + $loop->index }}</td>

                                    <td class="px-5 py-4">
                                        @if ($menu->image_url)
                                            <img src="{{ $menu->image_url }}" alt="{{ $menu->name }}"
                                                class="size-14 rounded-lg border border-brown/30 object-cover">
                                        @else
                                            <div class="flex size-14 items-center justify-center rounded-lg border border-brown/30 bg-white text-[10px] text-brown/60">
                                                No photo
                                            </div>
                                        @endif
                                    </td>

                                    <td class="whitespace-nowrap px-5 py-4">
                                        <p class="font-bold">{{ $menu->name }}</p>
                                        <p class="line-clamp-1 max-w-xs text-xs text-brown/70">{{ $menu->description }}</p>
                                    </td>

                                    <td class="whitespace-nowrap px-5 py-4">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-terracotta">
                                            {{ $menu->category->name }}
                                        </span>
                                    </td>

                                    <td class="px-5 py-4 font-bold text-terracotta">
                                        Rp{{ number_format($menu->price, 0, ',', '.') }}
                                    </td>

                                    <td class="px-5 py-4">
                                        @if ($menu->is_available)
                                            <span class="rounded-full border border-brown/30 bg-cream px-3 py-1 text-xs font-semibold">Available</span>
                                        @else
                                            <span class="rounded-full bg-terracotta px-3 py-1 text-xs font-semibold text-cream">Sold out</span>
                                        @endif

                                        <form method="POST" action="{{ route('admin.menus.toggle', $menu) }}" class="mt-2">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-xs font-medium text-brown/70 underline transition hover:text-terracotta">
                                                {{ $menu->is_available ? 'Mark sold out' : 'Mark available' }}
                                            </button>
                                        </form>
                                    </td>

                                    <td class="px-5 py-4">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.menus.edit', $menu) }}"
                                                class="rounded-lg border border-brown/40 px-3 py-1.5 text-xs font-semibold text-brown transition hover:bg-white/50">
                                                Edit
                                            </a>
                                            <button type="button"
                                                    @click="url = @js(route('admin.menus.destroy', $menu)); name = @js($menu->name); open = true"
                                                    class="rounded-lg border border-terracotta px-3 py-1.5 text-xs font-semibold text-terracotta transition hover:bg-terracotta hover:text-cream active:scale-95">
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-5 py-12 text-center text-brown/80">
                                        @if ($hasFilter)
                                            No menus match your filters.
                                            <a href="{{ route('admin.menus.index') }}" class="font-semibold text-terracotta underline">Reset filters</a>
                                        @else
                                            No menus yet. Click "Add Menu" to create the first one.
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6">{{ $menus->links() }}</div>
        </section>

        <x-delete-modal title="Delete Menu?" />
    </div>
</x-app-layout>