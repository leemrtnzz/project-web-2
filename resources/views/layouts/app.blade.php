<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $attributes->get('title', config('app.name', 'KLIKIN')) }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=archivo-black:400|space-grotesk:400,500,600,700" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-paper font-sans text-ink antialiased">
        @include('layouts.navigation')

        @if (session('status') && ! request()->routeIs('profile.edit'))
            <div class="border-b-4 border-ink bg-pop-lime">
                <div class="mx-auto max-w-6xl px-4 py-3 text-sm font-bold sm:px-6 lg:px-8">
                    {{ session('status') }}
                </div>
            </div>
        @endif

        @isset($header)
            <header class="border-b-4 border-ink bg-pop-yellow">
                <div class="mx-auto max-w-6xl px-4 py-6 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main class="mx-auto w-full max-w-6xl px-4 py-8 sm:px-6 lg:px-8 lg:py-12">
            {{ $slot }}
        </main>
    </body>
</html>
