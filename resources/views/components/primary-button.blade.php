<button {{ $attributes->merge(['type' => 'submit', 'class' => 'rounded-lg bg-brown px-4 py-2 text-sm font-semibold text-cream transition hover:bg-brown-dark active:scale-95 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brown']) }}>
    {{ $slot }}
</button>