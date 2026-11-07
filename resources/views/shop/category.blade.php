@php
    // ---- Active filter helpers -------------------------------------------------
    $filterKeys = ['brand', 'min_price', 'max_price', 'verified', 'in_stock', 'on_sale', 'q'];
    $hasFilters = request()->hasAny($filterKeys);

    $money = fn ($v) => is_numeric($v) ? 'KSh ' . number_format((float) $v) : $v;

    $activeChips = [];
    foreach ($filterKeys as $key) {
        if (!request()->filled($key)) { continue; }
        $value = request($key);

        if ($key === 'brand') {
            foreach ((array) $value as $brandName) {
                $rest = array_values(array_diff((array) $value, [$brandName]));
                $query = request()->except('page', 'brand');
                if ($rest) { $query['brand'] = $rest; }
                $activeChips[] = ['label' => $brandName, 'url' => url()->current() . ($query ? '?' . http_build_query($query) : '')];
            }
            continue;
        }

        $label = match ($key) {
            'min_price' => 'From ' . $money($value),
            'max_price' => 'Up to ' . $money($value),
            'verified'  => 'Verified',
            'in_stock'  => 'In stock',
            'on_sale'   => 'On sale',
            'q'         => '“' . $value . '”',
            default     => $value,
        };
        $query = request()->except('page', $key);
        $activeChips[] = ['label' => $label, 'url' => url()->current() . ($query ? '?' . http_build_query($query) : '')];
    }
    $activeCount = count($activeChips);

    $activeChildren = $category->children->where('is_active', true);

    // ---- Theme color taken from the category banner background ------------------
    $heroBg = (string) $category->heroBackground();
    $red = 27; $green = 42; $blue = 74; // brand navy (#1B2A4A)
    if (preg_match('/#([0-9a-f]{6}|[0-9a-f]{3})\b/i', $heroBg, $m)) {
        $hex = $m[1];
        if (strlen($hex) === 3) { $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2]; }
        [$red, $green, $blue] = [hexdec(substr($hex, 0, 2)), hexdec(substr($hex, 2, 2)), hexdec(substr($hex, 4, 2))];
    } elseif (preg_match('/rgba?\(\s*(\d{1,3})[\s,]+(\d{1,3})[\s,]+(\d{1,3})/i', $heroBg, $m)) {
        [$red, $green, $blue] = [min(255, (int) $m[1]), min(255, (int) $m[2]), min(255, (int) $m[3])];
    }
    $themePrimary = sprintf('#%02x%02x%02x', $red, $green, $blue);
    $themeOn = ((0.299 * $red + 0.587 * $green + 0.114 * $blue) / 255) > 0.62 ? '#1a1a1a' : '#ffffff';
@endphp

