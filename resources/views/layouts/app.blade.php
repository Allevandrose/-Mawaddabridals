<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" content="#1B2A4A">

        <title>{{ config('app.name', 'Mawaddabridals') }}</title>

        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;0,700;1,500;1,600&family=Jost:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Tailwind CDN & Config (Crucial for the custom colors to show) -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            ink: '#1B2A4A',
                            paper: '#FBF8F3',
                            navy: '#1B2A4A',
                            gold: '#C9A96E',
                            'gold-soft': '#E8D5B0',
                            blush: '#F3E7E0',
                            line: '#E9E1D6',
                            muted: '#8A8276',
                            rose: {
                                400: '#C08497',
                                500: '#A96F82',
                                600: '#935E70',
                            }
                        },
                        fontFamily: {
                            serif: ['"Cormorant Garamond"', 'ui-serif', 'Georgia', 'serif'],
                            sans: ['Jost', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        },
                        letterSpacing: { luxe: '0.18em' },
                    },
                },
            }
        </script>

        <style>
            html { -webkit-text-size-adjust: 100%; }
            body { font-family: 'Jost', sans-serif; background: #FBF8F3; -webkit-tap-highlight-color: transparent; }
            .font-serif { font-family: 'Cormorant Garamond', ui-serif, Georgia, serif; }
            .tracking-luxe { letter-spacing: 0.18em; }
        </style>
    </head>
    <body class="font-sans antialiased text-ink bg-paper">
        <div class="min-h-screen bg-paper">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white border-b border-line shadow-sm">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('scripts')
    </body>
</html>