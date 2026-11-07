<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#1B2A4A">
    <title>{{ config('app.name', 'Mawaddabridals') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;0,700;1,500;1,600&family=Jost:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

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
                        line: '#E9E1D6',
                        muted: '#8A8276',
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
        [x-cloak] { display: none !important; }
        html { -webkit-text-size-adjust: 100%; }
        body { font-family: 'Jost', sans-serif; background: #FBF8F3; -webkit-tap-highlight-color: transparent; }
        .font-display { font-family: 'Cormorant Garamond', ui-serif, Georgia, serif; }
        .tracking-luxe { letter-spacing: 0.18em; }

        input[type="text"], input[type="email"], input[type="password"] {
            outline: none !important;
        }
        input:focus-visible, button:focus-visible, a:focus-visible {
            outline: 2px solid #C9A96E; outline-offset: 2px;
        }

        /* Soft elegant page background */
        .page-bg {
            background-color: #FBF8F3;
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(201,169,110,0.06), transparent 30%),
                radial-gradient(circle at 90% 80%, rgba(27,42,74,0.04), transparent 30%);
        }

        /* Navy brand section background */
        .brand-panel {
            background-image:
                radial-gradient(120% 90% at 85% 10%, rgba(201,169,110,0.15) 0%, rgba(201,169,110,0) 55%),
                linear-gradient(135deg, #1B2A4A 0%, #2E3F63 100%);
        }
    </style>
</head>
<body class="text-ink page-bg antialiased min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8">

    <!-- 
      THE MASTER CARD
      - Max width is now 900px (was 1000px) to feel more contained.
      - Padding is smaller, heights are flexible, no fixed max-height that cuts off content.
    -->
    <div class="w-full max-w-[900px] bg-white rounded-3xl shadow-[0_15px_50px_-10px_rgba(27,42,74,0.15)] overflow-hidden grid lg:grid-cols-[1fr_1fr]">

        {{-- LEFT SIDE: Brand Content (Navy) --}}
        <aside class="hidden lg:flex relative brand-panel text-white flex-col justify-between p-8 xl:p-12 overflow-hidden">
            
            <i class="fas fa-cloud absolute top-0 right-0 text-[160px] text-white/[0.03] translate-x-1/4 -translate-y-1/4 pointer-events-none" aria-hidden="true"></i>
            <i class="fas fa-gem absolute bottom-0 left-0 text-[120px] text-gold/[0.05] -translate-x-1/4 translate-y-1/4 pointer-events-none" aria-hidden="true"></i>

            {{-- Top: Logo --}}
            <div class="relative z-10">
                <a href="{{ route('home') }}" aria-label="Mawaddabridals home">
                    <img src="{{ asset('images/mawaddabridals-logo.svg') }}" 
                         alt="Mawaddabridals" 
                         class="h-8 w-auto" 
                         style="filter: brightness(0) invert(1);">
                </a>
            </div>

            {{-- Middle: Headline & Stats --}}
            <div class="relative z-10 mt-8 mb-8">
                <p class="inline-flex items-center gap-2 text-gold text-[10px] uppercase tracking-luxe font-semibold mb-3">
                    <span class="h-px w-5 bg-gold"></span> The Mawadda Edit
                </p>
                <h1 class="font-display text-3xl xl:text-4xl font-semibold leading-[1.05] tracking-tight mb-3">
                    Every bride deserves<br>
                    a <span class="italic text-gold-soft">beautiful</span> beginning.
                </h1>
                <p class="text-white/60 text-[13px] leading-relaxed max-w-sm mb-6">
                    Sign in to track orders, save favourites, and book private bridal fittings with our stylists.
                </p>

                <div class="grid grid-cols-3 gap-2 border-t border-white/10 pt-5">
                    <div>
                        <p class="font-display text-lg font-semibold text-gold">2k+</p>
                        <p class="text-[9px] uppercase tracking-luxe text-white/40 mt-0.5">Brides served</p>
                    </div>
                    <div>
                        <p class="font-display text-lg font-semibold text-gold">Curated</p>
                        <p class="text-[9px] uppercase tracking-luxe text-white/40 mt-0.5">Bridal edits</p>
                    </div>
                    <div>
                        <p class="font-display text-lg font-semibold text-gold">Nationwide</p>
                        <p class="text-[9px] uppercase tracking-luxe text-white/40 mt-0.5">Delivery</p>
                    </div>
                </div>
            </div>

            {{-- Bottom: Footer --}}
            <div class="relative z-10 flex items-center justify-between text-[11px] text-white/40">
                <span>© {{ date('Y') }} Mawaddabridals</span>
                <a href="{{ route('home') }}" class="hover:text-gold transition-colors inline-flex items-center gap-1">
                    Back to shop <i class="fas fa-arrow-right text-[9px]"></i>
                </a>
            </div>
        </aside>

        {{-- RIGHT SIDE: The Form --}}
        <main class="flex flex-col justify-center p-6 sm:p-8 lg:p-10 relative">
            
            {{-- Mobile top logo --}}
            <div class="lg:hidden flex items-center justify-between mb-6 pb-4 border-b border-line">
                <a href="{{ route('home') }}" aria-label="Mawaddabridals home">
                    <img src="{{ asset('images/mawaddabridals-logo.svg') }}" alt="Mawaddabridals" class="h-8 w-auto">
                </a>
                <a href="{{ route('home') }}" class="text-[10px] uppercase tracking-luxe text-muted hover:text-gold transition-colors">
                    Back
                </a>
            </div>

            {{-- Slot Content (Login / Register Form) --}}
            <div class="w-full max-w-[320px] mx-auto">
                {{ $slot }}
            </div>
            
        </main>
    </div>

</body>
</html>