<x-shop-layout :title="$title" :meta-description="$metaDescription">

    {{-- Page theme derives its accent from the category banner but always stays within
         the Mawadda palette — gold accents, navy ink, ivory paper. --}}
    <style>
        .cat-page {
            --cat-accent: #C9A96E;
            --cat-ink: #1B2A4A;
            --cat-paper: #FBF8F3;
            --cat-line: #E9E1D6;
            --cat-muted: #8A8276;
            --cat-primary-soft: color-mix(in srgb, var(--cat-primary) 9%, #ffffff);
            --cat-primary-softer: color-mix(in srgb, var(--cat-primary) 4%, #FBF8F3);
            --cat-primary-line: color-mix(in srgb, var(--cat-primary) 20%, #E9E1D6);
            --cat-primary-deep: color-mix(in srgb, var(--cat-primary) 75%, #000000);
            font-family: 'Jost', ui-sans-serif, system-ui, sans-serif;
        }
        .cat-page .font-serif,
        .cat-page h1, .cat-page h2, .cat-page h3 {
            font-family: 'Cormorant Garamond', ui-serif, Georgia, serif;
        }
        .cat-page .tracking-luxe { letter-spacing: 0.18em; }

        .cat-page .cat-chip-scroll { scrollbar-width: none; -webkit-overflow-scrolling: touch; scroll-snap-type: x proximity; }
        .cat-page .cat-chip-scroll::-webkit-scrollbar { display: none; }
        .cat-page .cat-chip-scroll > * { scroll-snap-align: start; }
        .cat-page :focus-visible { outline: 2px solid var(--cat-accent); outline-offset: 2px; }

        .cat-page .cat-toolbar { top: var(--header-height, 4rem); }
        @media (min-width: 1024px) { .cat-page .cat-toolbar { top: var(--header-height, 5rem); } }

        .cat-page .lift { border-radius: 1rem; transition: transform .3s, box-shadow .3s; }
        .cat-page .cat-subchip { background: #fff; transition: background-color .2s, border-color .2s; }
        .cat-page .press:active { transform: scale(0.96); }
        @media (hover: hover) {
            .cat-page .lift:hover { transform: translateY(-6px); box-shadow: 0 24px 40px -24px rgba(27,42,74,0.45); }
            .cat-page .cat-subchip:hover { background: var(--cat-primary-soft); border-color: var(--cat-accent); }
        }
        @media (prefers-reduced-motion: reduce) {
            .cat-page * { transition-duration: 0.01ms !important; animation-duration: 0.01ms !important; }
        }

        .search-input,
        input[type="text"][name="q"] {
            outline: none !important;
            box-shadow: none !important;
            border: 0 !important;
            -webkit-appearance: none;
            appearance: none;
        }
        .search-input:focus,
        .search-input:focus-visible,
        input[type="text"][name="q"]:focus,
        input[type="text"][name="q"]:focus-visible {
            outline: none !important;
            box-shadow: none !important;
            border: 0 !important;
            --tw-ring-shadow: 0 0 #0000 !important;
            --tw-ring-offset-shadow: 0 0 #0000 !important;
        }
    </style>

    <div class="cat-page"
         style="--cat-primary: {{ $themePrimary }}; --cat-on-primary: {{ $themeOn }};">

        {{-- BREADCRUMB --}}
        <nav aria-label="Breadcrumb"
             x-data x-init="$nextTick(() => $el.scrollLeft = $el.scrollWidth)"
             class="cat-chip-scroll flex items-center gap-2 text-xs py-2 sm:py-4 overflow-x-auto whitespace-nowrap"
             style="color: var(--cat-muted);">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 shrink-0 py-2 hover:text-[#1B2A4A] transition-colors">
                <i class="fas fa-home text-[11px]" style="color: var(--cat-accent);"></i> Home
            </a>
            @foreach ($breadcrumb as $crumb)
                <i class="fas fa-chevron-right text-[8px] opacity-40 shrink-0" style="color: var(--cat-muted);"></i>
                @if ($loop->last)
                    <span class="font-semibold shrink-0" style="color: var(--cat-ink);" aria-current="page">{{ $crumb['name'] }}</span>
                @else
                    <a href="{{ route('category.show', $crumb['slug']) }}" class="shrink-0 py-2 hover:text-[#1B2A4A] transition-colors">{{ $crumb['name'] }}</a>
                @endif
            @endforeach
        </nav>

        {{-- CATEGORY BANNER --}}
        <section class="relative overflow-hidden rounded-3xl mb-5 sm:mb-6 isolate"
                 style="background: {{ $category->heroBackground() }}; color: var(--cat-on-primary);">

            @if ($category->hero_image)
                <img src="{{ asset('storage/' . $category->hero_image) }}"
                     alt=""
                     loading="eager"
                     class="absolute inset-0 -z-10 w-full h-full object-cover opacity-30">
            @endif

            {{-- gold glow + soft cloud motif, echoing the Mawaddabridals brand --}}
            <div aria-hidden="true" class="absolute inset-0 -z-10 pointer-events-none"
                 style="background: radial-gradient(90% 120% at 100% 0%, rgba(201,169,110,0.32) 0%, rgba(201,169,110,0) 60%);"></div>
            <i aria-hidden="true" class="fas fa-cloud absolute -right-6 -bottom-10 text-[150px] sm:text-[220px] -rotate-12 opacity-[0.07] -z-10 pointer-events-none"></i>

            <div class="px-5 py-7 sm:px-10 sm:py-12 max-w-3xl">
                <h1 class="font-serif text-[2rem] sm:text-5xl font-semibold tracking-tight leading-[1.05]">
                    {{ $category->name }}
                </h1>

                @if ($category->description)
                    <p class="mt-2.5 sm:mt-3 text-sm sm:text-base max-w-xl line-clamp-3 sm:line-clamp-none"
                       style="color: color-mix(in srgb, var(--cat-on-primary) 82%, transparent);">
                        {{ $category->description }}
                    </p>
                @endif

                <div class="mt-4 sm:mt-5 flex items-center gap-2 flex-wrap">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px] uppercase tracking-luxe font-semibold backdrop-blur"
                          style="background: color-mix(in srgb, var(--cat-on-primary) 16%, transparent); border: 1px solid color-mix(in srgb, var(--cat-on-primary) 25%, transparent);">
                        <i class="fas fa-gem text-[10px]" style="color: var(--cat-accent);"></i>
                        {{ $products->total() }} {{ Str::plural('piece', $products->total()) }}
                    </span>
                    @if ($category->isTopLevel() && $activeChildren->isNotEmpty())
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px] uppercase tracking-luxe font-semibold backdrop-blur"
                              style="background: color-mix(in srgb, var(--cat-on-primary) 16%, transparent); border: 1px solid color-mix(in srgb, var(--cat-on-primary) 25%, transparent);">
                            <i class="fas fa-sitemap text-[10px]" style="color: var(--cat-accent);"></i>
                            {{ $activeChildren->count() }} {{ Str::plural('collection', $activeChildren->count()) }}
                        </span>
                    @endif
                </div>
            </div>
        </section>

        {{-- SUBCATEGORY CHIPS --}}
        @if ($activeChildren->isNotEmpty())
            <div class="cat-chip-scroll -mx-4 px-4 sm:mx-0 sm:px-0 flex gap-2 overflow-x-auto pb-4 sm:pb-5" role="list" aria-label="Subcategories">
                @foreach ($activeChildren as $child)
                    <a href="{{ route('category.show', $child->slug) }}"
                       role="listitem"
                       class="cat-subchip press shrink-0 inline-flex items-center gap-2 whitespace-nowrap rounded-full px-4 min-h-[44px] text-sm font-medium shadow-sm"
                       style="border: 1px solid var(--cat-primary-line); color: var(--cat-primary-deep);">
                        @if ($child->icon)
                            <i class="fas {{ $child->icon }} text-xs" style="color: var(--cat-accent);"></i>
                        @endif
                        {{ $child->name }}
                    </a>
                @endforeach
            </div>
        @endif

        {{-- MAIN GRID --}}
        <div class="grid grid-cols-1 xl:grid-cols-[17rem_minmax(0,1fr)] gap-5 xl:gap-8 pb-12"
             x-data="{ mobileFiltersOpen: false }"
             x-effect="document.body.classList.toggle('overflow-hidden', mobileFiltersOpen)">

            {{-- SIDEBAR --}}
            <aside class="hidden xl:block" aria-label="Product filters">
                <div class="bg-white rounded-2xl p-5 sticky top-24 shadow-sm"
                     style="border: 1px solid var(--cat-primary-line);">
                    <div class="flex items-center justify-between mb-4 pb-3"
                         style="border-bottom: 1px solid var(--cat-primary-soft);">
                        <h2 class="font-serif text-xl font-semibold flex items-center gap-2" style="color: var(--cat-ink);">
                            <i class="fas fa-sliders-h text-sm" style="color: var(--cat-accent);"></i>
                            Filters
                            @if ($activeCount)
                                <span class="text-[11px] font-bold px-1.5 py-0.5 rounded-full tracking-wide"
                                      style="background: var(--cat-accent); color: var(--cat-ink);">{{ $activeCount }}</span>
                            @endif
                        </h2>
                        @if ($hasFilters)
                            <a href="{{ route('category.show', $category->slug) }}"
                               class="text-xs font-semibold hover:underline py-2"
                               style="color: var(--cat-primary-deep);">Clear all</a>
                        @endif
                    </div>

                    @include('shop.partials.category-filters', [
                        'category' => $category,
                        'availableBrands' => $availableBrands,
                        'priceRange' => $priceRange,
                    ])
                </div>
            </aside>

            {{-- PRODUCTS --}}
            <div class="min-w-0">

                <div class="cat-toolbar sticky z-20 xl:static -mx-4 px-4 py-2 sm:mx-0 sm:px-0 sm:rounded-2xl mb-4 backdrop-blur xl:backdrop-blur-none"
                     style="background: color-mix(in srgb, var(--cat-primary-softer) 94%, transparent);">
                    <div class="bg-white rounded-2xl px-3 sm:px-4 py-2 flex items-center justify-between gap-2 sm:gap-3 shadow-sm"
                         style="border: 1px solid var(--cat-primary-line);">

                        <div class="flex items-center gap-3 min-w-0">
                            <button type="button"
                                    @click="mobileFiltersOpen = true"
                                    aria-haspopup="dialog"
                                    class="press xl:hidden relative inline-flex items-center gap-2 text-sm font-semibold px-4 h-11 rounded-full transition tracking-wide"
                                    style="background: #1B2A4A; color: #fff;">
                                <i class="fas fa-sliders-h text-xs"></i>
                                Filters
                                @if ($activeCount)
                                    <span class="min-w-[20px] h-5 px-1 rounded-full text-[11px] font-bold flex items-center justify-center"
                                          style="background: var(--cat-accent); color: var(--cat-ink);">{{ $activeCount }}</span>
                                @endif
                            </button>

                            <p class="text-sm hidden sm:block whitespace-nowrap" style="color: var(--cat-muted);">
                                <strong style="color: var(--cat-ink);">{{ $products->total() }}</strong>
                                {{ Str::plural('result', $products->total()) }}
                            </p>
                        </div>

                        <form method="GET" class="flex items-center gap-2 min-w-0">
                            @foreach (request()->except('sort', 'page') as $k => $v)
                                @if (is_array($v))
                                    @foreach ($v as $vv)
                                        <input type="hidden" name="{{ $k }}[]" value="{{ $vv }}">
                                    @endforeach
                                @else
                                    <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                                @endif
                            @endforeach

                            <label for="sort" class="text-xs whitespace-nowrap hidden sm:inline uppercase tracking-luxe" style="color: var(--cat-muted);">Sort</label>
                            <select id="sort" name="sort" onchange="this.form.submit()"
                                    class="text-base sm:text-sm h-11 rounded-full bg-white pl-4 pr-9 w-full max-w-[11rem] sm:max-w-none sm:w-auto truncate focus:ring-0"
                                    style="border: 1px solid var(--cat-primary-line); color: var(--cat-primary-deep);">
                                <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>Newest</option>
                                <option value="price_asc" {{ $sort === 'price_asc' ? 'selected' : '' }}>Price: low to high</option>
                                <option value="price_desc" {{ $sort === 'price_desc' ? 'selected' : '' }}>Price: high to low</option>
                                <option value="rating" {{ $sort === 'rating' ? 'selected' : '' }}>Top rated</option>
                                <option value="name" {{ $sort === 'name' ? 'selected' : '' }}>Name A–Z</option>
                            </select>
                        </form>
                    </div>
                </div>

                @if ($activeCount)
                    <div class="cat-chip-scroll flex items-center gap-2 overflow-x-auto pb-3 -mx-4 px-4 sm:mx-0 sm:px-0 sm:flex-wrap" aria-label="Active filters">
                        @foreach ($activeChips as $chip)
                            <a href="{{ $chip['url'] }}"
                               class="press shrink-0 inline-flex items-center gap-2 pl-4 pr-3 min-h-[40px] rounded-full text-xs font-semibold transition hover:opacity-80"
                               style="background: var(--cat-primary-soft); color: var(--cat-primary-deep); border: 1px solid var(--cat-primary-line);"
                               aria-label="Remove filter {{ $chip['label'] }}">
                                {{ $chip['label'] }}
                                <i class="fas fa-times text-[10px]"></i>
                            </a>
                        @endforeach
                        <a href="{{ route('category.show', $category->slug) }}"
                           class="shrink-0 text-xs font-semibold px-3 min-h-[40px] inline-flex items-center hover:underline"
                           style="color: var(--cat-primary-deep);">Clear all</a>
                    </div>
                @endif

                @if ($products->isEmpty())
                    <div class="bg-white rounded-3xl p-8 sm:p-14 text-center"
                         style="border: 1px dashed var(--cat-primary-line);">
                        <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4"
                             style="background: color-mix(in srgb, var(--cat-accent) 12%, #FBF8F3);">
                            <i class="fas fa-gem text-2xl" style="color: var(--cat-accent);"></i>
                        </div>
                        <h3 class="font-serif text-2xl font-semibold mb-2" style="color: var(--cat-ink);">No pieces found</h3>
                        @if ($hasFilters)
                            <p class="text-sm mb-6 max-w-sm mx-auto" style="color: var(--cat-muted);">No pieces match these filters. Remove a filter to see more of the collection.</p>
                            <a href="{{ route('category.show', $category->slug) }}"
                               class="press inline-flex items-center justify-center gap-2 px-6 h-12 rounded-full text-sm font-semibold transition hover:opacity-90 tracking-wide"
                               style="background: #1B2A4A; color: #fff;">
                                <i class="fas fa-times text-xs"></i> Clear filters
                            </a>
                        @else
                            <p class="text-sm" style="color: var(--cat-muted);">New pieces are on the way. Check back soon.</p>
                        @endif
                    </div>
                @else
                    <div class="grid grid-cols-2 sm:grid-cols-3 2xl:grid-cols-4 gap-3 sm:gap-5">
                        @foreach ($products as $product)
                            <div class="lift min-w-0">
                                <x-product-card :product="$product" :show-category="false" />
                            </div>
                        @endforeach
                    </div>

                    @if ($products->hasPages())
                        <div class="mt-8 overflow-x-auto">
                            {{ $products->withQueryString()->links() }}
                        </div>
                    @endif
                @endif
            </div>

            {{-- FILTER BOTTOM SHEET --}}
            <div x-show="mobileFiltersOpen" x-cloak
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @keydown.escape.window="mobileFiltersOpen = false"
                 role="dialog" aria-modal="true" aria-label="Filters"
                 class="xl:hidden fixed inset-0 z-50 flex items-end sm:items-center sm:justify-center backdrop-blur-sm"
                 style="background: color-mix(in srgb, var(--cat-primary-deep) 55%, transparent);">

                <div @click="mobileFiltersOpen = false" class="absolute inset-0"></div>

                <div x-show="mobileFiltersOpen"
                     x-trap="mobileFiltersOpen"
                     x-transition:enter="transition ease-out duration-250"
                     x-transition:enter-start="translate-y-full sm:translate-y-6 sm:opacity-0"
                     x-transition:enter-end="translate-y-0 sm:opacity-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="translate-y-0"
                     x-transition:leave-end="translate-y-full"
                     class="relative bg-white rounded-t-3xl sm:rounded-3xl w-full sm:max-w-lg max-h-[88dvh] flex flex-col shadow-2xl">

                    <div class="pt-2.5 pb-1 flex justify-center sm:hidden" aria-hidden="true">
                        <span class="w-10 h-1 rounded-full" style="background: var(--cat-primary-line);"></span>
                    </div>

                    <div class="px-5 py-3 flex items-center justify-between"
                         style="border-bottom: 1px solid var(--cat-primary-soft);">
                        <h2 class="font-serif text-xl font-semibold flex items-center gap-2" style="color: var(--cat-ink);">
                            <i class="fas fa-sliders-h text-sm" style="color: var(--cat-accent);"></i>
                            Filters
                            @if ($activeCount)
                                <span class="text-xs font-bold px-1.5 py-0.5 rounded-full align-middle tracking-wide"
                                      style="background: var(--cat-accent); color: var(--cat-ink);">{{ $activeCount }}</span>
                            @endif
                        </h2>
                        <button @click="mobileFiltersOpen = false"
                                aria-label="Close filters"
                                class="press w-11 h-11 rounded-full flex items-center justify-center"
                                style="background: #FBF8F3; color: var(--cat-ink); border: 1px solid var(--cat-line);">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <div class="px-5 py-5 overflow-y-auto flex-1 overscroll-contain">
                        @include('shop.partials.category-filters', [
                            'category' => $category,
                            'availableBrands' => $availableBrands,
                            'priceRange' => $priceRange,
                        ])
                    </div>

                    <div class="px-5 pt-3 grid gap-2 sticky bottom-0 bg-white rounded-b-3xl"
                         style="border-top: 1px solid var(--cat-primary-soft); padding-bottom: max(0.75rem, env(safe-area-inset-bottom));
                                grid-template-columns: {{ $hasFilters ? '1fr 2fr' : '1fr' }};">
                        @if ($hasFilters)
                            <a href="{{ route('category.show', $category->slug) }}"
                               class="press flex items-center justify-center h-12 rounded-full text-sm font-semibold tracking-wide"
                               style="border: 1px solid var(--cat-line); color: var(--cat-ink);">
                                Clear all
                            </a>
                        @endif
                        <button type="button" @click="mobileFiltersOpen = false"
                                class="press h-12 rounded-full text-sm font-semibold tracking-wide transition"
                                style="background: #C9A96E; color: #1B2A4A;">
                            Show {{ $products->total() }} {{ Str::plural('piece', $products->total()) }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-shop-layout>