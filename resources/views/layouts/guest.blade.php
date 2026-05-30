<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col bg-gray-50">
            <!-- Header minimal (opsional, bisa dihapus) -->
            <div class="w-full bg-white shadow-sm py-3 px-6 flex justify-center">
                <a href="/">
                    <x-application-logo class="h-8 w-auto fill-current text-gray-500" />
                </a>
            </div>

            <!-- Konten utama tanpa batasan lebar -->
            <div class="flex-1 w-full">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>