@php
    $cartCount = auth()->check() ? auth()->user()->cartCount() : 0;
    $flashCart = session('cart_added');
    $flashSuccess = session('success');
    // Safe fallback so the page never errors if the controller doesn't pass these.
    $bestsellers = $bestsellers ?? collect();
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#1B2A4A">
    <title>{{ config('app.name', 'Mawaddabridals') }} · Bridal, Fashion & Fragrance</title>

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
                        ink: '#1B2A4A', paper: '#FBF8F3', navy: '#1B2A4A', gold: '#C9A96E',
                        'gold-soft': '#E8D5B0', blush: '#F3E7E0', line: '#E9E1D6', muted: '#8A8276',
                    },
                    fontFamily: {
                        serif: ['"Cormorant Garamond"', 'ui-serif', 'Georgia', 'serif'],
                        sans: ['Jost', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                    borderRadius: { xl2: '20px', '3xl': '30px' },
                    letterSpacing: { luxe: '0.18em' },
                },
            },
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>

    @stack('styles')

    <style>
        [x-cloak] { display: none !important; }
        html { scroll-behavior: smooth; -webkit-text-size-adjust: 100%; }
        body { font-family: 'Jost', sans-serif; background: #FBF8F3; -webkit-tap-highlight-color: transparent; }

        /* Custom Scrollbar for Desktop */
        .main-scroll-area::-webkit-scrollbar { width: 6px; }
        .main-scroll-area::-webkit-scrollbar-track { background: transparent; }
        .main-scroll-area::-webkit-scrollbar-thumb { background: #E9E1D6; border-radius: 10px; }
        .main-scroll-area::-webkit-scrollbar-thumb:hover { background: #C9A96E; }

        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { scrollbar-width: none; -ms-overflow-style: none; }

        header a:focus-visible, header button:focus-visible, #mobile-drawer a:focus-visible, #mobile-drawer button:focus-visible,
        aside a:focus-visible, main a:focus-visible, main button:focus-visible, nav a:focus-visible, nav button:focus-visible {
            outline: 2px solid #C9A96E; outline-offset: 2px;
        }

        input[type="text"], input[type="email"], input[type="search"] { outline: none !important; box-shadow: none !important; }

        /* Design additions */
        .font-display { font-family: 'Cormorant Garamond', ui-serif, Georgia, serif; }
        .hero-grain {
            background-image:
                radial-gradient(120% 90% at 85% 10%, rgba(201,169,110,0.22) 0%, rgba(201,169,110,0) 55%),
                radial-gradient(90% 80% at 0% 100%, rgba(46,63,99,0.9) 0%, rgba(27,42,74,0) 70%);
        }
        .gold-rule { height: 1px; background: linear-gradient(90deg, #C9A96E 0%, rgba(201,169,110,0) 100%); }
        .arch { border-radius: 9999px 9999px 28px 28px; }
        .arch-ring { border-radius: 9999px 9999px 36px 36px; }
        /* On phones the arch bleeds off the bottom edge of the hero */
        @media (max-width: 1023px) { .arch-bleed { border-radius: 9999px 9999px 0 0; } }
        .link-underline { background-image: linear-gradient(#C9A96E, #C9A96E); background-size: 100% 1px; background-position: 0 100%; background-repeat: no-repeat; transition: background-size .25s; }
        .link-underline:hover { background-size: 0% 1px; background-position: 100% 100%; }
        /* Hover lift only on devices that can hover (avoids "stuck" hover on touch) */
        .lift { border-radius: 1rem; transition: transform .3s, box-shadow .3s; }
        @media (hover: hover) { .lift:hover { transform: translateY(-6px); box-shadow: 0 24px 40px -24px rgba(27,42,74,0.45); } }
        .press:active { transform: scale(0.96); }
        @media (prefers-reduced-motion: reduce) {
            html { scroll-behavior: auto; }
            * { animation-duration: 0.01ms !important; transition-duration: 0.01ms !important; }
        }

        /* SweetAlert2 Styles (kept exactly) */
        .swal2-container.vk-container { padding: 1rem; background: rgba(27, 42, 74, 0.45) !important; backdrop-filter: blur(5px); -webkit-backdrop-filter: blur(5px); }
        .swal2-popup.vk-popup { width: 100%; max-width: 380px; padding: 0; overflow: hidden; border-radius: 24px; background: #FBF8F3; color: #1B2A4A; font-family: 'Jost', sans-serif; box-shadow: 0 0 0 1px #E9E1D6, 0 34px 70px -24px rgba(27, 42, 74, 0.55); }
        .swal2-popup.vk-popup .swal2-html-container { margin: 0; padding: 0; overflow: visible; text-align: left; color: inherit; }
        .vk-head { position: relative; overflow: hidden; padding: 30px 24px 26px; text-align: center; color: #fff; background-image: linear-gradient(135deg, #1B2A4A 0%, #2E3F63 100%); }
        .vk-head-bag { position: absolute; right: -10px; bottom: -18px; font-size: 7.5rem; color: rgba(255, 255, 255, 0.06); transform: rotate(-8deg); pointer-events: none; }
        .vk-badge { position: relative; z-index: 1; display: flex; align-items: center; justify-content: center; width: 68px; height: 68px; margin: 0 auto 14px; border-radius: 9999px; background: #FBF8F3; box-shadow: 0 0 0 6px rgba(201, 169, 110, 0.3), 0 14px 28px -10px rgba(0, 0, 0, 0.5); animation: vk-badge-pop 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) 0.1s both; }
        .vk-badge::after { content: ""; position: absolute; inset: -6px; border-radius: 9999px; border: 2px solid #C9A96E; opacity: 0; animation: vk-ring 0.9s ease-out 0.35s 1; }
        .vk-check { width: 34px; height: 34px; }
        .vk-check path { fill: none; stroke: #C9A96E; stroke-width: 4.5; stroke-linecap: round; stroke-linejoin: round; stroke-dasharray: 44; stroke-dashoffset: 44; animation: vk-draw 0.45s ease-out 0.3s forwards; }
        .vk-title { position: relative; z-index: 1; margin: 0; font-family: 'Cormorant Garamond', ui-serif, Georgia, serif; font-size: 26px; font-weight: 600; letter-spacing: 0.01em; line-height: 1.1; }
        .vk-sub { position: relative; z-index: 1; margin: 6px 0 0; font-size: 13.5px; color: rgba(255, 255, 255, 0.75); }
        .vk-body { padding: 18px 20px 6px; }
        .vk-item { display: flex; align-items: center; gap: 12px; padding: 10px; border-radius: 16px; background: #fff; border: 1px solid #E9E1D6; }
        .vk-thumb { flex-shrink: 0; display: flex; align-items: center; justify-content: center; width: 56px; height: 56px; overflow: hidden; border-radius: 12px; background: #FBF8F3; border: 1px solid #E9E1D6; color: #C9A96E; }
        .vk-thumb img { width: 100%; height: 100%; object-fit: cover; }
        .vk-item-info { min-width: 0; flex: 1; }
        .vk-item-name { margin: 0; font-size: 14px; font-weight: 600; line-height: 1.3; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .vk-item-meta { margin: 3px 0 0; font-size: 12.5px; color: #8A8276; }
        .vk-item-meta strong { color: #1B2A4A; font-weight: 700; }
        .vk-count { display: flex; align-items: center; justify-content: center; gap: 8px; margin: 14px 0 0; font-size: 12.5px; color: #8A8276; }
        .vk-count i { color: #C9A96E; }
        .vk-msg { margin: 0; padding: 6px 4px 2px; text-align: center; font-size: 14px; line-height: 1.5; color: rgba(27, 42, 74, 0.75); }
        .swal2-popup.vk-popup .swal2-actions.vk-actions { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; width: 100%; margin: 0; padding: 16px 20px 20px; }
        .swal2-popup.vk-popup .swal2-actions.vk-actions.vk-single { grid-template-columns: 1fr; }
        .swal2-popup.vk-popup .vk-btn { margin: 0; padding: 12px 14px; border-radius: 9999px; font-family: 'Jost', sans-serif; font-size: 14px; font-weight: 600; letter-spacing: 0.03em; cursor: pointer; transition: background-color 0.15s, transform 0.1s, box-shadow 0.15s; }
        .swal2-popup.vk-popup .vk-btn:active { transform: scale(0.97); }
        .swal2-popup.vk-popup .vk-btn:focus-visible { outline: 2px solid #C9A96E; outline-offset: 2px; box-shadow: none; }
        .swal2-popup.vk-popup .vk-confirm { order: 2; border: 0; background: #C9A96E; color: #1B2A4A; box-shadow: 0 10px 24px -8px rgba(201, 169, 110, 0.7); }
        .swal2-popup.vk-popup .vk-confirm:hover { background: rgba(201, 169, 110, 0.9); }
        .swal2-popup.vk-popup .vk-cancel { order: 1; background: #fff; color: #1B2A4A; border: 1px solid #E9E1D6; }
        .swal2-popup.vk-popup .vk-cancel:hover { background: #FBF8F3; }
        .swal2-popup.vk-popup .swal2-timer-progress-bar-container { top: auto; bottom: 0; height: 4px; background: transparent; border-radius: 0; }
        .swal2-popup.vk-popup .swal2-timer-progress-bar { background: #C9A96E; }
        .swal2-popup.vk-popup.vk-in { animation: vk-in 0.32s cubic-bezier(0.22, 1, 0.36, 1); }
        .swal2-popup.vk-popup.vk-out { animation: vk-out 0.2s ease-in forwards; }
        @keyframes vk-in { from { opacity: 0; transform: translateY(18px) scale(0.96); } to { opacity: 1; transform: none; } }
        @keyframes vk-out { to { opacity: 0; transform: translateY(10px) scale(0.97); } }
        @keyframes vk-badge-pop { from { opacity: 0; transform: scale(0.5); } to { opacity: 1; transform: scale(1); } }
        @keyframes vk-ring { 0% { opacity: 0.8; transform: scale(1); } 100% { opacity: 0; transform: scale(1.55); } }
        @keyframes vk-draw { to { stroke-dashoffset: 0; } }
        @media (max-width: 380px) {
            .swal2-popup.vk-popup .swal2-actions.vk-actions { grid-template-columns: 1fr; }
            .swal2-popup.vk-popup .vk-confirm { order: 1; }
            .swal2-popup.vk-popup .vk-cancel { order: 2; }
        }
    </style>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('cart', { count: {{ (int) $cartCount }} });

            // Wishlist store fallback (the layout references $store.wishlist)
            if (!Alpine.store('wishlist')) {
                Alpine.store('wishlist', { count: 0 });
            }

            Alpine.data('carousel', () => ({
                current: 0, total: 3, touchX: 0, timer: null,
                start() { this.stop(); this.timer = setInterval(() => this.next(), 5500); },
                stop() { clearInterval(this.timer); },
                next() { this.current = (this.current + 1) % this.total; },
                prev() { this.current = (this.current - 1 + this.total) % this.total; },
                goTo(i) { this.current = i; this.start(); },
                onTouchStart(e) { this.touchX = e.touches[0].clientX; },
                onTouchEnd(e) {
                    const dx = e.changedTouches[0].clientX - this.touchX;
                    if (Math.abs(dx) > 40) { dx < 0 ? this.next() : this.prev(); this.start(); }
                },
            }));
        });

        (function () {
            const CART_URL = @json(route('cart.index'));
            const esc = (v) => String(v ?? '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' } [c]));
            const money = (p) => {
                if (p === null || p === undefined || p === '') return '';
                const n = Number(String(p).replace(/[^0-9.]/g, ''));
                return isNaN(n) || String(p).match(/[a-z]/i) ? esc(p) : 'KSh ' + n.toLocaleString('en-KE');
            };

            window.vukaCartAdded = function (opts = {}) {
                if (typeof Swal === 'undefined') return;
                const { title = 'Added to cart', name = '', image = '', price = null, quantity = 1, count = null, message = '', showCartButton = true } = opts;
                const total = count !== null && count !== '' ? Number(count) : null;
                if (total !== null && !isNaN(total) && window.Alpine && Alpine.store('cart')) Alpine.store('cart').count = total;
                const thumb = image ? `<img src="${esc(image)}" alt="" loading="lazy">` : `<i class="fas fa-shopping-bag"></i>`;
                const priceText = money(price);
                const meta = [quantity ? `Qty <strong>${esc(quantity)}</strong>` : '', priceText ? `<strong>${priceText}</strong>` : ''].filter(Boolean).join(' &nbsp;·&nbsp; ');
                const itemBlock = name ? `<div class="vk-item"><div class="vk-thumb">${thumb}</div><div class="vk-item-info"><p class="vk-item-name">${esc(name)}</p>${meta ? `<p class="vk-item-meta">${meta}</p>` : ''}</div></div>` : '';
                const countBlock = total !== null && !isNaN(total) && total > 0 ? `<p class="vk-count"><i class="fas fa-shopping-bag"></i> Your bag has ${total} ${total === 1 ? 'item' : 'items'}</p>` : '';
                const sub = name ? 'It’s waiting in your bag.' : esc(message);

                return Swal.fire({
                    html: `
                        <div class="vk-head"><i class="fas fa-gem vk-head-bag" aria-hidden="true"></i><div class="vk-badge"><svg class="vk-check" viewBox="0 0 52 52" aria-hidden="true"><path d="M14 27l8.5 8.5L38 18"/></svg></div><h2 class="vk-title">${esc(title)}</h2>${sub ? `<p class="vk-sub">${sub}</p>` : ''}</div>
                        ${(itemBlock || countBlock) ? `<div class="vk-body">${itemBlock}${countBlock}</div>` : ''}
                    `,
                    showConfirmButton: true, showCancelButton: showCartButton, confirmButtonText: showCartButton ? 'View bag' : 'Got it', cancelButtonText: 'Keep shopping', buttonsStyling: false, reverseButtons: false, focusConfirm: false, returnFocus: false, timer: 5000, timerProgressBar: true, width: 380, padding: 0, background: '#FBF8F3',
                    customClass: { container: 'vk-container', popup: 'vk-popup', actions: 'vk-actions' + (showCartButton ? '' : ' vk-single'), confirmButton: 'vk-btn vk-confirm', cancelButton: 'vk-btn vk-cancel' },
                    showClass: { popup: 'vk-in' }, hideClass: { popup: 'vk-out' },
                    didOpen: (popup) => { popup.addEventListener('mouseenter', Swal.stopTimer); popup.addEventListener('mouseleave', Swal.resumeTimer); },
                }).then((result) => { if (result.isConfirmed && showCartButton) window.location.href = CART_URL; });
            };

            window.vukaSuccess = function (message = '', title = 'Success') { return window.vukaCartAdded({ title, message, showCartButton: false }); };

            if (typeof Swal !== 'undefined' && !Swal.__vukaPatched) {
                const nativeFire = Swal.fire.bind(Swal);
                Swal.fire = function (...args) {
                    const o = args[0];
                    if (typeof o === 'string' && args[2] === 'success') { return window.vukaSuccess(args[1] || '', o); }
                    if (o && typeof o === 'object' && o.icon === 'success' && !o.customClass && !o.html) { return window.vukaSuccess(o.text || '', o.title || 'Success'); }
                    return nativeFire(...args);
                };
                Swal.__vukaPatched = true;
            }

            window.addEventListener('cart:added', (e) => window.vukaCartAdded(e.detail || {}));

            @if ($flashCart || $flashSuccess)
                document.addEventListener('DOMContentLoaded', () => {
                    @if ($flashCart)
                        window.vukaCartAdded(@json(is_array($flashCart) ? $flashCart : ['name' => (string) $flashCart]));
                    @else
                        window.vukaCartAdded({ title: 'Success', message: @json((string) $flashSuccess), showCartButton: false });
                    @endif
                });
            @endif
        })();
    </script>
</head>

<body class="text-ink bg-paper antialiased" x-data="{ mobileSearchOpen: false, menuOpen: false, scrolled: false }"
    x-effect="document.body.classList.toggle('overflow-hidden', menuOpen || mobileSearchOpen)"
    @scroll.window.passive="scrolled = window.scrollY > 8"
    @resize.window="if (window.innerWidth >= 1024) { menuOpen = false; mobileSearchOpen = false }"
    @keydown.escape.window="menuOpen = false; mobileSearchOpen = false">

    <!-- Announcement Bar -->
    <div x-data="{ show: true }" x-show="show" x-cloak class="bg-navy text-white text-xs sm:text-[13px] relative z-50">
        <div class="max-w-[1600px] mx-auto pl-4 pr-12 py-2 flex items-center justify-center gap-2.5 relative min-h-[36px]">
            <i class="fas fa-gem text-gold text-[11px] shrink-0"></i>
            <p class="text-center font-light tracking-wide">
                <span class="sm:hidden">Free delivery over KSh 10,000</span>
                <span class="hidden sm:inline">Complimentary delivery on orders over KSh 10,000. Bridal fittings by appointment.</span>
            </p>
            <button @click="show = false" aria-label="Dismiss announcement" class="absolute right-1 top-1/2 -translate-y-1/2 h-9 w-9 rounded-full flex items-center justify-center text-white/70 hover:text-white hover:bg-white/10 transition-colors">
                <i class="fas fa-times text-[11px]"></i>
            </button>
        </div>
    </div>

    <!-- Layout wrapper: page scrolls normally on phones; split scroll panes on desktop -->
    <div class="max-w-[1600px] mx-auto flex lg:h-[calc(100dvh-36px)] lg:overflow-hidden">

        <!-- LEFT SIDEBAR (desktop only) -->
        <aside class="hidden lg:flex w-72 xl:w-80 shrink-0 bg-white border-r border-line flex-col h-full z-40">
            <div class="h-24 flex items-center px-9 shrink-0">
                <a href="{{ route('home') }}" aria-label="Mawaddabridals home">
                    <img src="{{ asset('images/mawaddabridals-logo.svg') }}" alt="Mawaddabridals" class="h-11 w-auto">
                </a>
            </div>
            <div class="mx-9 gold-rule"></div>

            <div class="flex-1 overflow-y-auto no-scrollbar py-7 px-5 space-y-9">
                <nav class="space-y-1.5" aria-label="Primary">
                    <a href="#" class="group flex items-center gap-3.5 pl-3 pr-4 py-2.5 rounded-full text-[15px] font-medium bg-navy text-white shadow-[0_14px_28px_-14px_rgba(27,42,74,0.7)] transition-all">
                        <span class="h-9 w-9 rounded-full bg-white/10 flex items-center justify-center text-gold"><i class="fas fa-gem text-sm"></i></span> Bridal Collection
                    </a>
                    <a href="#" class="group flex items-center gap-3.5 pl-3 pr-4 py-2.5 rounded-full text-[15px] font-medium text-ink/75 hover:bg-paper hover:text-ink transition-colors">
                        <span class="h-9 w-9 rounded-full bg-paper border border-line flex items-center justify-center text-gold group-hover:bg-white transition-colors"><i class="fas fa-wand-magic-sparkles text-sm"></i></span> New In
                    </a>
                    <a href="#" class="group flex items-center gap-3.5 pl-3 pr-4 py-2.5 rounded-full text-[15px] font-medium text-ink/75 hover:bg-paper hover:text-ink transition-colors">
                        <span class="h-9 w-9 rounded-full bg-paper border border-line flex items-center justify-center text-gold group-hover:bg-white transition-colors"><i class="fas fa-spray-can-sparkles text-sm"></i></span> Fragrance
                    </a>
                    <a href="#" class="group flex items-center gap-3.5 pl-3 pr-4 py-2.5 rounded-full text-[15px] font-medium text-ink/75 hover:bg-paper hover:text-ink transition-colors">
                        <span class="h-9 w-9 rounded-full bg-paper border border-line flex items-center justify-center text-gold group-hover:bg-white transition-colors"><i class="fas fa-headset text-sm"></i></span> Support
                    </a>
                </nav>

                @if ($categories->isNotEmpty())
                    <div>
                        <h4 class="px-3 font-display text-xl font-semibold text-ink mb-3">Categories</h4>
                        <div class="space-y-0.5">
                            @foreach ($categories as $category)
                                <a href="{{ route('category.show', $category->slug) }}" class="group flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium text-ink/70 hover:bg-paper hover:text-ink transition-colors">
                                    <span class="h-8 w-8 rounded-full bg-blush/60 flex items-center justify-center shrink-0 group-hover:bg-blush transition-colors">
                                        @if ($category->icon) <i class="fas {{ $category->icon }} text-[11px] text-gold"></i> @else <i class="fas fa-tag text-[11px] text-gold"></i> @endif
                                    </span> {{ $category->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="p-5 shrink-0">
                <div class="rounded-3xl bg-paper border border-line p-4 space-y-3">
                    <div class="grid grid-cols-2 gap-2">
                        <a href="{{ route('wishlist.index') }}" class="flex items-center justify-center gap-2 py-2.5 rounded-full bg-white border border-line text-sm font-medium text-ink/75 hover:text-rose-500 hover:border-rose-200 transition-colors">
                            <i class="far fa-heart"></i> Wishlist
                            <span x-show="$store.wishlist.count > 0" x-text="$store.wishlist.count" class="bg-rose-400 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full"></span>
                        </a>
                        <a href="{{ route('cart.index') }}" class="flex items-center justify-center gap-2 py-2.5 rounded-full bg-white border border-line text-sm font-medium text-ink/75 hover:text-ink hover:border-gold transition-colors">
                            <i class="fas fa-shopping-bag"></i> Bag
                            <span x-show="$store.cart.count > 0" x-text="$store.cart.count" class="bg-gold text-ink text-[10px] font-bold px-1.5 py-0.5 rounded-full"></span>
                        </a>
                    </div>
                    @auth
                        <a href="{{ route('dashboard') }}" class="flex items-center justify-center gap-2 w-full py-3 rounded-full bg-navy text-white text-sm font-semibold hover:bg-navy/90 transition-colors">
                            <i class="fas fa-user-circle text-gold text-base"></i> My Account
                        </a>
                    @else
                        <div class="grid grid-cols-2 gap-2">
                            <a href="{{ route('login') }}" class="flex items-center justify-center py-2.5 rounded-full bg-white border border-line text-sm font-semibold hover:bg-white/60 transition-colors">Log in</a>
                            <a href="{{ route('register') }}" class="flex items-center justify-center py-2.5 rounded-full bg-navy text-white text-sm font-semibold hover:bg-navy/90 transition-colors">Register</a>
                        </div>
                    @endauth
                </div>
            </div>
        </aside>

        <!-- RIGHT MAIN CONTENT AREA -->
        <!-- Bottom padding clears the floating nav (and the cart bar when the bag has items) on phones -->
        <main class="flex-1 min-w-0 flex flex-col h-full lg:overflow-y-auto main-scroll-area relative bg-paper lg:pb-0"
            :class="$store.cart.count > 0 ? 'pb-44' : 'pb-32'"
            @scroll.passive="scrolled = $el.scrollTop > 8">

            <!-- Sticky Header -->
            <header class="sticky top-0 z-30 bg-paper/90 backdrop-blur-md transition-shadow duration-200 px-4 sm:px-8 h-16 lg:h-20 flex items-center justify-between gap-3 shrink-0 border-b"
                :class="scrolled ? 'shadow-[0_8px_24px_-16px_rgba(27,42,74,0.35)] border-line' : 'border-transparent'">

                <!-- Mobile: menu + logo -->
                <div class="flex items-center gap-2.5 lg:hidden min-w-0">
                    <button @click="menuOpen = true" class="press h-11 w-11 shrink-0 rounded-full bg-white border border-line flex items-center justify-center text-ink shadow-sm" aria-label="Open menu">
                        <i class="fas fa-bars text-sm"></i>
                    </button>
                    <a href="{{ route('home') }}" aria-label="Mawaddabridals home" class="min-w-0">
                        <img src="{{ asset('images/mawaddabridals-logo.svg') }}" alt="Mawaddabridals" class="h-8 w-auto max-w-full">
                    </a>
                </div>

                <!-- Search Bar (Desktop) -->
                <form action="{{ route('search') }}" method="GET" role="search" x-data="{ q: '', focused: false }"
                    class="hidden lg:flex flex-1 max-w-xl items-center gap-2 rounded-full pl-5 pr-1.5 h-12 border transition-all duration-200"
                    :class="focused ? 'bg-white border-gold shadow-[0_12px_32px_-12px_rgba(201,169,110,0.55)]' : 'bg-white/70 border-line hover:border-gold-soft'">
                    <i class="fas fa-search text-xs text-muted"></i>
                    <input x-model="q" @focus="focused = true" @blur="focused = false" type="text" name="q" placeholder="Search dresses, fragrances, shoes…" autocomplete="off" class="bg-transparent border-0 outline-none ring-0 w-full text-sm placeholder:text-muted/70">
                    <button type="submit" class="h-9 px-5 shrink-0 rounded-full bg-navy text-white text-sm font-medium flex items-center justify-center hover:bg-navy/90 transition-colors">Search</button>
                </form>

                <!-- Mobile: search + wishlist (bag lives in the bottom nav) -->
                <div class="lg:hidden flex items-center gap-2 shrink-0">
                    <button @click="mobileSearchOpen = true" class="press h-11 w-11 rounded-full bg-white border border-line flex items-center justify-center text-ink shadow-sm" aria-label="Search"><i class="fas fa-search text-sm"></i></button>
                    <a href="{{ route('wishlist.index') }}" class="press relative h-11 w-11 rounded-full bg-white border border-line flex items-center justify-center text-ink shadow-sm" aria-label="Wishlist">
                        <i class="far fa-heart text-sm"></i>
                        <span x-show="$store.wishlist.count > 0" x-text="$store.wishlist.count" class="absolute -top-1 -right-1 bg-rose-400 text-white text-[10px] font-bold min-w-[16px] h-4 px-1 rounded-full flex items-center justify-center"></span>
                    </a>
                </div>

                <!-- Desktop Quick Links -->
                <div class="hidden lg:flex items-center gap-3 text-sm font-medium text-ink/70">
                    <span class="flex items-center gap-2 px-4 h-10 rounded-full bg-white border border-line"><i class="fas fa-truck-fast text-gold"></i> Track Order</span>
                    <a href="{{ route('wishlist.index') }}" class="h-10 w-10 rounded-full bg-white border border-line flex items-center justify-center hover:text-rose-500 transition-colors" aria-label="Wishlist"><i class="far fa-heart"></i></a>
                    <a href="{{ route('cart.index') }}" class="relative h-10 w-10 rounded-full bg-navy text-white flex items-center justify-center hover:bg-navy/90 transition-colors" aria-label="Bag">
                        <i class="fas fa-shopping-bag text-sm"></i>
                        <span x-show="$store.cart.count > 0" x-text="$store.cart.count" class="absolute -top-1 -right-1 bg-gold text-ink text-[10px] font-bold w-5 h-5 rounded-full flex items-center justify-center ring-2 ring-paper"></span>
                    </a>
                </div>
            </header>

            <!-- Page content -->
            <div class="p-4 sm:p-6 lg:p-8 space-y-10 lg:space-y-14">

                <!-- HERO: text first on phones so the headline is above the fold -->
                <section class="relative rounded-3xl overflow-hidden bg-navy hero-grain text-white" x-data="carousel" x-init="start()" @mouseenter="stop()" @mouseleave="start()" @touchstart.passive="onTouchStart($event)" @touchend.passive="onTouchEnd($event)" aria-roledescription="carousel">
                    <i class="fas fa-ring absolute text-[200px] lg:text-[260px] text-white/[0.025] -left-10 -bottom-16 -rotate-12 pointer-events-none" aria-hidden="true"></i>

                    <div class="relative grid lg:grid-cols-[1.1fr_0.9fr] lg:min-h-[520px]">

                        <!-- Text -->
                        <div class="relative z-10 p-6 pb-5 sm:p-12 lg:p-16 flex flex-col justify-center order-1">
                            <div class="grid">
                                <!-- Slide 1 -->
                                <div class="col-start-1 row-start-1 transition-all duration-700" :class="current === 0 ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-3 pointer-events-none'" :aria-hidden="current !== 0">
                                    <p class="inline-flex items-center gap-2 text-xs sm:text-sm text-gold mb-3 font-medium"><i class="fas fa-gem"></i> The Bridal Edit</p>
                                    <h1 class="font-display text-[2.5rem] sm:text-6xl xl:text-7xl font-semibold tracking-tight leading-[0.98] mb-3 sm:mb-5">Say yes in <span class="italic font-medium text-gold-soft">style.</span></h1>
                                    <p class="text-white/70 max-w-md text-sm sm:text-base leading-relaxed mb-5 sm:mb-8">Handpicked gowns, veils and hijabs for your big day. Discover our exclusive collection.</p>
                                    <a href="#" class="press inline-flex items-center gap-2.5 bg-gold text-ink font-semibold px-6 sm:px-8 h-12 rounded-full hover:bg-white transition-colors text-sm shadow-[0_16px_30px_-12px_rgba(201,169,110,0.8)]">
                                        Explore bridal <i class="fas fa-arrow-right text-xs"></i>
                                    </a>
                                </div>
                                <!-- Slide 2 -->
                                <div class="col-start-1 row-start-1 transition-all duration-700" :class="current === 1 ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-3 pointer-events-none'" :aria-hidden="current !== 1">
                                    <p class="inline-flex items-center gap-2 text-xs sm:text-sm text-gold mb-3 font-medium"><i class="fas fa-spray-can-sparkles"></i> Fragrance</p>
                                    <h2 class="font-display text-[2.5rem] sm:text-6xl xl:text-7xl font-semibold tracking-tight leading-[0.98] mb-3 sm:mb-5">Scents that <span class="italic font-medium text-gold-soft">linger.</span></h2>
                                    <p class="text-white/70 max-w-md text-sm sm:text-base leading-relaxed mb-5 sm:mb-8">Oud, amber and soft florals to finish every look, from the nikah to the after-party.</p>
                                    <a href="#" class="press inline-flex items-center gap-2.5 bg-gold text-ink font-semibold px-6 sm:px-8 h-12 rounded-full hover:bg-white transition-colors text-sm shadow-[0_16px_30px_-12px_rgba(201,169,110,0.8)]">
                                        Shop fragrance <i class="fas fa-arrow-right text-xs"></i>
                                    </a>
                                </div>
                                <!-- Slide 3 -->
                                <div class="col-start-1 row-start-1 transition-all duration-700" :class="current === 2 ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-3 pointer-events-none'" :aria-hidden="current !== 2">
                                    <p class="inline-flex items-center gap-2 text-xs sm:text-sm text-gold mb-3 font-medium"><i class="fas fa-wand-magic-sparkles"></i> New in</p>
                                    <h2 class="font-display text-[2.5rem] sm:text-6xl xl:text-7xl font-semibold tracking-tight leading-[0.98] mb-3 sm:mb-5">Fresh from the <span class="italic font-medium text-gold-soft">atelier.</span></h2>
                                    <p class="text-white/70 max-w-md text-sm sm:text-base leading-relaxed mb-5 sm:mb-8">The latest fashion arrivals, added every week. Be the first to see them.</p>
                                    <a href="#" class="press inline-flex items-center gap-2.5 bg-gold text-ink font-semibold px-6 sm:px-8 h-12 rounded-full hover:bg-white transition-colors text-sm shadow-[0_16px_30px_-12px_rgba(201,169,110,0.8)]">
                                        See what’s new <i class="fas fa-arrow-right text-xs"></i>
                                    </a>
                                </div>
                            </div>

                            <!-- Controls (dots have a taller invisible tap area) -->
                            <div class="flex items-center gap-2 mt-4 sm:mt-8">
                                <button @click="prev(); start()" class="press h-11 w-11 rounded-full border border-white/25 hidden sm:flex items-center justify-center text-white/80 hover:bg-white/10 transition-colors" aria-label="Previous slide"><i class="fas fa-chevron-left text-xs"></i></button>
                                <div class="flex items-center">
                                    <template x-for="i in 3" :key="i">
                                        <button @click="goTo(i - 1)" class="py-4 px-1" :aria-label="'Go to slide ' + i">
                                            <span class="block h-1.5 sm:h-2 rounded-full transition-all duration-300" :class="current === i - 1 ? 'w-7 sm:w-8 bg-gold' : 'w-2 bg-white/30'"></span>
                                        </button>
                                    </template>
                                </div>
                                <button @click="next(); start()" class="press h-11 w-11 rounded-full border border-white/25 hidden sm:flex items-center justify-center text-white/80 hover:bg-white/10 transition-colors" aria-label="Next slide"><i class="fas fa-chevron-right text-xs"></i></button>
                            </div>
                        </div>

                        <!-- Arched image: peeks up from the bottom edge on phones -->
                        <div class="relative order-2 flex items-end justify-center px-8 h-48 sm:h-72 lg:h-auto lg:pt-14 overflow-hidden">
                            <div class="absolute w-[78%] max-w-sm aspect-[3/4] bottom-0 arch-ring border border-gold/40 translate-x-4 hidden lg:block" aria-hidden="true"></div>
                            
                            <!-- The new gold bridal image -->
                            <div class="relative w-[62%] sm:w-[48%] lg:w-[78%] max-w-sm h-full lg:h-auto lg:aspect-[3/4] arch arch-bleed bg-navy border border-white/10 flex items-center justify-center shadow-[0_40px_60px_-30px_rgba(0,0,0,0.6)] overflow-hidden">
                                <img src="{{ asset('images/bridal-vector-gold.png') }}" 
                                     alt="Elegant bride holding a bouquet" 
                                     class="w-[85%] h-[85%] object-contain object-top scale-105" 
                                     loading="eager" />
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Trust badges: compact 2x2 on phones so nothing is hidden off-screen -->
                <section class="grid grid-cols-2 md:grid-cols-4 gap-2.5 sm:gap-4" aria-label="Why shop with us">
                    <div class="bg-white rounded-2xl p-3 sm:p-5 flex items-center gap-2.5 sm:gap-3.5 border border-line min-w-0">
                        <div class="h-9 w-9 sm:h-11 sm:w-11 rounded-full bg-blush flex items-center justify-center text-gold shrink-0"><i class="fas fa-truck text-xs sm:text-base"></i></div>
                        <div class="min-w-0"><h4 class="text-[13px] sm:text-sm font-semibold text-ink leading-tight">Free delivery</h4><p class="text-[11px] sm:text-xs text-muted mt-0.5 leading-snug">Orders over KSh 10k</p></div>
                    </div>
                    <div class="bg-white rounded-2xl p-3 sm:p-5 flex items-center gap-2.5 sm:gap-3.5 border border-line min-w-0">
                        <div class="h-9 w-9 sm:h-11 sm:w-11 rounded-full bg-blush flex items-center justify-center text-gold shrink-0"><i class="fas fa-shield-alt text-xs sm:text-base"></i></div>
                        <div class="min-w-0"><h4 class="text-[13px] sm:text-sm font-semibold text-ink leading-tight">Secure payment</h4><p class="text-[11px] sm:text-xs text-muted mt-0.5 leading-snug">M-Pesa & cards</p></div>
                    </div>
                    <div class="bg-white rounded-2xl p-3 sm:p-5 flex items-center gap-2.5 sm:gap-3.5 border border-line min-w-0">
                        <div class="h-9 w-9 sm:h-11 sm:w-11 rounded-full bg-blush flex items-center justify-center text-gold shrink-0"><i class="fas fa-undo text-xs sm:text-base"></i></div>
                        <div class="min-w-0"><h4 class="text-[13px] sm:text-sm font-semibold text-ink leading-tight">Easy returns</h4><p class="text-[11px] sm:text-xs text-muted mt-0.5 leading-snug">30-day policy</p></div>
                    </div>
                    <div class="bg-white rounded-2xl p-3 sm:p-5 flex items-center gap-2.5 sm:gap-3.5 border border-line min-w-0">
                        <div class="h-9 w-9 sm:h-11 sm:w-11 rounded-full bg-blush flex items-center justify-center text-gold shrink-0"><i class="fas fa-headset text-xs sm:text-base"></i></div>
                        <div class="min-w-0"><h4 class="text-[13px] sm:text-sm font-semibold text-ink leading-tight">24/7 support</h4><p class="text-[11px] sm:text-xs text-muted mt-0.5 leading-snug">Dedicated help</p></div>
                    </div>
                </section>

                <!-- Shop by category: ONE markup. Pills on phones, circles on desktop. -->
                @if ($categories->isNotEmpty())
                    <section>
                        <h3 class="font-display text-2xl sm:text-3xl font-semibold tracking-tight mb-4 sm:mb-6">Shop by category</h3>
                        <div class="flex gap-2.5 lg:gap-3 overflow-x-auto no-scrollbar snap-x scroll-pl-4 py-1 -mx-4 px-4 sm:-mx-6 sm:px-6 lg:mx-0 lg:px-0 lg:py-2">
                            @foreach ($categories as $category)
                                <a href="{{ route('category.show', $category->slug) }}"
                                    class="press group snap-start shrink-0 flex items-center gap-2 min-h-[44px] px-4 rounded-full bg-white border border-line shadow-sm text-sm font-medium text-ink whitespace-nowrap
                                           lg:w-32 lg:flex-col lg:gap-3 lg:px-0 lg:min-h-0 lg:rounded-none lg:bg-transparent lg:border-0 lg:shadow-none lg:whitespace-normal">
                                    <span class="flex items-center justify-center lg:h-28 lg:w-28 lg:rounded-full lg:bg-white lg:border lg:border-line lg:shadow-sm lg:transition-all lg:duration-300 lg:group-hover:border-gold lg:group-hover:bg-blush lg:group-hover:shadow-md">
                                        @if ($category->icon)
                                            <i class="fas {{ $category->icon }} text-xs text-gold lg:text-2xl"></i>
                                        @else
                                            <i class="fas fa-tag text-xs text-gold lg:text-2xl"></i>
                                        @endif
                                    </span>
                                    <span class="lg:text-center lg:leading-tight">{{ $category->name }}</span>
                                </a>
                            @endforeach
                        </div>
                    </section>
                @endif

                <!-- Featured: 2-column grid on phones -->
                @if ($featured->isNotEmpty())
                    <section>
                        <div class="flex items-end justify-between mb-4 sm:mb-6 gap-4">
                            <div>
                                <h3 class="font-display text-2xl sm:text-3xl font-semibold tracking-tight">Featured</h3>
                                <div class="gold-rule w-16 sm:w-24 mt-2 sm:mt-3"></div>
                            </div>
                            <a href="#" class="link-underline text-ink font-medium text-sm py-2">See all</a>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-6">
                            @foreach ($featured as $product)
                                <div class="lift min-w-0">
                                    <x-product-card :product="$product" />
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

                <!-- Appointment banner -->
                <section class="relative overflow-hidden rounded-3xl bg-blush border border-line p-6 sm:p-12 lg:p-14 grid sm:grid-cols-[1fr_auto] items-center gap-6 sm:gap-8">
                    <div class="relative z-10 max-w-lg text-center sm:text-left">
                        <h3 class="font-display text-3xl sm:text-5xl font-semibold text-navy leading-[1.02] mb-3 sm:mb-4">Bridal fittings,<br class="hidden sm:block"> by appointment.</h3>
                        <p class="text-ink/70 text-sm sm:text-base leading-relaxed mb-5 sm:mb-7 max-w-md mx-auto sm:mx-0">Book a private session with our stylists and find the gown that feels like you.</p>
                        <button class="press inline-flex items-center justify-center gap-2.5 bg-navy text-white font-semibold px-7 h-12 rounded-full hover:bg-navy/90 transition-colors text-sm shadow-[0_16px_30px_-14px_rgba(27,42,74,0.8)] w-full sm:w-auto">
                            Book a fitting <i class="fas fa-arrow-right text-xs"></i>
                        </button>
                    </div>
                    <div class="hidden sm:flex relative z-10 w-44 h-56 arch bg-white border-4 border-white shadow-[0_24px_40px_-24px_rgba(27,42,74,0.4)] items-center justify-center">
                        <i class="fas fa-ring text-6xl text-gold"></i>
                    </div>
                    <i class="fas fa-ring absolute -right-6 -top-6 text-[110px] text-white/50 rotate-12 pointer-events-none sm:hidden" aria-hidden="true"></i>
                    <i class="fas fa-star absolute -left-6 -bottom-8 text-[140px] text-white/30 rotate-12 pointer-events-none hidden sm:block" aria-hidden="true"></i>
                </section>

                <!-- Popular: swipe rail on phones, grid on desktop (single markup) -->
                <section>
                    <div class="flex items-end justify-between mb-4 sm:mb-6 gap-4">
                        <div>
                            <h3 class="font-display text-2xl sm:text-3xl font-semibold tracking-tight">Popular right now</h3>
                            <div class="gold-rule w-16 sm:w-24 mt-2 sm:mt-3"></div>
                        </div>
                        <a href="#" class="link-underline text-ink font-medium text-sm py-2">See all</a>
                    </div>
                    @if ($popular->isEmpty())
                        <div class="bg-white rounded-3xl border border-dashed border-line p-10 text-center">
                            <i class="fas fa-box-open text-3xl text-gold/60 mb-3"></i>
                            <p class="font-display text-xl sm:text-2xl font-semibold text-ink">No pieces yet</p>
                            <p class="text-sm text-muted mt-1">New arrivals are on the way. Check back soon.</p>
                        </div>
                    @else
                        <div class="flex gap-3 sm:gap-4 overflow-x-auto no-scrollbar snap-x snap-mandatory scroll-pl-4 pb-3 -mx-4 px-4 sm:-mx-6 sm:px-6
                                    lg:mx-0 lg:px-0 lg:pb-0 lg:grid lg:grid-cols-3 xl:grid-cols-4 lg:gap-6 lg:overflow-visible">
                            @foreach ($popular as $product)
                                <div class="lift snap-start shrink-0 w-[56vw] sm:w-[34vw] lg:w-auto min-w-0">
                                    <x-product-card :product="$product" />
                                </div>
                            @endforeach
                        </div>
                    @endif
                </section>

                <!-- Best sellers -->
                <section class="bg-white rounded-3xl border border-line overflow-hidden shadow-sm">
                    <div class="flex flex-col lg:flex-row">
                        <!-- Panel: compact header row on phones, tall column on desktop -->
                        <div class="lg:w-[34%] shrink-0 p-5 sm:p-10 lg:p-12 bg-navy text-white relative overflow-hidden flex flex-row lg:flex-col items-center lg:items-stretch justify-between gap-4">
                            <i class="fas fa-star absolute -right-6 -bottom-6 text-[140px] text-white/[0.04] rotate-12 pointer-events-none" aria-hidden="true"></i>
                            <div class="relative z-10">
                                <p class="hidden lg:inline-flex items-center gap-2 text-gold text-sm font-medium mb-4"><i class="fas fa-crown"></i> Most loved</p>
                                <h3 class="font-display text-2xl sm:text-4xl font-semibold tracking-tight leading-[1.1]">Our best sellers</h3>
                                <p class="hidden sm:block text-white/65 text-sm leading-relaxed max-w-xs mt-3">The pieces our brides keep coming back for, from gowns to the finishing touches.</p>
                            </div>
                            <a href="#" class="press relative z-10 shrink-0 inline-flex items-center gap-2 bg-gold text-ink font-semibold px-5 h-11 rounded-full hover:bg-white transition-colors text-sm lg:mt-10 lg:self-start">
                                View all <i class="fas fa-arrow-right text-xs"></i>
                            </a>
                        </div>

                        <!-- Rail -->
                        <div class="flex-1 min-w-0 p-4 sm:p-8" x-data="{
                            scrollRail(dir) { this.$refs.rail.scrollBy({ left: dir * this.$refs.rail.clientWidth * 0.8, behavior: 'smooth' }); }
                        }">
                            @if ($bestsellers->isEmpty())
                                <div class="min-h-[220px] lg:min-h-[300px] flex flex-col items-center justify-center text-center">
                                    <i class="fas fa-box-open text-3xl text-gold/60 mb-3"></i>
                                    <p class="text-sm text-muted">No best sellers yet.</p>
                                </div>
                            @else
                                <div x-ref="rail" class="flex gap-3 sm:gap-5 overflow-x-auto no-scrollbar snap-x snap-mandatory scroll-pl-4 pb-2 -mx-4 px-4 sm:mx-0 sm:px-0">
                                    @foreach ($bestsellers as $product)
                                        <div class="lift snap-start shrink-0 w-[56vw] sm:w-[40%] lg:w-[31%] min-w-0">
                                            <x-product-card :product="$product" />
                                        </div>
                                    @endforeach
                                </div>

                                <div class="flex items-center justify-between mt-4 sm:mt-5">
                                    <span class="text-xs text-muted sm:hidden">Swipe for more</span>
                                    <div class="hidden sm:flex gap-2">
                                        <button type="button" aria-label="Scroll left" @click="scrollRail(-1)" class="h-11 w-11 rounded-full border border-line bg-paper flex items-center justify-center text-ink hover:bg-white hover:border-gold hover:text-gold transition-colors">
                                            <i class="fas fa-arrow-left text-xs"></i>
                                        </button>
                                        <button type="button" aria-label="Scroll right" @click="scrollRail(1)" class="h-11 w-11 rounded-full border border-line bg-paper flex items-center justify-center text-ink hover:bg-white hover:border-gold hover:text-gold transition-colors">
                                            <i class="fas fa-arrow-right text-xs"></i>
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </section>

                <!-- Newsletter -->
                <section class="bg-navy hero-grain text-white rounded-3xl p-6 py-10 sm:p-14 relative overflow-hidden flex flex-col items-center text-center" x-data="{ sent: false }">
                    <i class="fas fa-envelope absolute -right-6 -bottom-6 text-[160px] text-white/[0.04] rotate-12 pointer-events-none" aria-hidden="true"></i>
                    <div class="relative z-10 max-w-lg w-full">
                        <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-white/10 flex items-center justify-center mx-auto mb-4 sm:mb-5 text-gold border border-white/20">
                            <i class="fas fa-envelope text-lg"></i>
                        </div>
                        <h4 class="font-display text-3xl sm:text-4xl font-semibold tracking-tight mb-2 sm:mb-3">Join the Mawadda list</h4>
                        <p class="text-white/65 text-sm sm:text-base mb-6 sm:mb-8">New collections, bridal edits and private offers, straight to your inbox.</p>

                        <form x-show="!sent" class="flex flex-col sm:flex-row gap-3 w-full" @submit.prevent="sent = true">
                            <!-- text-base on phones stops iOS Safari zooming the page on focus -->
                            <input type="email" inputmode="email" autocomplete="email" placeholder="Your email address" required aria-label="Email address" class="flex-1 min-w-0 px-6 h-12 rounded-full bg-white/10 border border-white/20 text-white placeholder:text-white/40 text-base sm:text-sm focus:outline-none focus:ring-2 focus:ring-gold/60">
                            <button type="submit" class="press bg-gold text-ink font-semibold px-7 h-12 rounded-full hover:bg-white transition-colors text-sm whitespace-nowrap">
                                Subscribe <i class="fas fa-paper-plane ml-1.5 text-xs"></i>
                            </button>
                        </form>
                        <p x-show="sent" x-cloak class="inline-flex items-center gap-2 bg-white/10 border border-white/20 rounded-full px-6 py-3 text-sm"><i class="fas fa-check text-gold"></i> You’re on the list. Thank you.</p>
                    </div>
                </section>

            </div>
        </main>
    </div>

    <!-- MOBILE: floating bag bar (only when the bag has items), sits above the nav pill -->
    <div class="lg:hidden fixed left-4 right-4 z-40" style="bottom: calc(6rem + env(safe-area-inset-bottom));" x-show="$store.cart.count > 0" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-cloak>
        <a href="{{ route('cart.index') }}" class="press bg-navy text-white rounded-full p-1.5 pl-5 flex items-center justify-between shadow-[0_20px_40px_-10px_rgba(27,42,74,0.6)] border border-white/10">
            <span class="flex items-center gap-2.5 text-sm font-medium">
                <i class="fas fa-shopping-bag text-gold"></i>
                <span><span x-text="$store.cart.count"></span> <span x-text="$store.cart.count === 1 ? 'item' : 'items'"></span> in your bag</span>
            </span>
            <span class="bg-gold text-ink rounded-full px-5 h-11 text-sm font-semibold flex items-center gap-2">View bag <i class="fas fa-arrow-right text-[10px]"></i></span>
        </a>
    </div>

    <!-- Mobile Drawer Menu -->
    <div class="lg:hidden" x-show="menuOpen" x-cloak>
        <div x-show="menuOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="menuOpen = false" class="fixed inset-0 z-50 bg-navy/50 backdrop-blur-sm" aria-hidden="true"></div>

        <aside id="mobile-drawer" x-show="menuOpen" x-trap.noscroll="menuOpen" x-transition:enter="transition ease-out duration-250 transform" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" role="dialog" aria-modal="true" class="fixed inset-y-0 left-0 z-50 w-[88%] max-w-sm bg-paper shadow-2xl flex flex-col" style="padding-top: env(safe-area-inset-top); padding-bottom: env(safe-area-inset-bottom);">

            <div class="flex items-center justify-between px-5 h-20 border-b border-line shrink-0">
                <a href="{{ route('home') }}" @click="menuOpen = false" aria-label="Mawaddabridals home">
                    <img src="{{ asset('images/mawaddabridals-logo.svg') }}" alt="Mawaddabridals" class="h-9 w-auto">
                </a>
                <button @click="menuOpen = false" class="press h-11 w-11 rounded-full bg-white border border-line flex items-center justify-center text-ink" aria-label="Close menu">
                    <i class="fas fa-times text-sm"></i>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto no-scrollbar px-5 py-6 space-y-7 overscroll-contain">
                <form action="{{ route('search') }}" method="GET" role="search" class="flex items-center gap-2 rounded-full pl-5 pr-1.5 h-12 bg-white border border-line">
                    <input type="text" name="q" placeholder="Search dresses, fragrances…" aria-label="Search" class="bg-transparent border-0 outline-none w-full text-base">
                    <button type="submit" class="h-9 w-9 shrink-0 rounded-full bg-gold text-ink flex items-center justify-center" aria-label="Search"><i class="fas fa-search text-xs"></i></button>
                </form>

                <nav class="space-y-1.5" aria-label="Menu">
                    <a href="#" class="flex items-center gap-3.5 pl-3 pr-4 min-h-[48px] rounded-full text-[15px] font-medium bg-navy text-white shadow-md">
                        <span class="h-9 w-9 rounded-full bg-white/10 flex items-center justify-center text-gold"><i class="fas fa-gem text-sm"></i></span> Bridal Collection
                    </a>
                    <a href="#" class="flex items-center gap-3.5 pl-3 pr-4 min-h-[48px] rounded-full text-[15px] font-medium text-ink/80 active:bg-white">
                        <span class="h-9 w-9 rounded-full bg-white border border-line flex items-center justify-center text-gold"><i class="fas fa-wand-magic-sparkles text-sm"></i></span> New In
                    </a>
                    <a href="#" class="flex items-center gap-3.5 pl-3 pr-4 min-h-[48px] rounded-full text-[15px] font-medium text-ink/80 active:bg-white">
                        <span class="h-9 w-9 rounded-full bg-white border border-line flex items-center justify-center text-gold"><i class="fas fa-spray-can-sparkles text-sm"></i></span> Fragrance
                    </a>
                    <a href="{{ route('wishlist.index') }}" class="flex items-center gap-3.5 pl-3 pr-4 min-h-[48px] rounded-full text-[15px] font-medium text-ink/80 active:bg-white">
                        <span class="h-9 w-9 rounded-full bg-white border border-line flex items-center justify-center text-gold"><i class="far fa-heart text-sm"></i></span> Wishlist
                        <span x-show="$store.wishlist.count > 0" x-text="$store.wishlist.count" class="ml-auto bg-rose-400 text-white text-[10px] font-bold min-w-[20px] h-5 px-1.5 rounded-full flex items-center justify-center"></span>
                    </a>
                    <a href="{{ route('cart.index') }}" class="flex items-center gap-3.5 pl-3 pr-4 min-h-[48px] rounded-full text-[15px] font-medium text-ink/80 active:bg-white">
                        <span class="h-9 w-9 rounded-full bg-white border border-line flex items-center justify-center text-gold"><i class="fas fa-shopping-bag text-sm"></i></span> My Bag
                        <span x-show="$store.cart.count > 0" x-text="$store.cart.count" class="ml-auto bg-gold text-ink text-[10px] font-bold min-w-[20px] h-5 px-1.5 rounded-full flex items-center justify-center"></span>
                    </a>
                    <a href="#" class="flex items-center gap-3.5 pl-3 pr-4 min-h-[48px] rounded-full text-[15px] font-medium text-ink/80 active:bg-white">
                        <span class="h-9 w-9 rounded-full bg-white border border-line flex items-center justify-center text-gold"><i class="fas fa-headset text-sm"></i></span> Support
                    </a>
                </nav>

                @if ($categories->isNotEmpty())
                    <div>
                        <h4 class="px-3 font-display text-xl font-semibold text-ink mb-2">Categories</h4>
                        <div class="space-y-0.5">
                            @foreach ($categories as $category)
                                <a href="{{ route('category.show', $category->slug) }}" @click="menuOpen = false" class="flex items-center gap-3 px-3 min-h-[48px] rounded-xl text-sm font-medium text-ink/70 active:bg-white">
                                    <span class="h-8 w-8 rounded-full bg-blush/70 flex items-center justify-center shrink-0">
                                        <i class="fas {{ $category->icon ?? 'fa-tag' }} text-xs text-gold"></i>
                                    </span>
                                    {{ $category->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="shrink-0 border-t border-line bg-white px-5 py-4">
                @auth
                    <div class="grid grid-cols-2 gap-2.5">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-navy text-white text-sm font-medium h-12">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="w-full inline-flex items-center justify-center rounded-full bg-paper border border-line text-sm font-medium h-12">Logout</button></form>
                    </div>
                @else
                    <div class="grid grid-cols-2 gap-2.5">
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-full bg-paper border border-line text-sm font-medium h-12">Log in</a>
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-full bg-navy text-white text-sm font-medium h-12">Register</a>
                    </div>
                @endauth
            </div>
        </aside>
    </div>

    <!-- Mobile Search Modal -->
    <div x-show="mobileSearchOpen" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click.self="mobileSearchOpen = false" x-init="$watch('mobileSearchOpen', v => v && $nextTick(() => $refs.mobileSearchInput.focus()))" class="lg:hidden fixed inset-0 z-50 bg-navy/40 backdrop-blur-sm flex items-start justify-center px-4" style="padding-top: calc(1.25rem + env(safe-area-inset-top));" role="dialog" aria-modal="true">
        <div x-show="mobileSearchOpen" x-transition:enter="transition ease-out duration-200 delay-75" x-transition:enter-start="opacity-0 -translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" class="bg-white rounded-3xl p-4 w-full max-w-md shadow-2xl" x-data="{ q: '', focused: false }">
            <form action="{{ route('search') }}" method="GET" role="search" @submit="mobileSearchOpen = false">
                <div class="flex items-center gap-2 rounded-full pl-5 pr-1.5 h-12 bg-paper border border-line">
                    <input x-ref="mobileSearchInput" x-model="q" type="search" enterkeyhint="search" name="q" placeholder="Search dresses, fragrances…" aria-label="Search" class="bg-transparent border-0 outline-none w-full text-base">
                    <button type="submit" class="h-9 w-9 shrink-0 rounded-full bg-gold text-ink flex items-center justify-center" aria-label="Search"><i class="fas fa-search text-xs"></i></button>
                </div>
            </form>
            <button @click="mobileSearchOpen = false" class="mt-3 w-full h-12 rounded-full bg-paper text-ink/70 font-medium text-sm active:bg-line transition-colors">Cancel</button>
        </div>
    </div>

    <!-- Mobile floating bottom navigation (pill) -->
    <nav class="lg:hidden fixed left-4 right-4 z-40 bg-white/95 backdrop-blur-lg border border-line shadow-[0_20px_40px_-10px_rgba(27,42,74,0.25)] rounded-full flex items-center px-2 py-2" style="bottom: calc(1rem + env(safe-area-inset-bottom));" aria-label="Quick navigation">
        <a href="{{ route('home') }}" class="press relative flex-1 flex flex-col items-center justify-center h-14 rounded-full text-ink bg-blush/60" aria-current="page">
            <i class="fas fa-home text-lg text-gold"></i>
            <span class="text-[10px] font-semibold mt-0.5">Home</span>
        </a>
        <button type="button" @click="menuOpen = true" class="press flex-1 flex flex-col items-center justify-center h-14 text-muted">
            <i class="fas fa-th-large text-lg"></i>
            <span class="text-[10px] font-semibold mt-0.5">Explore</span>
        </button>
        <a href="{{ route('cart.index') }}" class="press relative flex-1 flex flex-col items-center justify-center h-14 text-muted">
            <span class="relative">
                <i class="fas fa-shopping-bag text-lg"></i>
                <span x-show="$store.cart.count > 0" x-text="$store.cart.count" class="absolute -top-2 -right-3 min-w-[16px] h-4 px-1 rounded-full bg-gold text-ink text-[10px] font-bold flex items-center justify-center ring-2 ring-white"></span>
            </span>
            <span class="text-[10px] font-semibold mt-0.5">Bag</span>
        </a>
        @auth
            <a href="{{ route('dashboard') }}" class="press flex-1 flex flex-col items-center justify-center h-14 text-muted">
                <i class="fas fa-user text-lg"></i>
                <span class="text-[10px] font-semibold mt-0.5">Account</span>
            </a>
        @else
            <a href="{{ route('login') }}" class="press flex-1 flex flex-col items-center justify-center h-14 text-muted">
                <i class="fas fa-user text-lg"></i>
                <span class="text-[10px] font-semibold mt-0.5">Account</span>
            </a>
        @endauth
    </nav>

    @stack('scripts')
</body>
</html>