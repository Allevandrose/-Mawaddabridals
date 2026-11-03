@php
    $cartCount = auth()->check() ? auth()->user()->cartCount() : 0;
    $wishlistCount = auth()->check() ? auth()->user()->wishlistCount() : 0;
@endphp

<nav x-data="{ open: false }"
     class="bg-[#FBF8F3]/90 backdrop-blur-md border-b border-[#E9E1D6] sticky top-0 z-30"
     style="font-family: 'Jost', ui-sans-serif, system-ui, sans-serif;">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16 gap-3">

            {{-- Logo --}}
            <div class="shrink-0 flex items-center">
                <a href="{{ route('home') }}" aria-label="Mawaddabridals home">
                    <img src="{{ asset('images/mawaddabridals-logo.svg') }}" alt="Mawaddabridals" class="h-10 sm:h-11 w-auto">
                </a>
            </div>

            {{-- Desktop nav links --}}
            <div class="hidden sm:flex items-center gap-1 sm:ms-6 flex-1">
                <a href="{{ route('dashboard') }}"
                   class="inline-flex items-center px-3 py-2 rounded-full text-sm font-medium tracking-wide transition-colors
                          {{ request()->routeIs('dashboard')
                              ? 'bg-white text-[#1B2A4A] shadow-sm'
                              : 'text-[#1B2A4A]/75 hover:bg-white/70 hover:text-[#C9A96E]' }}">
                    Dashboard
                </a>

                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}"
                           class="inline-flex items-center px-3 py-2 rounded-full text-sm font-medium tracking-wide transition-colors
                                  {{ request()->routeIs('admin.dashboard')
                                      ? 'bg-white text-[#1B2A4A] shadow-sm'
                                      : 'text-[#1B2A4A]/75 hover:bg-white/70 hover:text-[#C9A96E]' }}">
                            Admin Panel
                        </a>
                    @endif

                    @if(auth()->user()->isCustomer())
                        <a href="{{ route('home') }}"
                           class="inline-flex items-center px-3 py-2 rounded-full text-sm font-medium tracking-wide transition-colors
                                  {{ request()->routeIs('home')
                                      ? 'bg-white text-[#1B2A4A] shadow-sm'
                                      : 'text-[#1B2A4A]/75 hover:bg-white/70 hover:text-[#C9A96E]' }}">
                            Shop
                        </a>
                        <a href="#"
                           class="inline-flex items-center px-3 py-2 rounded-full text-sm font-medium text-[#1B2A4A]/40 hover:bg-white/50 transition-colors cursor-not-allowed"
                           title="Coming soon">
                            Orders
                        </a>
                    @endif

                    @if(auth()->user()->isDelivery())
                        <a href="{{ route('delivery.dashboard') }}"
                           class="inline-flex items-center px-3 py-2 rounded-full text-sm font-medium tracking-wide transition-colors
                                  {{ request()->routeIs('delivery.dashboard')
                                      ? 'bg-white text-[#1B2A4A] shadow-sm'
                                      : 'text-[#1B2A4A]/75 hover:bg-white/70 hover:text-[#C9A96E]' }}">
                            Deliveries
                        </a>
                    @endif

                    @if(auth()->user()->isPickup())
                        <a href="{{ route('pickup.dashboard') }}"
                           class="inline-flex items-center px-3 py-2 rounded-full text-sm font-medium tracking-wide transition-colors
                                  {{ request()->routeIs('pickup.dashboard')
                                      ? 'bg-white text-[#1B2A4A] shadow-sm'
                                      : 'text-[#1B2A4A]/75 hover:bg-white/70 hover:text-[#C9A96E]' }}">
                            Pickups
                        </a>
                    @endif

                    @if(auth()->user()->isVendor())
                        <a href="{{ route('vendor.dashboard') }}"
                           class="inline-flex items-center px-3 py-2 rounded-full text-sm font-medium tracking-wide transition-colors
                                  {{ request()->routeIs('vendor.dashboard')
                                      ? 'bg-white text-[#1B2A4A] shadow-sm'
                                      : 'text-[#1B2A4A]/75 hover:bg-white/70 hover:text-[#C9A96E]' }}">
                            My Boutique
                        </a>
                        <a href="{{ route('vendor.products.index') }}"
                           class="inline-flex items-center px-3 py-2 rounded-full text-sm font-medium tracking-wide transition-colors
                                  {{ request()->routeIs('vendor.products.*')
                                      ? 'bg-white text-[#1B2A4A] shadow-sm'
                                      : 'text-[#1B2A4A]/75 hover:bg-white/70 hover:text-[#C9A96E]' }}">
                            My Products
                        </a>
                    @endif
                @endauth
            </div>

            {{-- Right side: wishlist + bag icons + account dropdown --}}
            <div class="hidden sm:flex items-center gap-2 sm:ms-6">

                {{-- Wishlist --}}
                <a href="{{ route('wishlist.index') }}"
                   aria-label="Wishlist"
                   class="relative h-10 w-10 rounded-full bg-white border border-[#E9E1D6] flex items-center justify-center text-[#1B2A4A]/70 hover:text-[#C08497] hover:bg-white transition-colors shadow-sm">
                    <i class="far fa-heart text-sm"></i>
                    @if ($wishlistCount > 0)
                        <span class="absolute -top-1 -right-1 bg-[#C08497] text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center ring-2 ring-[#FBF8F3]">
                            {{ $wishlistCount }}
                        </span>
                    @endif
                </a>

                {{-- Shopping bag --}}
                <a href="{{ route('cart.index') }}"
                   aria-label="Shopping bag"
                   class="relative h-10 w-10 rounded-full bg-white border border-[#E9E1D6] flex items-center justify-center text-[#1B2A4A]/70 hover:text-[#C9A96E] hover:bg-white transition-colors shadow-sm">
                    <i class="fas fa-shopping-bag text-sm"></i>
                    @if ($cartCount > 0)
                        <span class="absolute -top-1 -right-1 bg-[#C9A96E] text-[#1B2A4A] text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center ring-2 ring-[#FBF8F3]">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

                <span class="h-6 w-px bg-[#E9E1D6]" aria-hidden="true"></span>

                {{-- Account dropdown --}}
                <div x-data="{ open: false }" @click.outside="open = false" @keydown.escape="open = false" class="relative">
                    <button @click="open = !open"
                            class="h-10 pl-3 pr-3.5 rounded-full bg-white border border-[#E9E1D6] flex items-center gap-2 text-sm font-medium text-[#1B2A4A] hover:bg-[#E9E1D6]/40 transition-colors shadow-sm"
                            aria-haspopup="true" :aria-expanded="open.toString()">
                        <i class="fas fa-user-circle text-[#C9A96E] text-base"></i>
                        <span class="max-w-[10rem] truncate">{{ Auth::user()->name }}</span>
                        <i class="fas fa-chevron-down text-[10px] text-[#8A8276] transition-transform"
                           :class="open ? 'rotate-180' : ''"></i>
                    </button>

                    <div x-show="open" x-cloak
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 -translate-y-1 scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-60 origin-top-right bg-white border border-[#E9E1D6] rounded-2xl shadow-xl p-1.5 z-40">

                        <div class="px-3 py-2 border-b border-[#E9E1D6]/70 mb-1">
                            <p class="text-sm font-semibold text-[#1B2A4A] truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-[#8A8276] truncate">{{ Auth::user()->email }}</p>
                            <p class="text-[11px] text-[#8A8276] mt-1">
                                Role: <span class="font-semibold text-[#C9A96E]">{{ ucfirst(Auth::user()->user_type) }}</span>
                            </p>
                        </div>

                        <a href="{{ route('profile.edit') }}"
                           class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm font-medium text-[#1B2A4A] hover:bg-[#FBF8F3] transition-colors">
                            <i class="fas fa-user text-[#C9A96E] w-4 text-center"></i> Profile
                        </a>

                        <a href="{{ route('dashboard') }}"
                           class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm font-medium text-[#1B2A4A] hover:bg-[#FBF8F3] transition-colors">
                            <i class="fas fa-gauge text-[#C9A96E] w-4 text-center"></i> Dashboard
                        </a>

                        <a href="{{ route('cart.index') }}"
                           class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm font-medium text-[#1B2A4A] hover:bg-[#FBF8F3] transition-colors">
                            <i class="fas fa-shopping-bag text-[#C9A96E] w-4 text-center"></i> My Bag
                            @if ($cartCount > 0)
                                <span class="ml-auto bg-[#C9A96E] text-[#1B2A4A] text-[10px] font-bold w-5 h-5 rounded-full flex items-center justify-center">{{ $cartCount }}</span>
                            @endif
                        </a>

                        <a href="{{ route('wishlist.index') }}"
                           class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm font-medium text-[#1B2A4A] hover:bg-[#FBF8F3] transition-colors">
                            <i class="far fa-heart text-[#C08497] w-4 text-center"></i> My Wishlist
                            @if ($wishlistCount > 0)
                                <span class="ml-auto bg-[#C08497] text-white text-[10px] font-bold w-5 h-5 rounded-full flex items-center justify-center">{{ $wishlistCount }}</span>
                            @endif
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm font-medium text-left text-[#1B2A4A] hover:bg-[#FBF8F3] transition-colors">
                                <i class="fas fa-arrow-right-from-bracket text-[#8A8276] w-4 text-center"></i> Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Mobile right-side actions + hamburger --}}
            <div class="flex sm:hidden items-center gap-2 -me-2">
                <a href="{{ route('wishlist.index') }}"
                   aria-label="Wishlist"
                   class="relative h-10 w-10 rounded-full bg-white border border-[#E9E1D6] flex items-center justify-center text-[#1B2A4A]/70 shadow-sm">
                    <i class="far fa-heart text-sm"></i>
                    @if ($wishlistCount > 0)
                        <span class="absolute -top-1 -right-1 bg-[#C08497] text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center ring-2 ring-[#FBF8F3]">
                            {{ $wishlistCount }}
                        </span>
                    @endif
                </a>
                <a href="{{ route('cart.index') }}"
                   aria-label="Shopping bag"
                   class="relative h-10 w-10 rounded-full bg-white border border-[#E9E1D6] flex items-center justify-center text-[#1B2A4A]/70 shadow-sm">
                    <i class="fas fa-shopping-bag text-sm"></i>
                    @if ($cartCount > 0)
                        <span class="absolute -top-1 -right-1 bg-[#C9A96E] text-[#1B2A4A] text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center ring-2 ring-[#FBF8F3]">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-white border border-[#E9E1D6] text-[#1B2A4A]/70 hover:bg-[#E9E1D6]/40 transition-colors shadow-sm"
                        aria-label="Toggle menu">
                    <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-[#E9E1D6] bg-[#FBF8F3]">
        <div class="px-4 py-4 space-y-1">

            <a href="{{ route('dashboard') }}"
               class="block px-3 py-2.5 rounded-xl text-sm font-medium transition-colors
                      {{ request()->routeIs('dashboard')
                          ? 'bg-white text-[#1B2A4A] shadow-sm'
                          : 'text-[#1B2A4A]/85 hover:bg-white/70' }}">
                Dashboard
            </a>

            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}"
                       class="block px-3 py-2.5 rounded-xl text-sm font-medium transition-colors
                              {{ request()->routeIs('admin.dashboard')
                                  ? 'bg-white text-[#1B2A4A] shadow-sm'
                                  : 'text-[#1B2A4A]/85 hover:bg-white/70' }}">
                        Admin Panel
                    </a>
                @endif

                @if(auth()->user()->isCustomer())
                    <a href="{{ route('home') }}"
                       class="block px-3 py-2.5 rounded-xl text-sm font-medium transition-colors
                              {{ request()->routeIs('home')
                                  ? 'bg-white text-[#1B2A4A] shadow-sm'
                                  : 'text-[#1B2A4A]/85 hover:bg-white/70' }}">
                        Shop
                    </a>
                    <a href="#"
                       class="block px-3 py-2.5 rounded-xl text-sm font-medium text-[#1B2A4A]/40 cursor-not-allowed"
                       title="Coming soon">
                        Orders <span class="text-[10px] uppercase tracking-wide bg-white text-[#8A8276] px-1.5 py-0.5 rounded-full ml-1">Soon</span>
                    </a>
                @endif

                @if(auth()->user()->isDelivery())
                    <a href="{{ route('delivery.dashboard') }}"
                       class="block px-3 py-2.5 rounded-xl text-sm font-medium transition-colors
                              {{ request()->routeIs('delivery.dashboard')
                                  ? 'bg-white text-[#1B2A4A] shadow-sm'
                                  : 'text-[#1B2A4A]/85 hover:bg-white/70' }}">
                        Deliveries
                    </a>
                @endif

                @if(auth()->user()->isPickup())
                    <a href="{{ route('pickup.dashboard') }}"
                       class="block px-3 py-2.5 rounded-xl text-sm font-medium transition-colors
                              {{ request()->routeIs('pickup.dashboard')
                                  ? 'bg-white text-[#1B2A4A] shadow-sm'
                                  : 'text-[#1B2A4A]/85 hover:bg-white/70' }}">
                        Pickups
                    </a>
                @endif

                @if(auth()->user()->isVendor())
                    <a href="{{ route('vendor.dashboard') }}"
                       class="block px-3 py-2.5 rounded-xl text-sm font-medium transition-colors
                              {{ request()->routeIs('vendor.dashboard')
                                  ? 'bg-white text-[#1B2A4A] shadow-sm'
                                  : 'text-[#1B2A4A]/85 hover:bg-white/70' }}">
                        My Boutique
                    </a>
                    <a href="{{ route('vendor.products.index') }}"
                       class="block px-3 py-2.5 rounded-xl text-sm font-medium transition-colors
                              {{ request()->routeIs('vendor.products.*')
                                  ? 'bg-white text-[#1B2A4A] shadow-sm'
                                  : 'text-[#1B2A4A]/85 hover:bg-white/70' }}">
                        My Products
                    </a>
                @endif

                {{-- Bag + Wishlist quick entries with badges --}}
                <a href="{{ route('cart.index') }}"
                   class="flex items-center px-3 py-2.5 rounded-xl text-sm font-medium transition-colors
                          {{ request()->routeIs('cart.*')
                              ? 'bg-white text-[#1B2A4A] shadow-sm'
                              : 'text-[#1B2A4A]/85 hover:bg-white/70' }}">
                    <i class="fas fa-shopping-bag text-[#C9A96E] w-5 text-center"></i>
                    <span class="ml-2">My Bag</span>
                    @if ($cartCount > 0)
                        <span class="ml-auto bg-[#C9A96E] text-[#1B2A4A] text-[10px] font-bold w-5 h-5 rounded-full flex items-center justify-center">{{ $cartCount }}</span>
                    @endif
                </a>

                <a href="{{ route('wishlist.index') }}"
                   class="flex items-center px-3 py-2.5 rounded-xl text-sm font-medium transition-colors
                          {{ request()->routeIs('wishlist.*')
                              ? 'bg-white text-[#1B2A4A] shadow-sm'
                              : 'text-[#1B2A4A]/85 hover:bg-white/70' }}">
                    <i class="far fa-heart text-[#C08497] w-5 text-center"></i>
                    <span class="ml-2">My Wishlist</span>
                    @if ($wishlistCount > 0)
                        <span class="ml-auto bg-[#C08497] text-white text-[10px] font-bold w-5 h-5 rounded-full flex items-center justify-center">{{ $wishlistCount }}</span>
                    @endif
                </a>
            @endauth
        </div>

        <div class="px-4 py-4 border-t border-[#E9E1D6] bg-white">
            <div class="mb-3">
                <p class="text-sm font-semibold text-[#1B2A4A] truncate">{{ Auth::user()->name }}</p>
                <p class="text-xs text-[#8A8276] truncate">{{ Auth::user()->email }}</p>
                <p class="text-[11px] text-[#8A8276] mt-1">
                    Role: <span class="font-semibold text-[#C9A96E]">{{ ucfirst(Auth::user()->user_type) }}</span>
                </p>
            </div>

            <div class="grid grid-cols-2 gap-2">
                <a href="{{ route('profile.edit') }}"
                   class="inline-flex items-center justify-center gap-2 rounded-full bg-[#FBF8F3] border border-[#E9E1D6] text-sm font-medium py-2.5 text-[#1B2A4A] hover:bg-[#E9E1D6]/60 transition-colors">
                    <i class="fas fa-user text-xs"></i> Profile
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 rounded-full bg-[#1B2A4A] text-white text-sm font-medium py-2.5 hover:bg-[#1B2A4A]/90 transition-colors">
                        <i class="fas fa-arrow-right-from-bracket text-xs"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>