<x-app-layout>
    @php $menus = $category->menus()->orderBy('name')->get(); @endphp

    <div class="mx-auto max-w-7xl px-6 py-12">

        <a href="{{ route('admin.categories.index') }}"
            class="text-sm font-medium text-terracotta transition hover:text-terracotta-dark">&larr; Back to categories</a>

        <section class="mb-8 mt-4">
            <h1 class="font-playfair mb-2 text-4xl font-extrabold italic sm:text-5xl">EDIT CATEGORY</h1>
            <p class="text-lg font-bold">The new name applies to every menu in this category.</p>
        </section>

        <div class="grid items-start gap-6 lg:grid-cols-3">

            {{-- FORM --}}
            <div class="rounded-2xl border border-brown bg-sky p-6 shadow-lg lg:col-span-2">
                <form method="POST" action="{{ route('admin.categories.update', $category) }}">
                    @csrf
                    @method('PUT')
                    @include('admin.categories._form')

                    <div class="mt-6 flex items-center gap-3">
                        <button type="submit"
                                class="rounded-lg bg-brown px-5 py-2.5 text-sm font-semibold text-cream transition hover:bg-brown-dark active:scale-95">
                            Update
                        </button>
                        <a href="{{ route('admin.categories.index') }}"
                            class="rounded-lg border border-brown/40 px-5 py-2.5 text-sm font-semibold text-brown transition hover:bg-white/50">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>

            {{-- MENUS IN THIS CATEGORY --}}
            <div class="rounded-2xl border border-brown bg-sky p-6 shadow-lg">
                <h2 class="text-sm font-bold uppercase tracking-wide text-terracotta">Menus in this category</h2>
                <p class="mb-4 mt-1 text-xs text-brown/70">
                    {{ $menus->count() }} {{ Str::plural('menu', $menus->count()) }}
                </p>

                @if ($menus->isEmpty())
                    <p class="text-sm text-brown/80">No menus yet. This category can be deleted.</p>
                @else
                    <ul class="max-h-64 overflow-y-auto">
                        @foreach ($menus as $menu)
                            <li class="flex items-center justify-between gap-3 border-t border-brown/20 py-2 text-sm first:border-t-0">
                                <span class="font-medium">{{ $menu->name }}</span>
                                @unless ($menu->is_available)
                                    <span class="shrink-0 rounded-full bg-terracotta px-2 py-0.5 text-[10px] font-semibold text-cream">Sold out</span>
                                @endunless
                            </li>
                        @endforeach
                    </ul>
                    <p class="mt-4 border-t border-brown/20 pt-3 text-xs text-brown/70">
                        A category that still has menus cannot be deleted.
                    </p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>