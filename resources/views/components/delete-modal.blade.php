@props(['title' => 'DELETE?'])

<div x-show="open" x-transition.opacity style="display: none;"
    class="fixed inset-0 z-50 flex items-center justify-center px-4"
    role="dialog" aria-modal="true">

    <div class="absolute inset-0 bg-brown-dark/60" @click="open = false"></div>

    <div x-show="open" x-transition
        class="relative w-full max-w-md rounded-2xl border border-brown bg-sky p-6 shadow-xl">
        <h2 class="font-playfair text-3xl font-extrabold italic">{{ $title }}</h2>

        <p class="mt-3 text-sm text-brown/80">
            Are you sure you want to delete
            <span class="font-bold text-brown" x-text="name"></span>?
            This action cannot be undone.
        </p>

        <form method="POST" :action="url" class="mt-6 flex justify-end gap-3">
            @csrf
            @method('DELETE')

            <button type="button" @click="open = false"
                    class="rounded-lg border border-brown/40 px-5 py-2.5 text-sm font-semibold text-brown transition hover:bg-white/50">
                Cancel
            </button>
            <button type="submit"
                    class="rounded-lg bg-terracotta px-5 py-2.5 text-sm font-semibold text-cream transition hover:bg-terracotta-dark active:scale-95">
                Yes, delete
            </button>
        </form>
    </div>
</div>