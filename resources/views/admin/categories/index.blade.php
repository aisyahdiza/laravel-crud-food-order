<x-app-layout>
    <div class="mx-auto max-w-7xl px-6 py-12"
        x-data="{ open: false, url: '', name: '' }"
        @keydown.escape.window="open = false">

        {{-- HERO --}}
        <section class="mb-10 flex flex-wrap items-end justify-between gap-4">
            <div>
                <h1 class="font-playfair mb-2 text-4xl font-extrabold italic sm:text-5xl lg:text-6xl">Categories</h1>
                <p class="text-lg font-bold sm:text-xl">Organize your menu into groups.</p>
            </div>

            <a href="{{ route('admin.categories.create') }}"
                class="rounded-lg bg-brown px-5 py-2.5 text-sm font-semibold text-cream transition hover:bg-brown-dark active:scale-95 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brown">
                + Add Category
            </a>
        </section>

        {{-- TABLE --}}
        <section>
            <div class="overflow-hidden rounded-2xl border border-brown bg-sky shadow-lg">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-sky-dark/30 text-xs uppercase tracking-wide">
                            <tr>
                                <th class="px-5 py-3 font-semibold">No</th>
                                <th class="px-5 py-3 font-semibold">Category</th>
                                <th class="px-5 py-3 font-semibold">Menus</th>
                                <th class="px-5 py-3 text-right font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $category)
                                <tr class="border-t border-brown/20 transition hover:bg-white/50">
                                    <td class="px-5 py-4">{{ $categories->firstItem() + $loop->index }}</td>
                                    <td class="px-5 py-4 font-bold">{{ $category->name }}</td>
                                    <td class="px-5 py-4">
                                        <span class="rounded-full border border-brown/30 bg-cream px-3 py-1 text-xs font-semibold">
                                            {{ $category->menus_count }} {{ Str::plural('menu', $category->menus_count) }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.categories.edit', $category) }}"
                                                class="rounded-lg border border-brown/40 px-3 py-1.5 text-xs font-semibold text-brown transition hover:bg-white/50">
                                                Edit
                                            </a>
                                            <button type="button"
                                                    @click="url = @js(route('admin.categories.destroy', $category)); name = @js($category->name); open = true"
                                                    class="rounded-lg border border-terracotta px-3 py-1.5 text-xs font-semibold text-terracotta transition hover:bg-terracotta hover:text-cream active:scale-95">
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-5 py-12 text-center text-brown/80">
                                        No categories yet. Click "Add Category" to create the first one.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6">{{ $categories->links() }}</div>
        </section>

        <x-delete-modal title="Delete Category?" />
    </div>
</x-app-layout>