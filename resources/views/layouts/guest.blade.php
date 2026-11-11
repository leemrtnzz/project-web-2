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
        <div class="nb-grid-bg relative flex min-h-screen flex-col items-center justify-center overflow-hidden px-4 py-10">
            <div class="pointer-events-none absolute -left-10 top-16 hidden h-40 w-40 rotate-12 border-4 border-ink bg-pop-pink sm:block"></div>
            <div class="pointer-events-none absolute -right-8 bottom-16 hidden h-32 w-32 -rotate-6 border-4 border-ink bg-pop-cyan sm:block"></div>

            <div class="relative z-10 w-full max-w-md">
                <a href="{{ route('home') }}" class="mx-auto mb-6 flex w-fit">
                    <x-application-logo />
                </a>

                <div class="nb-card p-6 sm:p-8">
                    {{ $slot }}
                </div>

                <p class="mt-6 text-center text-xs font-bold uppercase tracking-widest text-ink/60">
                    Link affiliate, sat-set.
                </p>
            </div>
        </div>
    </body>
</html>
