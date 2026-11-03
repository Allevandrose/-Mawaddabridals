@php
    $icons = [
        'home' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
        'products' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
        'categories' => 'M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z',
        'brands' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z',
        'attributes' => 'M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4',
        'staff' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
        'vendors' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z',
        'reports' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
        'search' => 'M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z',
        'menu' => 'M4 6h16M4 12h16M4 18h16',
        'close' => 'M6 18L18 6M6 6l12 12',
        'profile' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
        'logout' => 'M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1',
    ];

    $navItems = [
        ['label' => 'Home', 'href' => route('admin.dashboard'), 'icon' => 'home'],
        ['label' => 'Products', 'href' => route('admin.products.index'), 'icon' => 'products', 'active' => request()->routeIs('admin.products.*')],
        ['label' => 'Categories', 'href' => route('admin.categories.index'), 'icon' => 'categories', 'active' => request()->routeIs('admin.categories.*')],
        ['label' => 'Brands', 'href' => route('admin.brands.index'), 'icon' => 'brands', 'active' => request()->routeIs('admin.brands.*')],
        ['label' => 'Attributes', 'href' => route('admin.attributes.index'), 'icon' => 'attributes', 'active' => request()->routeIs('admin.attributes.*')],
        ['label' => 'Staff', 'href' => route('admin.staff.index'), 'icon' => 'staff', 'active' => request()->routeIs('admin.staff.*')],
        ['label' => 'Vendors', 'href' => route('admin.vendors.index'), 'icon' => 'vendors', 'active' => request()->routeIs('admin.vendors.*')],
        ['label' => 'Reports', 'href' => '#', 'icon' => 'reports'],
    ];
@endphp

