@php
    $cartCount = auth()->check() ? auth()->user()->cartCount() : 0;
    $flashCart = session('cart_added');
    $flashSuccess = session('success');
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>{{ config('app.name', 'Mawaddabridals') }} · Bridal, Fashion & Fragrance</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:opsz,wght@9..144,500;9..144,600;9..144,700&family=Jost:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
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
                        blush: '#F3E7E0',
                        line: '#E9E1D6',
                        muted: '#8A8276',
                    },
                    fontFamily: {
                        serif: ['"Cormorant Garamond"', 'ui-serif', 'Georgia', 'serif'],
                        sans: ['Jost', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                    borderRadius: {
                        xl2: '20px',
                    },
                    letterSpacing: {
                        luxe: '0.18em',
                    },
                },
            },
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>

    @stack('styles')

    <style>
        [x-cloak] {
            display: none !important;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Jost', sans-serif;
            background: #FBF8F3;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        header a:focus-visible,
        header button:focus-visible,
        #mobile-drawer a:focus-visible,
        #mobile-drawer button:focus-visible {
            outline: 2px solid #C9A96E;
            outline-offset: 2px;
        }

        input[type="text"],
        input[type="email"],
        input[type="search"] {
            outline: none !important;
            box-shadow: none !important;
        }

        .search-wrapper:focus-within {
            border-color: #C9A96E;
            box-shadow: 0 0 0 4px rgba(201, 169, 110, 0.14);
        }

        @media (prefers-reduced-motion: reduce) {
            html {
                scroll-behavior: auto;
            }

            * {
                transition-duration: 0.01ms !important;
            }
        }

        /* ==========================================================
           Mawaddabridals · SweetAlert2 "added to cart" popup
           ========================================================== */
        .swal2-container.vk-container {
            padding: 1rem;
            background: rgba(27, 42, 74, 0.45) !important;
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
        }

        .swal2-popup.vk-popup {
            width: 100%;
            max-width: 380px;
            padding: 0;
            overflow: hidden;
            border-radius: 24px;
            background: #FBF8F3;
            color: #1B2A4A;
            font-family: 'Jost', sans-serif;
            box-shadow: 0 0 0 1px #E9E1D6, 0 34px 70px -24px rgba(27, 42, 74, 0.55);
        }

        .swal2-popup.vk-popup .swal2-html-container {
            margin: 0;
            padding: 0;
            overflow: visible;
            text-align: left;
            color: inherit;
        }

        .vk-head {
            position: relative;
            overflow: hidden;
            padding: 30px 24px 26px;
            text-align: center;
            color: #fff;
            background-image: linear-gradient(135deg, #1B2A4A 0%, #2E3F63 100%);
        }

        .vk-head-bag {
            position: absolute;
            right: -10px;
            bottom: -18px;
            font-size: 7.5rem;
            color: rgba(255, 255, 255, 0.06);
            transform: rotate(-8deg);
            pointer-events: none;
        }

        .vk-badge {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 68px;
            height: 68px;
            margin: 0 auto 14px;
            border-radius: 9999px;
            background: #FBF8F3;
            box-shadow: 0 0 0 6px rgba(201, 169, 110, 0.3), 0 14px 28px -10px rgba(0, 0, 0, 0.5);
            animation: vk-badge-pop 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) 0.1s both;
        }

        .vk-badge::after {
            content: "";
            position: absolute;
            inset: -6px;
            border-radius: 9999px;
            border: 2px solid #C9A96E;
            opacity: 0;
            animation: vk-ring 0.9s ease-out 0.35s 1;
        }

        .vk-check {
            width: 34px;
            height: 34px;
        }

        .vk-check path {
            fill: none;
            stroke: #C9A96E;
            stroke-width: 4.5;
            stroke-linecap: round;
            stroke-linejoin: round;
            stroke-dasharray: 44;
            stroke-dashoffset: 44;
            animation: vk-draw 0.45s ease-out 0.3s forwards;
        }

        .vk-title {
            position: relative;
            z-index: 1;
            margin: 0;
            font-family: 'Cormorant Garamond', ui-serif, Georgia, serif;
            font-size: 26px;
            font-weight: 600;
            letter-spacing: 0.01em;
            line-height: 1.1;
        }

        .vk-sub {
            position: relative;
            z-index: 1;
            margin: 6px 0 0;
            font-size: 13.5px;
            color: rgba(255, 255, 255, 0.75);
        }

        .vk-body {
            padding: 18px 20px 6px;
        }

        .vk-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px;
            border-radius: 16px;
            background: #fff;
            border: 1px solid #E9E1D6;
        }

        .vk-thumb {
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 56px;
            height: 56px;
            overflow: hidden;
            border-radius: 12px;
            background: #FBF8F3;
            border: 1px solid #E9E1D6;
            color: #C9A96E;
        }

        .vk-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .vk-item-info {
            min-width: 0;
            flex: 1;
        }

        .vk-item-name {
            margin: 0;
            font-size: 14px;
            font-weight: 600;
            line-height: 1.3;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .vk-item-meta {
            margin: 3px 0 0;
            font-size: 12.5px;
            color: #8A8276;
        }

        .vk-item-meta strong {
            color: #1B2A4A;
            font-weight: 700;
        }

        .vk-count {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin: 14px 0 0;
            font-size: 12.5px;
            color: #8A8276;
        }

        .vk-count i {
            color: #C9A96E;
        }

        .vk-msg {
            margin: 0;
            padding: 6px 4px 2px;
            text-align: center;
            font-size: 14px;
            line-height: 1.5;
            color: rgba(27, 42, 74, 0.75);
        }

        .swal2-popup.vk-popup .swal2-actions.vk-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            width: 100%;
            margin: 0;
            padding: 16px 20px 20px;
        }

        .swal2-popup.vk-popup .swal2-actions.vk-actions.vk-single {
            grid-template-columns: 1fr;
        }

        .swal2-popup.vk-popup .vk-btn {
            margin: 0;
            padding: 12px 14px;
            border-radius: 9999px;
            font-family: 'Jost', sans-serif;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.03em;
            cursor: pointer;
            transition: background-color 0.15s, transform 0.1s, box-shadow 0.15s;
        }

        .swal2-popup.vk-popup .vk-btn:active {
            transform: scale(0.97);
        }

        .swal2-popup.vk-popup .vk-btn:focus-visible {
            outline: 2px solid #C9A96E;
            outline-offset: 2px;
            box-shadow: none;
        }

        .swal2-popup.vk-popup .vk-confirm {
            order: 2;
            border: 0;
            background: #C9A96E;
            color: #1B2A4A;
            box-shadow: 0 10px 24px -8px rgba(201, 169, 110, 0.7);
        }

        .swal2-popup.vk-popup .vk-confirm:hover {
            background: rgba(201, 169, 110, 0.9);
        }

        .swal2-popup.vk-popup .vk-cancel {
            order: 1;
            background: #fff;
            color: #1B2A4A;
            border: 1px solid #E9E1D6;
        }

        .swal2-popup.vk-popup .vk-cancel:hover {
            background: #FBF8F3;
        }

        .swal2-popup.vk-popup .swal2-timer-progress-bar-container {
            top: auto;
            bottom: 0;
            height: 4px;
            background: transparent;
            border-radius: 0;
        }

        .swal2-popup.vk-popup .swal2-timer-progress-bar {
            background: #C9A96E;
        }

        .swal2-popup.vk-popup.vk-in {
            animation: vk-in 0.32s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .swal2-popup.vk-popup.vk-out {
            animation: vk-out 0.2s ease-in forwards;
        }

        @keyframes vk-in {
            from {
                opacity: 0;
                transform: translateY(18px) scale(0.96);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        @keyframes vk-out {
            to {
                opacity: 0;
                transform: translateY(10px) scale(0.97);
            }
        }

        @keyframes vk-badge-pop {
            from {
                opacity: 0;
                transform: scale(0.5);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes vk-ring {
            0% {
                opacity: 0.8;
                transform: scale(1);
            }

            100% {
                opacity: 0;
                transform: scale(1.55);
            }
        }

        @keyframes vk-draw {
            to {
                stroke-dashoffset: 0;
            }
        }

        @media (prefers-reduced-motion: reduce) {

            .swal2-popup.vk-popup.vk-in,
            .swal2-popup.vk-popup.vk-out,
            .vk-badge,
            .vk-badge::after {
                animation: none;
            }

            .vk-check path {
                animation: none;
                stroke-dashoffset: 0;
            }
        }

        @media (max-width: 380px) {
            .swal2-popup.vk-popup .swal2-actions.vk-actions {
                grid-template-columns: 1fr;
            }

            .swal2-popup.vk-popup .vk-confirm {
                order: 1;
            }

            .swal2-popup.vk-popup .vk-cancel {
                order: 2;
            }
        }
    </style>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('cart', {
                count: {{ (int) $cartCount }}
            });

            Alpine.data('carousel', () => ({
                current: 0,
                total: 3,
                touchX: 0,
                timer: null,
                start() {
                    this.stop();
                    this.timer = setInterval(() => this.next(), 5500);
                },
                stop() {
                    clearInterval(this.timer);
                },
                next() {
                    this.current = (this.current + 1) % this.total;
                },
                prev() {
                    this.current = (this.current - 1 + this.total) % this.total;
                },
                goTo(i) {
                    this.current = i;
                    this.start();
                },
                onTouchStart(e) {
                    this.touchX = e.touches[0].clientX;
                },
                onTouchEnd(e) {
                    const dx = e.changedTouches[0].clientX - this.touchX;
                    if (Math.abs(dx) > 40) {
                        dx < 0 ? this.next() : this.prev();
                        this.start();
                    }
                },
            }));
        });

        (function () {
            const CART_URL = @json(route('cart.index'));

            const esc = (v) => String(v ?? '').replace(/[&<>"']/g, (c) => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#39;'
            } [c]));

            const money = (p) => {
                if (p === null || p === undefined || p === '') return '';
                const n = Number(String(p).replace(/[^0-9.]/g, ''));
                return isNaN(n) || String(p).match(/[a-z]/i) ? esc(p) : 'KSh ' + n.toLocaleString('en-KE');
            };

            window.vukaCartAdded = function (opts = {}) {
                if (typeof Swal === 'undefined') return;

                const {
                    title = 'Added to cart',
                    name = '',
                    image = '',
                    price = null,
                    quantity = 1,
                    count = null,
                    message = '',
                    showCartButton = true,
                } = opts;

                const total = count !== null && count !== '' ? Number(count) : null;
                if (total !== null && !isNaN(total) && window.Alpine && Alpine.store('cart')) {
                    Alpine.store('cart').count = total;
                }

                const thumb = image ?
                    `<img src="${esc(image)}" alt="" loading="lazy">` :
                    `<i class="fas fa-shopping-bag"></i>`;

                const priceText = money(price);
                const meta = [
                    quantity ? `Qty <strong>${esc(quantity)}</strong>` : '',
                    priceText ? `<strong>${priceText}</strong>` : ''
                ].filter(Boolean).join(' &nbsp;·&nbsp; ');

                const itemBlock = name ? `
                    <div class="vk-item">
                        <div class="vk-thumb">${thumb}</div>
                        <div class="vk-item-info">
                            <p class="vk-item-name">${esc(name)}</p>
                            ${meta ? `<p class="vk-item-meta">${meta}</p>` : ''}
                        </div>
                    </div>` : '';

                const countBlock = total !== null && !isNaN(total) && total > 0 ? `
                    <p class="vk-count"><i class="fas fa-shopping-bag"></i>
                        Your bag has ${total} ${total === 1 ? 'item' : 'items'}</p>` : '';

                const sub = name ? 'It’s waiting in your bag.' : esc(message);

                return Swal.fire({
                    html: `
                        <div class="vk-head">
                            <i class="fas fa-gem vk-head-bag" aria-hidden="true"></i>
                            <div class="vk-badge">
                                <svg class="vk-check" viewBox="0 0 52 52" aria-hidden="true">
                                    <path d="M14 27l8.5 8.5L38 18"/>
                                </svg>
                            </div>
                            <h2 class="vk-title">${esc(title)}</h2>
                            ${sub ? `<p class="vk-sub">${sub}</p>` : ''}
                        </div>
                        ${(itemBlock || countBlock) ? `<div class="vk-body">${itemBlock}${countBlock}</div>` : ''}
                    `,
                    showConfirmButton: true,
                    showCancelButton: showCartButton,
                    confirmButtonText: showCartButton ? 'View bag' : 'Got it',
                    cancelButtonText: 'Keep shopping',
                    buttonsStyling: false,
                    reverseButtons: false,
                    focusConfirm: false,
                    returnFocus: false,
                    timer: 5000,
                    timerProgressBar: true,
                    width: 380,
                    padding: 0,
                    background: '#FBF8F3',
                    customClass: {
                        container: 'vk-container',
                        popup: 'vk-popup',
                        actions: 'vk-actions' + (showCartButton ? '' : ' vk-single'),
                        confirmButton: 'vk-btn vk-confirm',
                        cancelButton: 'vk-btn vk-cancel',
                    },
                    showClass: {
                        popup: 'vk-in'
                    },
                    hideClass: {
                        popup: 'vk-out'
                    },
                    didOpen: (popup) => {
                        popup.addEventListener('mouseenter', Swal.stopTimer);
                        popup.addEventListener('mouseleave', Swal.resumeTimer);
                    },
                }).then((result) => {
                    if (result.isConfirmed && showCartButton) window.location.href = CART_URL;
                });
            };

            window.vukaSuccess = function (message = '', title = 'Success') {
                return window.vukaCartAdded({ title, message, showCartButton: false });
            };

            if (typeof Swal !== 'undefined' && !Swal.__vukaPatched) {
                const nativeFire = Swal.fire.bind(Swal);
                Swal.fire = function (...args) {
                    const o = args[0];
                    if (typeof o === 'string' && args[2] === 'success') {
                        return window.vukaSuccess(args[1] || '', o);
                    }
                    if (o && typeof o === 'object' && o.icon === 'success' && !o.customClass && !o.html) {
                        return window.vukaSuccess(o.text || '', o.title || 'Success');
                    }
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
                        window.vukaCartAdded({
                            title: 'Success',
                            message: @json((string) $flashSuccess),
                            showCartButton: false
                        });
                    @endif
                });
            @endif
        })();
    </script>
</head>

<body class="text-ink pb-24 lg:pb-0 antialiased" x-data="{ mobileSearchOpen: false, menuOpen: false, scrolled: false }"
    x-effect="document.body.classList.toggle('overflow-hidden', menuOpen || mobileSearchOpen)"
    @scroll.window.passive="scrolled = window.scrollY > 8"
    @resize.window="if (window.innerWidth >= 1024) { menuOpen = false; mobileSearchOpen = false }"
    @keydown.escape.window="menuOpen = false; mobileSearchOpen = false">

    <div x-data="{ show: true }" x-show="show" x-cloak class="bg-navy text-white text-xs sm:text-[13px]">
        <div class="max-w-7xl mx-auto px-4 py-2 flex items-center justify-center gap-2 relative">
            <i class="fas fa-gem text-gold text-[11px]"></i>
            <p class="text-center font-light tracking-wide pr-6 sm:pr-0">Complimentary delivery on orders over KSh 10,000. Bridal fittings by appointment.</p>
            <button @click="show = false" aria-label="Dismiss announcement"
                class="absolute right-3 top-1/2 -translate-y-1/2 h-6 w-6 rounded-full flex items-center justify-center text-white/70 hover:text-white hover:bg-white/10 transition-colors">
                <i class="fas fa-times text-[11px]"></i>
            </button>
        </div>
    </div>

    <header class="sticky top-0 z-30 bg-paper/90 backdrop-blur-md border-b border-line transition-shadow duration-200"
        :class="scrolled ? 'shadow-[0_6px_20px_-12px_rgba(27,42,74,0.28)]' : ''">
        <div class="max-w-7xl mx-auto px-4 h-16 flex items-center gap-3 lg:gap-6">

            <button @click="menuOpen = true"
                class="lg:hidden h-10 w-10 shrink-0 rounded-full bg-white border border-line flex items-center justify-center text-ink shadow-sm hover:bg-line/50 transition-colors"
                aria-label="Open menu" :aria-expanded="menuOpen.toString()" aria-controls="mobile-drawer">
                <i class="fas fa-bars text-sm"></i>
            </button>

            <a href="{{ route('home') }}" class="shrink-0 max-lg:mx-auto lg:mx-0" aria-label="Mawaddabridals home">
                <img src="{{ asset('images/mawaddabridals-logo.svg') }}" alt="Mawaddabridals" class="h-10 sm:h-11 w-auto">
            </a>

            <form action="{{ route('search') }}" method="GET" role="search" x-data="{ q: '', focused: false }"
                @keydown.slash.window="if (!['INPUT','TEXTAREA','SELECT'].includes(document.activeElement.tagName) && window.innerWidth >= 1024) { $event.preventDefault(); $refs.q.focus(); }"
                class="hidden lg:flex flex-1 max-w-xl items-center gap-2 rounded-full pl-5 pr-1.5 h-11 transition-all duration-200"
                :class="focused
                    ?
                    'bg-white shadow-[0_10px_30px_-10px_rgba(201,169,110,0.4)]' :
                    'bg-ink/[0.04] hover:bg-ink/[0.07]'">

                <input x-ref="q" x-model="q" @focus="focused = true" @blur="focused = false" type="text"
                    name="q" placeholder="Search dresses, fragrances, shoes, hijabs…" autocomplete="off" enterkeyhint="search"
                    aria-label="Search products"
                    class="bg-transparent border-0 outline-none ring-0 focus:ring-0 focus:outline-none w-full text-sm placeholder:text-muted/70">

                <button type="button" x-show="q.length > 0" x-cloak @click="q = ''; $refs.q.focus()"
                    aria-label="Clear search"
                    class="h-7 w-7 shrink-0 rounded-full flex items-center justify-center text-muted hover:text-ink hover:bg-ink/5 transition-colors">
                    <i class="fas fa-times text-xs"></i>
                </button>

                <kbd x-show="q.length === 0 && !focused"
                    class="hidden xl:inline-flex items-center justify-center h-6 min-w-[24px] px-1.5 rounded-md bg-white/80 shadow-sm text-[11px] font-semibold text-muted">/</kbd>

                <button type="submit" aria-label="Search"
                    class="h-8 w-8 shrink-0 rounded-full bg-gold text-ink flex items-center justify-center hover:bg-gold/90 active:scale-95 transition-all">
                    <i class="fas fa-search text-xs"></i>
                </button>
            </form>

            <nav class="hidden lg:flex items-center gap-6 text-[13px] font-medium tracking-wide text-ink/80 ml-auto"
                aria-label="Primary">
                <a href="#" class="inline-flex items-center gap-1.5 text-gold hover:text-gold/80 transition-colors">
                    <i class="fas fa-gem text-xs"></i> Bridal
                </a>
                <a href="#" class="hover:text-gold transition-colors">New In</a>
                <a href="#" class="hover:text-gold transition-colors">Fragrance</a>
                <a href="#" class="hover:text-gold transition-colors">Support</a>
            </nav>

            <div class="hidden lg:flex items-center gap-3">
                <div class="flex items-center gap-1 text-lg text-ink/70">
                    <a href="{{ route('wishlist.index') }}"
                        class="relative h-10 w-10 rounded-full flex items-center justify-center hover:text-rose-400 hover:bg-white transition-colors"
                        aria-label="Wishlist">
                        <i class="far fa-heart"></i>
                        <span x-show="$store.wishlist.count > 0" x-text="$store.wishlist.count"
                            class="absolute top-0.5 right-0.5 bg-rose-400 text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center"></span>
                    </a>
                    <a href="{{ route('cart.index') }}"
                        class="relative h-10 w-10 rounded-full flex items-center justify-center hover:text-gold hover:bg-white transition-colors"
                        aria-label="Shopping bag">
                        <i class="fas fa-shopping-bag"></i>
                        <span x-show="$store.cart.count > 0" x-text="$store.cart.count"
                            class="absolute top-0.5 right-0.5 bg-gold text-ink text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center"></span>
                    </a>
                </div>

                <span class="h-6 w-px bg-line" aria-hidden="true"></span>

                @auth
                    <div class="relative" x-data="{ open: false }" @click.outside="open = false"
                        @keydown.escape="open = false">
                        <button @click="open = !open"
                            class="h-10 pl-3 pr-3.5 rounded-full bg-white border border-line flex items-center gap-2 text-sm font-medium hover:bg-line/40 transition-colors"
                            aria-haspopup="true" :aria-expanded="open.toString()">
                            <i class="fas fa-user-circle text-gold text-base"></i>
                            Account
                            <i class="fas fa-chevron-down text-[10px] text-muted transition-transform"
                                :class="open ? 'rotate-180' : ''"></i>
                        </button>

                        <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 -translate-y-1 scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-52 origin-top-right bg-white border border-line rounded-2xl shadow-xl p-1.5">
                            <a href="{{ route('dashboard') }}"
                                class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm font-medium hover:bg-paper transition-colors">
                                <i class="fas fa-gauge text-gold w-4 text-center"></i> Dashboard
                            </a>
                            <a href="{{ route('cart.index') }}"
                                class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm font-medium hover:bg-paper transition-colors">
                                <i class="fas fa-shopping-bag text-gold w-4 text-center"></i> My Bag
                            </a>
                            <a href="{{ route('wishlist.index') }}"
                                class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm font-medium hover:bg-paper transition-colors">
                                <i class="far fa-heart text-rose-400 w-4 text-center"></i> My Wishlist
                                <span x-show="$store.wishlist.count > 0" x-text="$store.wishlist.count"
                                    class="ml-auto bg-rose-400 text-white text-[10px] font-bold w-5 h-5 rounded-full flex items-center justify-center"></span>
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm font-medium text-left hover:bg-paper transition-colors">
                                    <i class="fas fa-arrow-right-from-bracket text-muted w-4 text-center"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                        class="text-sm font-medium px-4 py-2.5 rounded-full text-ink hover:bg-white transition-colors whitespace-nowrap tracking-wide">Log
                        in</a>
                    <a href="{{ route('register') }}"
                        class="text-sm font-medium tracking-wide px-5 py-2.5 rounded-full bg-navy text-white hover:bg-navy/90 transition-colors shadow-[0_8px_18px_-6px_rgba(27,42,74,0.55)]">Register</a>
                @endauth
            </div>

            <div class="lg:hidden flex items-center gap-2 shrink-0">
                <button @click="mobileSearchOpen = true"
                    class="h-10 w-10 rounded-full bg-white border border-line flex items-center justify-center text-ink shadow-sm hover:bg-line/50 transition-colors"
                    aria-label="Search">
                    <i class="fas fa-search text-sm"></i>
                </button>
                <a href="{{ route('wishlist.index') }}"
                    class="relative h-10 w-10 rounded-full bg-white border border-line flex items-center justify-center text-ink shadow-sm hover:bg-line/50 transition-colors"
                    aria-label="Wishlist">
                    <i class="far fa-heart text-sm"></i>
                    <span x-show="$store.wishlist.count > 0" x-text="$store.wishlist.count"
                        class="absolute -top-1 -right-1 bg-rose-400 text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center"></span>
                </a>
                <a href="{{ route('cart.index') }}"
                    class="relative h-10 w-10 rounded-full bg-white border border-line flex items-center justify-center text-ink shadow-sm hover:bg-line/50 transition-colors"
                    aria-label="Shopping bag">
                    <i class="fas fa-shopping-bag text-sm"></i>
                    <span x-show="$store.cart.count > 0" x-text="$store.cart.count"
                        class="absolute -top-1 -right-1 bg-gold text-ink text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center"></span>
                </a>
            </div>
        </div>
    </header>

    <div class="lg:hidden" x-show="menuOpen" x-cloak>
        <div x-show="menuOpen" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @click="menuOpen = false"
            class="fixed inset-0 z-50 bg-navy/50 backdrop-blur-sm" aria-hidden="true"></div>

        <aside id="mobile-drawer" x-show="menuOpen" x-trap.noscroll="menuOpen"
            x-transition:enter="transition ease-out duration-250 transform"
            x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full" role="dialog" aria-modal="true" aria-label="Main menu"
            class="fixed inset-y-0 left-0 z-50 w-[86%] max-w-sm bg-paper shadow-2xl flex flex-col"
            style="padding-top: env(safe-area-inset-top); padding-bottom: env(safe-area-inset-bottom);">

            <div class="flex items-center justify-between px-5 h-16 border-b border-line shrink-0">
                <a href="{{ route('home') }}" @click="menuOpen = false" aria-label="Mawaddabridals home">
                    <img src="{{ asset('images/mawaddabridals-logo.svg') }}" alt="Mawaddabridals" class="h-9 w-auto">
                </a>
                <button @click="menuOpen = false"
                    class="h-10 w-10 rounded-full bg-white border border-line flex items-center justify-center text-ink hover:bg-line/50 transition-colors"
                    aria-label="Close menu">
                    <i class="fas fa-times text-sm"></i>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto no-scrollbar px-5 py-5 space-y-6">

                <form action="{{ route('search') }}" method="GET" role="search" x-data="{ q: '', focused: false }"
                    class="flex items-center gap-2 rounded-full pl-5 pr-1.5 h-11 transition-all duration-200"
                    :class="focused
                        ?
                        'bg-white shadow-[0_10px_30px_-10px_rgba(201,169,110,0.4)]' :
                        'bg-ink/[0.04] hover:bg-ink/[0.07]'">

                    <input x-model="q" @focus="focused = true" @blur="focused = false" type="text"
                        name="q" placeholder="Search dresses, fragrances…" autocomplete="off"
                        enterkeyhint="search" aria-label="Search products"
                        class="bg-transparent border-0 outline-none ring-0 focus:ring-0 focus:outline-none w-full text-sm placeholder:text-muted/70 search-input">

                    <button type="button" x-show="q.length > 0" x-cloak
                        @click="q = ''; $el.previousElementSibling.focus()" aria-label="Clear search"
                        class="h-7 w-7 shrink-0 rounded-full flex items-center justify-center text-muted hover:text-ink hover:bg-ink/5 transition-colors">
                        <i class="fas fa-times text-xs"></i>
                    </button>

                    <button type="submit" aria-label="Search"
                        class="h-8 w-8 shrink-0 rounded-full bg-gold text-ink flex items-center justify-center hover:bg-gold/90 active:scale-95 transition-all">
                        <i class="fas fa-search text-xs"></i>
                    </button>
                </form>

                <nav class="space-y-1" aria-label="Quick links">
                    <a href="#" @click="menuOpen = false"
                        class="flex items-center gap-3 px-3 py-3 rounded-xl text-[15px] font-medium text-gold hover:bg-white transition-colors">
                        <i class="fas fa-gem w-5 text-center"></i> Bridal Collection
                    </a>
                    <a href="{{ route('cart.index') }}" @click="menuOpen = false"
                        class="flex items-center gap-3 px-3 py-3 rounded-xl text-[15px] font-medium hover:bg-white transition-colors">
                        <i class="fas fa-shopping-bag w-5 text-center text-gold"></i>
                        My Bag
                        <span x-show="$store.cart.count > 0" x-text="$store.cart.count"
                            class="ml-auto bg-gold text-ink text-[10px] font-bold w-5 h-5 rounded-full flex items-center justify-center"></span>
                    </a>
                    <a href="{{ route('wishlist.index') }}" @click="menuOpen = false"
                        class="flex items-center gap-3 px-3 py-3 rounded-xl text-[15px] font-medium hover:bg-white transition-colors">
                        <i class="far fa-heart w-5 text-center text-rose-400"></i>
                        My Wishlist
                        <span x-show="$store.wishlist.count > 0" x-text="$store.wishlist.count"
                            class="ml-auto bg-rose-400 text-white text-[10px] font-bold w-5 h-5 rounded-full flex items-center justify-center"></span>
                    </a>
                    <a href="#" @click="menuOpen = false"
                        class="flex items-center gap-3 px-3 py-3 rounded-xl text-[15px] font-medium hover:bg-white transition-colors">
                        <i class="fas fa-spray-can-sparkles w-5 text-center text-gold"></i> Fragrance
                    </a>
                    <a href="#" @click="menuOpen = false"
                        class="flex items-center gap-3 px-3 py-3 rounded-xl text-[15px] font-medium hover:bg-white transition-colors">
                        <i class="fas fa-truck-fast w-5 text-center text-gold"></i> Track Order
                    </a>
                    <a href="#" @click="menuOpen = false"
                        class="flex items-center gap-3 px-3 py-3 rounded-xl text-[15px] font-medium hover:bg-white transition-colors">
                        <i class="fas fa-headset w-5 text-center text-gold"></i> Support
                    </a>
                </nav>

                @if ($categories->isNotEmpty())
                    <div x-data="{ open: true }">
                        <button @click="open = !open"
                            class="w-full flex items-center justify-between px-3 mb-2 text-xs font-semibold tracking-luxe uppercase text-muted"
                            :aria-expanded="open.toString()">
                            Collections
                            <i class="fas fa-chevron-down text-[10px] transition-transform"
                                :class="open ? 'rotate-180' : ''"></i>
                        </button>
                        <div x-show="open" x-collapse.duration.200ms class="space-y-1">
                            @foreach ($categories as $category)
                                <a href="{{ route('category.show', $category->slug) }}" @click="menuOpen = false"
                                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[15px] font-medium hover:bg-white transition-colors">
                                    <span
                                        class="h-8 w-8 rounded-full bg-white border border-line flex items-center justify-center shrink-0">
                                        @if ($category->icon)
                                            <i class="fas {{ $category->icon }} text-xs text-gold"></i>
                                        @else
                                            <i class="fas fa-tag text-xs text-gold"></i>
                                        @endif
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
                        <a href="{{ route('dashboard') }}"
                            class="inline-flex items-center justify-center gap-2 rounded-full bg-navy text-white text-sm font-medium py-3 hover:bg-navy/90 transition-colors">
                            <i class="fas fa-gauge text-xs"></i> Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full inline-flex items-center justify-center gap-2 rounded-full bg-paper border border-line text-sm font-medium py-3 hover:bg-line/60 transition-colors">
                                <i class="fas fa-arrow-right-from-bracket text-xs"></i> Logout
                            </button>
                        </form>
                    </div>
                @else
                    <div class="grid grid-cols-2 gap-2.5">
                        <a href="{{ route('login') }}"
                            class="inline-flex items-center justify-center rounded-full bg-paper border border-line text-sm font-medium py-3 hover:bg-line/60 transition-colors">
                            Log in
                        </a>
                        <a href="{{ route('register') }}"
                            class="inline-flex items-center justify-center rounded-full bg-navy text-white text-sm font-medium py-3 hover:bg-navy/90 transition-colors">
                            Register
                        </a>
                    </div>
                @endauth
            </div>
        </aside>
    </div>

    <div x-show="mobileSearchOpen" x-cloak x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" @click.self="mobileSearchOpen = false" x-init="$watch('mobileSearchOpen', v => v && $nextTick(() => $refs.mobileSearchInput.focus()))"
        class="lg:hidden fixed inset-0 z-50 bg-navy/40 backdrop-blur-sm flex items-start justify-center pt-20 px-4"
        role="dialog" aria-modal="true" aria-label="Search">
        <div x-show="mobileSearchOpen" x-transition:enter="transition ease-out duration-200 delay-75"
            x-transition:enter-start="opacity-0 -translate-y-3" x-transition:enter-end="opacity-100 translate-y-0"
            class="bg-white rounded-2xl p-4 w-full max-w-md shadow-2xl" x-data="{ q: '', focused: false }">

            <form action="{{ route('search') }}" method="GET" role="search" @submit="mobileSearchOpen = false">
                <div class="flex items-center gap-2 rounded-full pl-5 pr-1.5 h-11 transition-all duration-200"
                    :class="focused
                        ?
                        'bg-white shadow-[0_10px_30px_-10px_rgba(201,169,110,0.4)]' :
                        'bg-ink/[0.04] hover:bg-ink/[0.07]'">
                    <input x-ref="mobileSearchInput" x-model="q" @focus="focused = true" @blur="focused = false"
                        type="text" name="q" placeholder="Search dresses, fragrances…" autocomplete="off"
                        enterkeyhint="search" aria-label="Search products"
                        class="bg-transparent border-0 outline-none ring-0 focus:ring-0 focus:outline-none w-full text-sm placeholder:text-muted/70 search-input">
                    <button type="button" x-show="q.length > 0" x-cloak
                        @click="q = ''; $refs.mobileSearchInput.focus()"
                        class="h-7 w-7 shrink-0 rounded-full flex items-center justify-center text-muted hover:text-ink hover:bg-ink/5 transition-colors"
                        aria-label="Clear search">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                    <button type="submit" aria-label="Search"
                        class="h-8 w-8 shrink-0 rounded-full bg-gold text-ink flex items-center justify-center hover:bg-gold/90 active:scale-95 transition-all">
                        <i class="fas fa-search text-xs"></i>
                    </button>
                </div>
            </form>

            <button @click="mobileSearchOpen = false"
                class="mt-3 w-full py-2.5 rounded-full bg-paper text-ink/70 font-medium text-sm hover:bg-line transition-colors">
                <i class="fas fa-times mr-1"></i> Cancel
            </button>
        </div>
    </div>

    <main class="max-w-7xl mx-auto px-4">

        <div class="relative rounded-xl2 overflow-hidden shadow-lg my-4" x-data="carousel"
            x-init="start()" @mouseenter="stop()" @mouseleave="start()">
            <div class="flex transition-transform duration-500 ease-out"
                :style="`transform: translateX(-${current * 100}%)`" @touchstart="onTouchStart($event)"
                @touchend="onTouchEnd($event)">
                @php
                    $slides = [
                        [
                            'eyebrow' => 'The bridal edit',
                            'title' => 'Say yes in style',
                            'sub' => 'Handpicked gowns, veils and hijabs for your big day.',
                            'cta' => 'Explore bridal',
                            'icon' => 'fa-ring',
                            'grad' => 'linear-gradient(135deg, #1B2A4A 0%, #2E3F63 100%)',
                        ],
                        [
                            'eyebrow' => 'Just arrived',
                            'title' => 'New season',
                            'sub' => 'Fragrances, footwear and everyday elegance.',
                            'cta' => 'Shop new in',
                            'icon' => 'fa-spray-can-sparkles',
                            'grad' => 'linear-gradient(135deg, #2A2438 0%, #4A3A5C 100%)',
                        ],
                        [
                            'eyebrow' => 'For the whole family',
                            'title' => 'Wardrobe essentials',
                            'sub' => 'Clothing and accessories for women, men and children.',
                            'cta' => 'Shop now',
                            'icon' => 'fa-tshirt',
                            'grad' => 'linear-gradient(135deg, #1B2A4A 0%, #3B4A6B 100%)',
                        ],
                    ];
                @endphp
                @foreach ($slides as $slide)
                    <div class="min-w-full px-6 py-10 sm:px-12 sm:py-16 relative flex flex-col justify-center text-white"
                        style="background-image: {{ $slide['grad'] }};">
                        <div class="absolute inset-0 bg-gradient-to-br from-black/55 via-black/15 to-transparent">
                        </div>
                        <div class="relative z-10 max-w-xs sm:max-w-md">
                            <span class="inline-flex items-center gap-2 text-sm text-white/75 mb-2 tracking-wide">
                                <i class="fas {{ $slide['icon'] }} text-gold"></i>{{ $slide['eyebrow'] }}
                            </span>
                            <h2 class="font-serif text-3xl sm:text-5xl font-semibold tracking-tight leading-[1.05]">
                                {{ $slide['title'] }}</h2>
                            <p class="text-white/80 mt-3 mb-5 text-sm sm:text-base">{{ $slide['sub'] }}</p>
                            <button
                                class="inline-flex items-center gap-2 bg-gold text-ink font-semibold tracking-wide px-6 py-2.5 rounded-full hover:bg-gold/90 transition-colors text-sm">
                                {{ $slide['cta'] }} <i class="fas fa-arrow-right text-xs"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="absolute bottom-4 right-5 flex gap-2">
                <template x-for="i in 3" :key="i">
                    <button @click="goTo(i - 1)" :class="current === i - 1 ? 'w-6 bg-white' : 'w-2 bg-white/40'"
                        class="h-2 rounded-full transition-all" :aria-label="`Slide ${i}`"></button>
                </template>
            </div>
        </div>

        <div class="flex gap-2.5 overflow-x-auto no-scrollbar py-1 pb-5" x-data="{ active: 'All' }">
            <a href="#"
                class="flex items-center gap-2 whitespace-nowrap border border-navy bg-navy text-white rounded-full px-4 py-2 text-sm font-medium tracking-wide shadow-sm transition-colors">
                <i class="fas fa-gem text-xs text-gold"></i>
                All
            </a>
            @foreach ($categories as $category)
                <a href="{{ route('category.show', $category->slug) }}"
                    class="flex items-center gap-2 whitespace-nowrap border border-line bg-white text-ink rounded-full px-4 py-2 text-sm font-medium shadow-sm transition-colors hover:border-gold/60">
                    @if ($category->icon)
                        <i class="fas {{ $category->icon }} text-xs text-gold"></i>
                    @endif
                    {{ $category->name }}
                </a>
            @endforeach
        </div>

        @if ($featured->isNotEmpty())
            <div class="flex items-baseline justify-between mt-2 mb-3">
                <h3 class="font-serif text-2xl font-semibold flex items-center gap-2 tracking-tight">
                    <i class="fas fa-crown text-gold text-base"></i> Featured
                </h3>
                <a href="#"
                    class="text-navy font-medium text-sm flex items-center gap-1.5 hover:text-gold transition-colors tracking-wide">
                    See all <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3.5 mb-8">
                @foreach ($featured as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        @endif

        <div class="flex items-baseline justify-between mt-2 mb-3">
            <h3 class="font-serif text-2xl font-semibold flex items-center gap-2 tracking-tight">
                <i class="fas fa-fire text-gold text-base"></i> Popular right now
            </h3>
            <a href="#"
                class="text-navy font-medium text-sm flex items-center gap-1.5 hover:text-gold transition-colors tracking-wide">
                See all <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>

        @if ($popular->isEmpty())
            <div class="bg-white rounded-2xl border border-line p-8 text-center mb-8">
                <i class="fas fa-box-open text-3xl text-muted/40 mb-3"></i>
                <p class="text-sm text-muted">No pieces yet. Check back soon!</p>
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3.5 mb-8">
                @foreach ($popular as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        @endif

        <div
            class="relative overflow-hidden rounded-xl2 bg-navy text-white px-6 py-8 sm:px-10 sm:py-10 mt-8 flex flex-col gap-2">
            <i class="fas fa-ring absolute -right-2 bottom-0 text-[7rem] text-white/[0.06] rotate-[-8deg]"></i>
            <h4 class="font-serif text-xl sm:text-2xl font-semibold flex items-center gap-2 relative z-10 tracking-tight">
                <i class="fas fa-gem text-gold"></i> Complimentary delivery over KSh 10,000
            </h4>
            <p class="text-white/70 text-sm relative z-10">Nationwide delivery, with M-Pesa and card accepted at
                checkout. Bridal consultations available in store.</p>
            <button
                class="relative z-10 self-start mt-2 inline-flex items-center gap-2 bg-gold text-ink font-semibold tracking-wide px-6 py-2.5 rounded-full hover:bg-gold/90 transition-colors text-sm">
                <i class="fas fa-shopping-bag"></i> Shop now
            </button>
        </div>

        <div class="flex items-baseline justify-between mt-9 mb-4">
            <h3 class="font-serif text-2xl font-semibold flex items-center gap-2 tracking-tight">
                <i class="fas fa-star text-gold text-base"></i> Best sellers
            </h3>
            <a href="#"
                class="text-navy font-medium text-sm flex items-center gap-1.5 hover:text-gold transition-colors tracking-wide">
                View all <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>

        @if ($bestsellers->isEmpty())
            <div class="bg-white rounded-2xl border border-line p-8 text-center">
                <i class="fas fa-box-open text-3xl text-muted/40 mb-3"></i>
                <p class="text-sm text-muted">No best sellers yet.</p>
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3.5">
                @foreach ($bestsellers as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        @endif

        <div class="relative overflow-hidden rounded-xl2 mt-9 text-white"
            style="background-image: linear-gradient(135deg, #1B2A4A 0%, #2E3F63 100%);">
            <i
                class="fas fa-store absolute -right-3 -bottom-3 text-[9rem] text-white/[0.05] rotate-[-6deg] pointer-events-none"></i>

            <div class="relative z-10 px-6 py-10 sm:px-12 sm:py-14 max-w-2xl">
                <span class="inline-flex items-center gap-2 text-sm text-white/75 mb-2 tracking-wide">
                    <i class="fas fa-handshake text-gold"></i> Partner with us
                </span>

                <h3 class="font-serif text-2xl sm:text-4xl font-semibold tracking-tight leading-[1.1]">
                    Sell on Mawaddabridals.<br class="hidden sm:inline"> Reach brides and fashion lovers.
                </h3>

                <p class="text-white/75 mt-3 mb-6 text-sm sm:text-base max-w-lg">
                    Own a boutique or fragrance label? Partner with Mawaddabridals and list your
                    pieces to customers across the country. Verified vendors, secure payouts,
                    and logistics handled end-to-end.
                </p>

                <div class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-5">
                    <a href="{{ route('vendor.apply') }}"
                        class="inline-flex items-center justify-center gap-2 bg-gold text-ink font-semibold tracking-wide px-7 py-3 rounded-full hover:bg-gold/90 transition-colors text-sm shadow-[0_10px_24px_-8px_rgba(201,169,110,0.7)]">
                        Become a Vendor <i class="fas fa-arrow-right text-xs"></i>
                    </a>

                    <a href="{{ route('login') }}"
                        class="text-xs sm:text-sm text-white/60 hover:text-white/90 transition-colors">
                        Already a vendor? Log in to your dashboard <i class="fas fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white border border-line rounded-xl2 px-5 py-8 sm:py-10 mt-9" x-data="{ email: '', sent: false }">
            <div class="text-center max-w-md mx-auto">
                <div class="w-11 h-11 rounded-full bg-blush flex items-center justify-center mx-auto mb-3 text-gold">
                    <i class="fas fa-envelope"></i>
                </div>
                <h4 class="font-serif text-xl font-semibold tracking-tight">Join the Mawadda list</h4>
                <p class="text-ink/60 text-sm mt-1.5 mb-5">New collections, bridal edits and private offers, straight to your
                    inbox.</p>
                <form class="flex gap-2 flex-wrap justify-center" @submit.prevent="sent = true">
                    <input type="email" x-model="email" placeholder="Your email" required
                        class="flex-1 min-w-[160px] px-5 py-2.5 rounded-full border border-line bg-paper text-sm focus:outline-none focus:ring-2 focus:ring-gold/40 focus:border-transparent search-input">
                    <button type="submit"
                        class="inline-flex items-center gap-2 bg-navy text-white font-semibold tracking-wide px-6 py-2.5 rounded-full hover:bg-navy/90 transition-colors text-sm">
                        <i class="fas" :class="sent ? 'fa-check' : 'fa-paper-plane'"></i>
                        <span x-text="sent ? 'Subscribed' : 'Subscribe'"></span>
                    </button>
                </form>
            </div>
        </div>
    </main>

    <footer class="mt-10 bg-white border-t border-line pt-8 pb-6">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div>
                    <img src="{{ asset('images/mawaddabridals-logo.svg') }}" alt="Mawaddabridals" class="h-9 w-auto">
                    <p class="text-ink/60 text-sm mt-2">Bridal, fashion & fragrance.</p>
                </div>
                <div>
                    <h5 class="font-semibold text-xs tracking-luxe uppercase text-navy mb-2.5">Shop</h5>
                    <ul class="space-y-1.5">
                        <li><a href="#"
                                class="text-ink/60 text-sm hover:text-gold transition-colors">Bridal</a></li>
                        <li><a href="#"
                                class="text-ink/60 text-sm hover:text-gold transition-colors">Fashion</a></li>
                        <li><a href="#" class="text-ink/60 text-sm hover:text-gold transition-colors">Fragrance</a>
                        </li>
                        <li><a href="#" class="text-ink/60 text-sm hover:text-gold transition-colors">Cosmetics</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h5 class="font-semibold text-xs tracking-luxe uppercase text-navy mb-2.5">Support</h5>
                    <ul class="space-y-1.5">
                        <li><a href="#"
                                class="text-ink/60 text-sm hover:text-gold transition-colors">Contact</a></li>
                        <li><a href="#"
                                class="text-ink/60 text-sm hover:text-gold transition-colors">Delivery</a></li>
                        <li><a href="#"
                                class="text-ink/60 text-sm hover:text-gold transition-colors">Returns</a></li>
                        <li><a href="#" class="text-ink/60 text-sm hover:text-gold transition-colors">M-Pesa
                                FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="font-semibold text-xs tracking-luxe uppercase text-navy mb-2.5">Company</h5>
                    <ul class="space-y-1.5">
                        <li><a href="#" class="text-ink/60 text-sm hover:text-gold transition-colors">About</a>
                        </li>
                        <li><a href="{{ route('vendor.apply') }}"
                                class="text-ink/60 text-sm hover:text-gold transition-colors">Become a Vendor</a></li>
                        <li><a href="#"
                                class="text-ink/60 text-sm hover:text-gold transition-colors">Careers</a></li>
                        <li><a href="#"
                                class="text-ink/60 text-sm hover:text-gold transition-colors">Privacy</a></li>
                        <li><a href="#" class="text-ink/60 text-sm hover:text-gold transition-colors">Terms</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div
                class="mt-7 border-t border-line pt-4 flex flex-wrap items-center justify-between gap-3 text-sm text-muted">
                <span>© 2026 Mawaddabridals. All rights reserved.</span>
                <span class="flex gap-4 text-base">
                    <i class="fab fa-twitter hover:text-gold transition-colors cursor-pointer"></i>
                    <i class="fab fa-instagram hover:text-gold transition-colors cursor-pointer"></i>
                    <i class="fab fa-youtube hover:text-gold transition-colors cursor-pointer"></i>
                </span>
            </div>
        </div>
    </footer>

    <nav class="lg:hidden fixed bottom-0 left-0 right-0 z-40 bg-white/95 backdrop-blur-md border-t border-line flex justify-around px-1"
        style="padding-bottom: calc(6px + env(safe-area-inset-bottom));" aria-label="App navigation">
        <a href="{{ route('home') }}"
            class="flex-1 flex flex-col items-center gap-1 py-2.5 text-[11px] font-semibold text-gold">
            <i class="fas fa-home text-base"></i> Home
        </a>
        <button type="button" @click="menuOpen = true"
            class="flex-1 flex flex-col items-center gap-1 py-2.5 text-[11px] font-semibold text-muted">
            <i class="fas fa-th-large text-base"></i> Collections
        </button>
        <a href="{{ route('cart.index') }}"
            class="relative flex-1 flex flex-col items-center gap-1 py-2.5 text-[11px] font-semibold text-muted">
            <i class="fas fa-shopping-bag text-base"></i> Bag
            <span x-data x-show="$store.cart.count > 0" x-text="$store.cart.count"
                class="absolute top-1 right-1/3 w-4 h-4 rounded-full bg-gold text-ink text-[10px] font-bold flex items-center justify-center"></span>
        </a>
        @auth
            <a href="{{ route('dashboard') }}"
                class="flex-1 flex flex-col items-center gap-1 py-2.5 text-[11px] font-semibold text-muted">
                <i class="fas fa-user text-base"></i> Account
            </a>
        @else
            <a href="{{ route('login') }}"
                class="flex-1 flex flex-col items-center gap-1 py-2.5 text-[11px] font-semibold text-muted">
                <i class="fas fa-user text-base"></i> Account
            </a>
        @endauth
    </nav>

    @stack('scripts')
</body>

</html>