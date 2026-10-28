@props(['status'])

@php
    $styles = [
        'pending' => 'border-brown/30 bg-cream text-brown',
        'processing' => 'border-steel bg-white text-steel',
        'ready' => 'border-terracotta bg-terracotta/15 text-terracotta-dark',
        'completed' => 'border-green-300 bg-green-100 text-green-800',
        'cancelled' => 'border-red-300 bg-red-100 text-red-800',
    ];
@endphp

<span {{ $attributes->class(['inline-block rounded-full border px-3 py-1 text-xs font-semibold', $styles[$status] ?? 'border-brown/30 bg-cream text-brown']) }}>
    {{ \App\Models\Order::STATUSES[$status] ?? ucfirst($status) }}
</span>