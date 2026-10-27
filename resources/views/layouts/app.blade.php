<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Duduk Dulu') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-brown antialiased">
        <div class="min-h-screen bg-cream/40">
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-white border-b border-brown/10">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main>
                @if (session('success'))
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
                        <div class="bg-green-100 text-green-800 px-4 py-3 rounded">{{ session('success') }}</div>
                    </div>
                @endif
                @if (session('error'))
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
                        <div class="bg-red-100 text-red-800 px-4 py-3 rounded">{{ session('error') }}</div>
                    </div>
                @endif
                {{ $slot }}
            </main>
            <footer class="text-center text-sm text-gray-500 py-6">
                &copy; {{ date('Y') }} Duduk Dulu
            </footer>
        </div>
    </body>
</html>