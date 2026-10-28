<x-app-layout>
    <div class="mx-auto max-w-7xl px-6 py-12">

        <a href="{{ route('admin.categories.index') }}"
            class="text-sm font-medium text-terracotta transition hover:text-terracotta-dark">&larr; Back to categories</a>

        <section class="mb-8 mt-4">
            <h1 class="font-playfair mb-2 text-4xl font-extrabold italic sm:text-5xl">New Category</h1>
            <p class="text-lg font-bold">Group your menu so customers can find it easily.</p>
        </section>

        <div class="grid items-start gap-6 lg:grid-cols-3">

            {{-- FORM --}}
            <div class="rounded-2xl border border-brown bg-sky p-6 shadow-lg lg:col-span-2">
                <form method="POST" action="{{ route('admin.categories.store') }}">
                    @csrf
                    @include('admin.categories._form')

                    <div class="mt-6 flex items-center gap-3">
                        <button type="submit"
                                class="rounded-lg bg-brown px-5 py-2.5 text-sm font-semibold text-cream transition hover:bg-brown-dark active:scale-95">
                            Save
                        </button>
                        <a href="{{ route('admin.categories.index') }}"
                            class="rounded-lg border border-brown/40 px-5 py-2.5 text-sm font-semibold text-brown transition hover:bg-white/50">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>

            {{-- TIPS --}}
            <div class="rounded-2xl border border-brown bg-sky p-6 shadow-lg">
                <h2 class="mb-3 text-sm font-bold uppercase tracking-wide text-terracotta">Tips</h2>
                <ul class="list-disc space-y-2 pl-5 text-sm text-brown/80">
                    <li>Use a short, clear name such as Main Course or Beverage.</li>
                    <li>Each category name must be unique.</li>
                    <li>Menus are assigned to a category on the Menu page.</li>
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>