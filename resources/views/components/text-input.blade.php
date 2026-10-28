@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'rounded-xl border border-brown/30 bg-white px-4 py-3 outline-none transition focus:border-brown focus:ring-2 focus:ring-brown']) }}>