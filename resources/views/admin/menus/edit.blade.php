<x-app-layout>
    <div class="mx-auto max-w-7xl px-6 py-12">

        <a href="{{ route('admin.menus.index') }}"
            class="text-sm font-medium text-terracotta transition hover:text-terracotta-dark">&larr; Back to menus</a>

        <section class="mb-8 mt-4">
            <h1 class="font-playfair mb-2 text-4xl font-extrabold italic sm:text-5xl">Edit Menu</h1>
            <p class="text-lg font-bold">Update the details of {{ $menu->name }}.</p>
        </section>

        <div class="max-w-2xl rounded-2xl border border-brown bg-sky p-6 shadow-lg">
            <form method="POST" action="{{ route('admin.menus.update', $menu) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('admin.menus._form')

                <div class="mt-6 flex items-center gap-3">
                    <button type="submit"
                            class="rounded-lg bg-brown px-5 py-2.5 text-sm font-semibold text-cream transition hover:bg-brown-dark active:scale-95">
                        Update
                    </button>
                    <a href="{{ route('admin.menus.index') }}"
                        class="rounded-lg border border-brown/40 px-5 py-2.5 text-sm font-semibold text-brown transition hover:bg-white/50">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>