<x-admin-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <div x-data="{ sidebarOpen: true, q: '' }"
         class="flex h-screen w-full overflow-hidden bg-[#FBF8F3] text-[#1B2A4A] selection:bg-[#C9A96E] selection:text-white"
         style="font-family: 'Jost', ui-sans-serif, system-ui, sans-serif;">

        <!-- ============ Expandable Sidebar ============ -->
        <aside :class="sidebarOpen ? 'w-64' : 'w-20'"
               class="relative z-20 flex flex-col border-r border-[#E9E1D6] bg-[#1B2A4A] text-[#FBF8F3] transition-all duration-300 ease-in-out shadow-2xl">

            <div class="flex h-20 items-center justify-center px-4">
                <a href="{{ route('dashboard') }}" class="flex items-center justify-center overflow-hidden">
                    <img src="{{ asset('images/mawaddabridals-logo.svg') }}" alt="Mawaddabridals" class="h-10 w-auto object-contain" style="filter: brightness(0) invert(1);">
                </a>
            </div>

            <button @click="sidebarOpen = !sidebarOpen"
                    class="absolute -right-3 top-24 flex h-6 w-6 items-center justify-center rounded-full bg-[#C9A96E] text-[#1B2A4A] shadow-md hover:bg-[#B89455] focus:outline-none transition-transform duration-300 z-30">
                <svg :class="sidebarOpen ? 'rotate-180' : ''" class="h-3 w-3 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <nav class="mt-6 flex flex-1 flex-col gap-2 px-3 overflow-y-auto overflow-x-hidden">
                @foreach ($navItems as $item)
                    <a href="{{ $item['href'] }}"
                       class="group relative flex items-center gap-3 rounded-xl px-3 py-3 transition-colors
                              {{ ($item['active'] ?? false) ? 'bg-[#C9A96E] text-[#1B2A4A] shadow-md' : 'text-[#FBF8F3]/70 hover:bg-white/5 hover:text-[#E8D5B0]' }}">

                        <span class="flex h-6 w-6 shrink-0 items-center justify-center">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icons[$item['icon']] }}" />
                            </svg>
                        </span>

                        <span x-show="sidebarOpen" x-transition.opacity.duration.200ms class="whitespace-nowrap text-sm font-medium tracking-wide">
                            {{ $item['label'] }}
                        </span>

                        <div x-show="!sidebarOpen" class="absolute left-14 z-50 hidden rounded-md bg-[#C9A96E] px-2 py-1 text-xs font-medium text-[#1B2A4A] group-hover:block">
                            {{ $item['label'] }}
                        </div>
                    </a>
                @endforeach
            </nav>

            <div class="border-t border-white/10 p-4 space-y-2">
                <div class="flex flex-col gap-1">
                    <a href="{{ route('profile.edit') }}"
                       class="group relative flex items-center gap-3 rounded-xl px-3 py-3 transition-colors text-[#FBF8F3]/70 hover:bg-white/5 hover:text-[#E8D5B0]">
                        <span class="flex h-6 w-6 shrink-0 items-center justify-center">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icons['profile'] }}" />
                            </svg>
                        </span>
                        <span x-show="sidebarOpen" x-transition.opacity.duration.200ms class="whitespace-nowrap text-sm font-medium">Profile</span>
                        <div x-show="!sidebarOpen" class="absolute left-14 z-50 hidden rounded-md bg-[#C9A96E] px-2 py-1 text-xs font-medium text-[#1B2A4A] group-hover:block">Profile</div>
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault(); this.closest('form').submit();"
                           class="group relative flex items-center gap-3 rounded-xl px-3 py-3 transition-colors text-[#FBF8F3]/70 hover:bg-white/5 hover:text-[#C08497]">
                            <span class="flex h-6 w-6 shrink-0 items-center justify-center">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icons['logout'] }}" />
                                </svg>
                            </span>
                            <span x-show="sidebarOpen" x-transition.opacity.duration.200ms class="whitespace-nowrap text-sm font-medium">Log Out</span>
                            <div x-show="!sidebarOpen" class="absolute left-14 z-50 hidden rounded-md bg-[#C9A96E] px-2 py-1 text-xs font-medium text-[#1B2A4A] group-hover:block">Log Out</div>
                        </a>
                    </form>
                </div>

                <div class="flex items-center gap-3 rounded-xl bg-white/5 p-2 border border-white/10">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-[#C9A96E] to-[#A88B5E] text-sm font-bold text-[#1B2A4A] border border-white/20">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div x-show="sidebarOpen" x-transition.opacity.duration.200ms class="overflow-hidden">
                        <p class="truncate text-sm font-medium text-white">{{ Auth::user()->name }}</p>
                        <p class="truncate text-xs text-[#E8D5B0]">{{ ucfirst(Auth::user()->user_type) }}</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- ============ Main Content Area ============ -->
        <div class="flex flex-1 flex-col overflow-hidden bg-[#FBF8F3]">

            <main class="flex-1 overflow-y-auto p-6 sm:p-8">

                <!-- Top Header -->
                <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div class="flex items-center gap-4">
                        <h1 class="font-serif text-2xl font-semibold text-[#1B2A4A] tracking-tight">Product Management</h1>
                        <span class="rounded-full bg-[#1B2A4A] px-3 py-1 text-[11px] font-medium uppercase tracking-luxe text-[#E8D5B0]">Admin</span>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <label class="relative hidden w-64 md:block">
                            <span class="sr-only">Search</span>
                            <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[#8A8276]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icons['search'] }}" />
                            </svg>
                            <input type="text" x-model="q" placeholder="Search products..."
                                   class="w-full rounded-full border border-[#E9E1D6] bg-white py-2.5 pl-9 pr-3 text-sm text-[#1B2A4A] placeholder-[#8A8276] focus:border-[#C9A96E] focus:ring-2 focus:ring-[#C9A96E]/30" />
                        </label>

                        <div class="flex items-center gap-2">
                            @php $pendingCount = \App\Models\Product::where('status', 'pending_review')->count(); @endphp
                            @if ($pendingCount > 0)
                                <a href="{{ route('admin.products.pending') }}"
                                    class="inline-flex items-center gap-2 bg-[#C08497] text-white px-4 py-2 rounded-full hover:bg-[#A96F82] transition text-sm font-semibold tracking-wide shadow-sm">
                                    <i class="fas fa-clock text-xs"></i>
                                    Review Queue ({{ $pendingCount }})
                                </a>
                            @endif
                            <a href="{{ route('admin.products.create') }}"
                               class="inline-flex items-center gap-2 bg-[#1B2A4A] text-white px-4 py-2 rounded-full hover:bg-[#243655] transition text-sm font-semibold tracking-wide">
                                <i class="fas fa-plus text-xs"></i> New Product
                            </a>
                        </div>
                    </div>
                </div>

                @if (session('success'))
                    <div class="bg-[#C9A96E]/15 border border-[#C9A96E] text-[#A88B5E] px-4 py-3 rounded-xl mb-4 text-sm">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="bg-[#C08497]/15 border border-[#C08497] text-[#C08497] px-4 py-3 rounded-xl mb-4 text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- Stats Strip --}}
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3 mb-6">
                    <div class="bg-white rounded-2xl shadow-sm p-4 border border-[#E9E1D6]">
                        <p class="text-[11px] text-[#8A8276] uppercase tracking-luxe">Total</p>
                        <p class="font-serif text-2xl font-semibold text-[#1B2A4A] mt-1">{{ $stats['total'] }}</p>
                    </div>
                    <div class="bg-white rounded-2xl shadow-sm p-4 border border-[#E9E1D6]">
                        <p class="text-[11px] text-[#8A8276] uppercase tracking-luxe">Active</p>
                        <p class="font-serif text-2xl font-semibold text-[#A88B5E] mt-1">{{ $stats['active'] }}</p>
                    </div>
                    <div class="bg-white rounded-2xl shadow-sm p-4 border border-[#E9E1D6]">
                        <p class="text-[11px] text-[#8A8276] uppercase tracking-luxe">Pending</p>
                        <p class="font-serif text-2xl font-semibold text-[#C08497] mt-1">{{ $stats['pending'] }}</p>
                    </div>
                    <div class="bg-white rounded-2xl shadow-sm p-4 border border-[#E9E1D6]">
                        <p class="text-[11px] text-[#8A8276] uppercase tracking-luxe">Disabled</p>
                        <p class="font-serif text-2xl font-semibold text-[#C08497] mt-1">{{ $stats['disabled'] }}</p>
                    </div>
                    <div class="bg-white rounded-2xl shadow-sm p-4 border border-[#E9E1D6]">
                        <p class="text-[11px] text-[#8A8276] uppercase tracking-luxe">Admin</p>
                        <p class="font-serif text-2xl font-semibold text-[#1B2A4A] mt-1">{{ $stats['admin_owned'] }}</p>
                    </div>
                    <div class="bg-white rounded-2xl shadow-sm p-4 border border-[#E9E1D6]">
                        <p class="text-[11px] text-[#8A8276] uppercase tracking-luxe">Vendor</p>
                        <p class="font-serif text-2xl font-semibold text-[#C9A96E] mt-1">{{ $stats['vendor_owned'] }}</p>
                    </div>
                </div>

                {{-- Filters --}}
                <div class="bg-white overflow-hidden rounded-2xl shadow-sm mb-6 border border-[#E9E1D6]">
                    <form method="GET" class="p-4 flex flex-col gap-3">
                        <div class="flex flex-col lg:flex-row gap-3">
                            <div class="relative flex-1">
                                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-[#8A8276] text-sm"></i>
                                <input type="text" name="q" value="{{ request('q') }}"
                                    placeholder="Search by name, SKU, or slug…"
                                    class="w-full pl-10 pr-4 py-2 rounded-full border border-[#E9E1D6] bg-[#FBF8F3] text-[#1B2A4A] placeholder-[#8A8276] focus:border-[#C9A96E] focus:ring-2 focus:ring-[#C9A96E]/30 text-sm">
                            </div>

                            <select name="source" class="rounded-full border border-[#E9E1D6] bg-[#FBF8F3] text-[#1B2A4A] focus:border-[#C9A96E] focus:ring-2 focus:ring-[#C9A96E]/30 text-sm px-4 py-2">
                                <option value="">All sources</option>
                                <option value="admin" {{ request('source') === 'admin' ? 'selected' : '' }}>Admin products</option>
                                <option value="vendor" {{ request('source') === 'vendor' ? 'selected' : '' }}>Vendor products</option>
                            </select>

                            <select name="status" class="rounded-full border border-[#E9E1D6] bg-[#FBF8F3] text-[#1B2A4A] focus:border-[#C9A96E] focus:ring-2 focus:ring-[#C9A96E]/30 text-sm px-4 py-2">
                                <option value="">Any status</option>
                                @foreach (['draft', 'active', 'pending_review', 'rejected', 'disabled', 'archived'] as $s)
                                    <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_', ' ', $s)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex flex-col lg:flex-row gap-3">
                            <select name="category" class="rounded-full border border-[#E9E1D6] bg-[#FBF8F3] text-[#1B2A4A] focus:border-[#C9A96E] focus:ring-2 focus:ring-[#C9A96E]/30 text-sm px-4 py-2 flex-1">
                                <option value="">All categories</option>
                                @foreach ($categories as $parent)
                                    <option value="{{ $parent->id }}" {{ (string) request('category') === (string) $parent->id ? 'selected' : '' }}>
                                        {{ $parent->name }}
                                    </option>
                                    @foreach ($parent->children as $child)
                                        <option value="{{ $child->id }}" {{ (string) request('category') === (string) $child->id ? 'selected' : '' }}>
                                            &nbsp;&nbsp;&nbsp;↳ {{ $child->name }}
                                        </option>
                                    @endforeach
                                @endforeach
                            </select>

                            <select name="brand" class="rounded-full border border-[#E9E1D6] bg-[#FBF8F3] text-[#1B2A4A] focus:border-[#C9A96E] focus:ring-2 focus:ring-[#C9A96E]/30 text-sm px-4 py-2 flex-1">
                                <option value="">All brands</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ (string) request('brand') === (string) $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>

                            <select name="sort" class="rounded-full border border-[#E9E1D6] bg-[#FBF8F3] text-[#1B2A4A] focus:border-[#C9A96E] focus:ring-2 focus:ring-[#C9A96E]/30 text-sm px-4 py-2">
                                <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest first</option>
                                <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Name A–Z</option>
                                <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price: low to high</option>
                                <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price: high to low</option>
                                <option value="stock" {{ request('sort') === 'stock' ? 'selected' : '' }}>Lowest stock</option>
                                <option value="rating" {{ request('sort') === 'rating' ? 'selected' : '' }}>Top rated</option>
                            </select>

                            <button type="submit"
                                class="px-5 py-2 bg-[#1B2A4A] text-white text-sm font-semibold tracking-wide rounded-full hover:bg-[#243655] whitespace-nowrap">
                                Apply
                            </button>

                            @if (request()->hasAny(['q', 'source', 'category', 'brand', 'status', 'sort']))
                                <a href="{{ route('admin.products.index') }}"
                                    class="px-4 py-2 text-sm text-[#8A8276] hover:text-[#1B2A4A] whitespace-nowrap text-center">
                                    Clear
                                </a>
                            @endif
                        </div>
                    </form>

                    <div class="px-4 pb-4 text-xs text-[#8A8276]">
                        Showing <strong class="text-[#1B2A4A]">{{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }}</strong>
                        of <strong class="text-[#1B2A4A]">{{ $products->total() }}</strong> product{{ $products->total() === 1 ? '' : 's' }}
                    </div>
                </div>

                {{-- Product List --}}
                @if ($products->isEmpty())
                    <div class="bg-white overflow-hidden rounded-2xl shadow-sm border border-[#E9E1D6]">
                        <div class="p-12 text-center">
                            <i class="fas fa-box-open text-4xl text-[#C9A96E]/30 mb-4"></i>
                            <p class="text-[#8A8276] mb-4">No products found.</p>
                            @if (request()->hasAny(['q', 'source', 'category', 'brand', 'status', 'sort']))
                                <a href="{{ route('admin.products.index') }}"
                                    class="text-[#C9A96E] hover:text-[#1B2A4A] text-sm font-medium">
                                    Clear filters
                                </a>
                            @else
                                <a href="{{ route('admin.products.create') }}"
                                    class="inline-flex items-center gap-2 bg-[#1B2A4A] text-white px-5 py-2.5 rounded-full hover:bg-[#243655] transition text-sm font-semibold tracking-wide">
                                    <i class="fas fa-plus text-xs"></i> Create your first product
                                </a>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="bg-white overflow-hidden rounded-2xl shadow-sm border border-[#E9E1D6]">
                        <div class="overflow-x-auto">
                            <table class="w-full text-[#1B2A4A]">
                                <thead>
                                    <tr class="border-b border-[#E9E1D6] bg-[#FBF8F3]">
                                        <th class="text-left py-3 px-4 text-[11px] font-semibold text-[#8A8276] uppercase tracking-luxe">Product</th>
                                        <th class="text-left py-3 px-4 text-[11px] font-semibold text-[#8A8276] uppercase tracking-luxe">Category</th>
                                        <th class="text-left py-3 px-4 text-[11px] font-semibold text-[#8A8276] uppercase tracking-luxe">Source</th>
                                        <th class="text-right py-3 px-4 text-[11px] font-semibold text-[#8A8276] uppercase tracking-luxe">Price</th>
                                        <th class="text-center py-3 px-4 text-[11px] font-semibold text-[#8A8276] uppercase tracking-luxe">Stock</th>
                                        <th class="text-left py-3 px-4 text-[11px] font-semibold text-[#8A8276] uppercase tracking-luxe">Status</th>
                                        <th class="text-right py-3 px-4 text-[11px] font-semibold text-[#8A8276] uppercase tracking-luxe">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#E9E1D6]">
                                    @foreach ($products as $product)
                                        <tr class="hover:bg-[#FBF8F3] transition {{ $product->status === 'disabled' ? 'opacity-60' : '' }}">
                                            {{-- Product --}}
                                            <td class="py-3 px-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="shrink-0 w-12 h-12 rounded-xl bg-[#FBF8F3] border border-[#E9E1D6] overflow-hidden flex items-center justify-center">
                                                        @if ($product->thumbnail)
                                                            <img src="{{ asset('storage/' . $product->thumbnail) }}"
                                                                alt="{{ $product->name }}"
                                                                class="w-full h-full object-cover"
                                                                onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                                            <i class="fas fa-image text-[#C9A96E]/40" style="display:none;"></i>
                                                        @else
                                                            <i class="fas fa-image text-[#C9A96E]/40"></i>
                                                        @endif
                                                    </div>
                                                    <div class="min-w-0">
                                                        <div class="flex items-center gap-1.5">
                                                            <a href="{{ route('admin.products.show', $product) }}"
                                                                class="font-medium text-[#1B2A4A] hover:text-[#C9A96E] truncate">
                                                                {{ $product->name }}
                                                            </a>
                                                            @if ($product->is_featured)
                                                                <i class="fas fa-star text-[#C9A96E] text-xs" title="Featured"></i>
                                                            @endif
                                                        </div>
                                                        <div class="text-xs text-[#8A8276] font-mono truncate">
                                                            {{ $product->sku }}
                                                            @if ($product->brand)
                                                                · {{ $product->brand->name }}
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            {{-- Category --}}
                                            <td class="py-3 px-4 text-sm">
                                                @if ($product->category)
                                                    <span class="text-[#1B2A4A]/80">{{ $product->category->name }}</span>
                                                @else
                                                    <span class="text-[#8A8276]">—</span>
                                                @endif
                                            </td>

                                            {{-- Source --}}
                                            <td class="py-3 px-4 text-sm">
                                                @if ($product->isVendorProduct())
                                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-[#C9A96E]/15 text-[#A88B5E] border border-[#C9A96E]/30">
                                                        <i class="fas fa-store text-[9px]"></i>
                                                        {{ $product->source?->shop_name ?? $product->source?->name ?? 'Vendor' }}
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-[#1B2A4A]/10 text-[#1B2A4A] border border-[#1B2A4A]/20">
                                                        <i class="fas fa-shield-alt text-[9px]"></i> Admin
                                                    </span>
                                                @endif
                                            </td>

                                            {{-- Price --}}
                                            <td class="py-3 px-4 text-sm text-right">
                                                <div class="font-medium text-[#1B2A4A]">
                                                    {{ $product->formattedPrice() }}
                                                </div>
                                                @if ($product->isOnSale())
                                                    <div class="text-xs text-[#8A8276] line-through">
                                                        {{ $product->formattedCompareAtPrice() }}
                                                    </div>
                                                @endif
                                            </td>

                                            {{-- Stock --}}
                                            <td class="py-3 px-4 text-center text-sm">
                                                @if (!$product->track_inventory)
                                                    <span class="text-xs text-[#8A8276]">N/A</span>
                                                @elseif ($product->stock_quantity === 0)
                                                    <span class="inline-flex items-center gap-1 text-xs font-medium text-[#C08497]">
                                                        <i class="fas fa-times-circle text-[9px]"></i> 0
                                                    </span>
                                                @elseif ($product->isLowStock())
                                                    <span class="inline-flex items-center gap-1 text-xs font-medium text-[#C9A96E]">
                                                        <i class="fas fa-exclamation-triangle text-[9px]"></i>
                                                        {{ $product->stock_quantity }}
                                                    </span>
                                                @else
                                                    <span class="text-[#1B2A4A]/80">{{ $product->stock_quantity }}</span>
                                                @endif
                                            </td>

                                            {{-- Status --}}
                                            <td class="py-3 px-4">
                                                @php
                                                    $statusColors = [
                                                        'draft' => 'bg-[#8A8276]/15 text-[#8A8276] border-[#8A8276]/30',
                                                        'active' => 'bg-[#C9A96E]/15 text-[#A88B5E] border-[#C9A96E]/40',
                                                        'pending_review' => 'bg-[#C08497]/15 text-[#C08497] border-[#C08497]/30',
                                                        'rejected' => 'bg-[#C08497]/15 text-[#C08497] border-[#C08497]/30',
                                                        'disabled' => 'bg-[#C08497]/15 text-[#C08497] border-[#C08497]/30',
                                                        'archived' => 'bg-[#8A8276]/15 text-[#8A8276] border-[#8A8276]/30',
                                                    ];
                                                    $color = $statusColors[$product->status] ?? 'bg-[#8A8276]/15 text-[#8A8276] border-[#8A8276]/30';
                                                @endphp
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium border {{ $color }}">
                                                    {{ ucfirst(str_replace('_', ' ', $product->status)) }}
                                                </span>
                                                @if ($product->status === 'disabled' && $product->disabled_reason)
                                                    <div class="text-[10px] text-[#C08497] mt-0.5 truncate max-w-[140px]" title="{{ $product->disabled_reason }}">
                                                        {{ \Illuminate\Support\Str::limit($product->disabled_reason, 40) }}
                                                    </div>
                                                @endif
                                                @if ($product->status === 'pending_review')
                                                    <div class="flex items-center gap-1.5 mt-1.5">
                                                        <form method="POST" action="{{ route('admin.products.approve', $product) }}">
                                                            @csrf
                                                            <button type="submit"
                                                                class="text-[11px] font-medium text-[#A88B5E] hover:text-[#C9A96E]">
                                                                Approve
                                                            </button>
                                                        </form>
                                                        <button type="button"
                                                            onclick="openRejectModal({{ $product->id }}, '{{ addslashes($product->name) }}')"
                                                            class="text-[11px] font-medium text-[#C08497] hover:text-[#A96F82]">
                                                            Reject
                                                        </button>
                                                    </div>
                                                @endif
                                            </td>

                                            {{-- Actions --}}
                                            <td class="py-3 px-4 text-right">
                                                <div class="flex items-center justify-end gap-1">
                                                    <a href="{{ route('admin.products.show', $product) }}"
                                                        class="text-[#8A8276] hover:text-[#1B2A4A] text-sm font-medium px-2 py-1.5 rounded-full hover:bg-[#FBF8F3] transition"
                                                        title="View">
                                                        <i class="fas fa-eye text-xs"></i>
                                                    </a>

                                                    <a href="{{ route('admin.products.edit', $product) }}"
                                                        class="text-[#C9A96E] hover:text-[#A88B5E] text-sm font-medium px-2 py-1.5 rounded-full hover:bg-[#C9A96E]/10 transition"
                                                        title="Edit">
                                                        <i class="fas fa-pen text-xs"></i>
                                                    </a>

                                                    <form method="POST" action="{{ route('admin.products.toggleFeatured', $product) }}" class="inline">
                                                        @csrf
                                                        <button type="submit"
                                                            class="text-sm font-medium px-2 py-1.5 rounded-full transition {{ $product->is_featured ? 'text-[#C9A96E] hover:text-[#A88B5E]' : 'text-[#8A8276] hover:text-[#C9A96E]' }}"
                                                            title="{{ $product->is_featured ? 'Unfeature' : 'Feature' }}">
                                                            <i class="fas fa-star text-xs"></i>
                                                        </button>
                                                    </form>

                                                    @if ($product->status === 'disabled')
                                                        <form method="POST" action="{{ route('admin.products.enable', $product) }}" class="inline">
                                                            @csrf
                                                            <button type="submit"
                                                                class="text-sm font-medium text-[#A88B5E] hover:text-[#C9A96E] px-2 py-1.5 rounded-full transition"
                                                                title="Enable">
                                                                <i class="fas fa-check-circle text-xs"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <button type="button"
                                                            onclick="openDisableModal({{ $product->id }}, '{{ addslashes($product->name) }}')"
                                                            class="text-sm font-medium text-[#C08497] hover:text-[#A96F82] px-2 py-1.5 rounded-full transition"
                                                            title="Disable">
                                                            <i class="fas fa-ban text-xs"></i>
                                                        </button>
                                                    @endif

                                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                                        onsubmit="return confirm('Delete product &quot;{{ addslashes($product->name) }}&quot;? This soft-deletes it.')"
                                                        class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="text-sm font-medium text-[#C08497] hover:text-[#A96F82] px-2 py-1.5 rounded-full transition"
                                                            title="Delete">
                                                            <i class="fas fa-trash text-xs"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if ($products->hasPages())
                            <div class="px-4 py-3 border-t border-[#E9E1D6]">
                                {{ $products->links() }}
                            </div>
                        @endif
                    </div>
                @endif

            </main>
        </div>
    </div>

    {{-- Reject Modal --}}
    <div id="rejectModal" class="hidden fixed inset-0 z-50 bg-[#1B2A4A]/40 items-center justify-center p-4 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6 border border-[#E9E1D6]">
            <h3 class="font-serif text-lg font-semibold text-[#1B2A4A] mb-2">Reject Product</h3>
            <p class="text-sm text-[#8A8276] mb-4">
                Rejecting: <strong id="rejectProductName" class="text-[#1B2A4A]"></strong>
            </p>
            <form id="rejectForm" method="POST">
                @csrf
                <label class="block text-sm font-medium text-[#1B2A4A] mb-1">Rejection reason</label>
                <textarea name="rejection_reason" rows="3" required
                    class="w-full rounded-xl border border-[#E9E1D6] bg-[#FBF8F3] text-[#1B2A4A] placeholder-[#8A8276] focus:border-[#C08497] focus:ring-2 focus:ring-[#C08497]/30 text-sm px-3 py-2"
                    placeholder="Explain what needs to change…"></textarea>
                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" onclick="closeRejectModal()"
                        class="px-4 py-2 text-sm text-[#8A8276] hover:text-[#1B2A4A]">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-5 py-2 bg-[#C08497] text-white text-sm font-semibold tracking-wide rounded-full hover:bg-[#A96F82]">
                        Reject
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Disable Modal --}}
    <div id="disableModal" class="hidden fixed inset-0 z-50 bg-[#1B2A4A]/40 items-center justify-center p-4 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6 border border-[#E9E1D6]">
            <h3 class="font-serif text-lg font-semibold text-[#1B2A4A] mb-2">Disable Product</h3>
            <p class="text-sm text-[#8A8276] mb-4">
                Disabling hides the product <strong>site-wide</strong>. Product: <strong id="disableProductName" class="text-[#1B2A4A]"></strong>
            </p>
            <form id="disableForm" method="POST">
                @csrf
                <label class="block text-sm font-medium text-[#1B2A4A] mb-1">Reason for disabling</label>
                <textarea name="disabled_reason" rows="3" required
                    class="w-full rounded-xl border border-[#E9E1D6] bg-[#FBF8F3] text-[#1B2A4A] placeholder-[#8A8276] focus:border-[#C08497] focus:ring-2 focus:ring-[#C08497]/30 text-sm px-3 py-2"
                    placeholder="e.g. Regulatory violation, repeated complaints…"></textarea>
                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" onclick="closeDisableModal()"
                        class="px-4 py-2 text-sm text-[#8A8276] hover:text-[#1B2A4A]">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-5 py-2 bg-[#C08497] text-white text-sm font-semibold tracking-wide rounded-full hover:bg-[#A96F82]">
                        Disable Product
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openRejectModal(productId, productName) {
            document.getElementById('rejectProductName').textContent = productName;
            document.getElementById('rejectForm').action = '/admin/products/' + productId + '/reject';
            document.getElementById('rejectModal').classList.remove('hidden');
            document.getElementById('rejectModal').classList.add('flex');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
            document.getElementById('rejectModal').classList.remove('flex');
        }

        function openDisableModal(productId, productName) {
            document.getElementById('disableProductName').textContent = productName;
            document.getElementById('disableForm').action = '/admin/products/' + productId + '/disable';
            document.getElementById('disableModal').classList.remove('hidden');
            document.getElementById('disableModal').classList.add('flex');
        }

        function closeDisableModal() {
            document.getElementById('disableModal').classList.add('hidden');
            document.getElementById('disableModal').classList.remove('flex');
        }
    </script>
</x-admin-layout>