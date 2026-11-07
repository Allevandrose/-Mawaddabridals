@php
    $mainUrl = $imageUrl();
    $hoverUrl = null;
    foreach (($product->images ?? []) as $img) {
        $path = is_array($img) ? ($img['path'] ?? null) : $img;
        if ($path && asset('storage/' . $path) !== $mainUrl) {
            $hoverUrl = asset('storage/' . $path);
            break;
        }
    }
    $lowStock = $product->inStock() && $product->track_inventory && $product->isLowStock();

    $initialWishlisted = auth()->check() && auth()->user()->isWishlisted($product->id);
    $isGuest = ! auth()->check();
    $onSale = $product->isOnSale();
@endphp

{{-- The lift / shadow on hover is handled by the wrapper (.lift) in the page layout,
     so this card only changes its border on hover. --}}
<article class="group relative flex flex-col h-full min-w-0 bg-white rounded-2xl border border-line p-2.5 sm:p-3 transition-colors duration-300 focus-within:border-gold/60 [@media(hover:hover)]:hover:border-gold/60"
         x-data="{
             adding: false,
             added: false,
             wishlisted: {{ $initialWishlisted ? 'true' : 'false' }},
             wishlistBusy: false,
             notify(msg, type = 'success') {
                 if (window.showToast) return window.showToast(msg, type);
                 if (type === 'error' && window.Swal) {
                     window.Swal.fire({ icon: 'error', title: 'Something went wrong', text: msg, confirmButtonColor: '#1B2A4A' });
                 }
             },
             async addToCart() {
                 if (this.adding || this.added) return;
                 this.adding = true;
                 try {
                     const res = await fetch('{{ route('cart.store') }}', {
                         method: 'POST',
                         headers: {
                             'Content-Type': 'application/json',
                             'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                             'X-Requested-With': 'XMLHttpRequest',
                             'Accept': 'application/json',
                         },
                         body: JSON.stringify({ product_id: {{ $product->id }}, quantity: 1 })
                     });

                     if (res.status === 401) {
                         window.location.href = '{{ route('login') }}';
                         return;
                     }

                     const data = await res.json();

                     if (!res.ok || !data.success) {
                         this.notify(data.message || 'Could not add to cart.', 'error');
                         return;
                     }

                     if (window.Alpine && Alpine.store('cart')) {
                         Alpine.store('cart').count = data.cart_count;
                     }

                     this.added = true;

                     if (window.showToast) {
                         window.showToast(data.message, 'success');
                     } else {
                         window.dispatchEvent(new CustomEvent('cart:added', { detail: {
                             name: {{ Js::from($product->name) }},
                             image: {{ Js::from($mainUrl) }},
                             price: {{ Js::from($product->formattedPrice()) }},
                             quantity: 1,
                             count: data.cart_count
                         } }));
                     }

                     setTimeout(() => { this.added = false; }, 1200);
                 } catch (e) {
                     this.notify('Network error. Please try again.', 'error');
                 } finally {
                     this.adding = false;
                 }
             },
             async toggleWishlist() {
                 if (this.wishlistBusy) return;
                 @if ($isGuest)
                     window.location.href = '{{ route('login') }}';
                     return;
                 @endif
                 this.wishlistBusy = true;
                 try {
                     const res = await fetch('{{ route('wishlist.toggle') }}', {
                         method: 'POST',
                         headers: {
                             'Content-Type': 'application/json',
                             'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                             'X-Requested-With': 'XMLHttpRequest',
                             'Accept': 'application/json',
                         },
                         body: JSON.stringify({ product_id: {{ $product->id }} })
                     });

                     if (res.status === 401) {
                         window.location.href = '{{ route('login') }}';
                         return;
                     }

                     const data = await res.json();

                     if (!res.ok || !data.success) {
                         this.notify(data.message || 'Could not update wishlist.', 'error');
                         return;
                     }

                     this.wishlisted = !!data.wishlisted;
                     if (window.Alpine && Alpine.store('wishlist')) {
                         Alpine.store('wishlist').count = data.wishlist_count;
                     }
                     if (window.showToast) window.showToast(data.message, 'success');
                 } catch (e) {
                     this.notify('Network error. Please try again.', 'error');
                 } finally {
                     this.wishlistBusy = false;
                 }
             }
         }">

    <!-- Image -->
    <div class="relative rounded-xl overflow-hidden bg-paper aspect-[4/5]">
        <a href="{{ route('product.show', $product->slug) }}"
           class="block w-full h-full focus:outline-none focus-visible:ring-2 focus-visible:ring-gold focus-visible:ring-inset"
           aria-label="{{ $product->name }}">

            @if ($mainUrl)
                <img src="{{ $mainUrl }}"
                     alt="{{ $product->name }}"
                     loading="lazy"
                     decoding="async"
                     class="absolute inset-0 w-full h-full object-contain p-3 sm:p-6 transition duration-500
                            {{ $hoverUrl ? 'md:group-hover:opacity-0' : 'md:group-hover:scale-105' }}"
                     onerror="this.onerror=null; this.src='data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><rect width=%22100%22 height=%22100%22 fill=%22%23FBF8F3%22/><text x=%2250%22 y=%2255%22 text-anchor=%22middle%22 font-size=%2210%22 fill=%22%23C9A96E%22>Mawaddabridals</text></svg>';">

                @if ($hoverUrl)
                    <img src="{{ $hoverUrl }}"
                         alt=""
                         loading="lazy"
                         decoding="async"
                         aria-hidden="true"
                         class="hidden md:block absolute inset-0 w-full h-full object-contain p-6 opacity-0 transition duration-500 md:group-hover:opacity-100 md:group-hover:scale-105"
                         onerror="this.remove()">
                @endif
            @else
                <div class="w-full h-full flex flex-col items-center justify-center gap-1.5 text-gold/50">
                    <i class="fas fa-gem text-2xl sm:text-3xl"></i>
                    <span class="text-[11px] text-muted">No image yet</span>
                </div>
            @endif
        </a>

        <!-- Badges (top-left) -->
        <div class="absolute top-2 left-2 sm:top-3 sm:left-3 flex flex-col items-start gap-1 pointer-events-none max-w-[62%]">
            @if ($onSale)
                <span class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-bold leading-none bg-rose-500 text-white shadow-sm">
                    -{{ $product->discountPercent() }}%
                </span>
            @endif
            @if ($product->is_featured)
                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-[10px] font-semibold leading-none bg-gold text-ink shadow-sm">
                    <i class="fas fa-star text-[8px]"></i>
                    <span class="truncate">Featured</span>
                </span>
            @elseif ($product->is_verified)
                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-[10px] font-semibold leading-none bg-navy text-white shadow-sm">
                    <i class="fas fa-shield-alt text-[8px]"></i>
                    <span class="truncate">Verified</span>
                </span>
            @endif
        </div>

        <!-- Wishlist (36px visible, ~48px tap area) -->
        <button type="button"
                @click.prevent="toggleWishlist()"
                :disabled="wishlistBusy"
                :aria-pressed="wishlisted"
                aria-label="Toggle wishlist for {{ $product->name }}"
                class="absolute top-2 right-2 sm:top-3 sm:right-3 z-10 w-9 h-9 rounded-full bg-white/95 backdrop-blur shadow-sm flex items-center justify-center text-sm transition active:scale-90 md:hover:scale-110 focus:outline-none focus-visible:ring-2 focus-visible:ring-gold disabled:opacity-60 after:content-[''] after:absolute after:-inset-1.5"
                :class="wishlisted ? 'text-rose-500' : 'text-ink/45 md:hover:text-rose-500'">
            <i class="fa-heart" :class="wishlisted ? 'fas' : 'far'"></i>
        </button>

        @if ($lowStock)
            <span class="absolute bottom-2 left-2 sm:bottom-3 sm:left-3 inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-semibold leading-none bg-amber-100 text-amber-800 pointer-events-none">
                Only {{ $product->stock_quantity }} left
            </span>
        @endif

        @if (! $product->inStock())
            <div class="absolute inset-0 bg-white/70 flex items-center justify-center pointer-events-none">
                <span class="px-3.5 py-1.5 rounded-full bg-navy text-white text-xs font-semibold">
                    Out of stock
                </span>
            </div>
        @endif
    </div>

    <!-- Details -->
    <div class="flex flex-col flex-1 min-w-0 px-0.5 sm:px-1 pt-3">

        <a href="{{ $product->category ? route('category.show', $product->category->slug) : '#' }}"
           class="text-[11px] sm:text-xs font-medium text-gold md:hover:text-gold/70 transition-colors truncate">
            {{ $tag() }}
        </a>

        <a href="{{ route('product.show', $product->slug) }}"
           class="block font-display font-semibold text-lg sm:text-xl mt-0.5 leading-[1.2] text-ink md:hover:text-gold transition-colors line-clamp-2 min-h-[2.7rem] sm:min-h-[3rem]"
           title="{{ $product->name }}">
            {{ $product->name }}
        </a>

        <div class="mt-1.5 h-4 flex items-center gap-1 text-[11px] sm:text-xs text-muted">
            @if ($product->rating_count > 0)
                <i class="fas fa-star text-gold text-[10px]"></i>
                <span class="font-semibold text-ink">{{ number_format((float) $product->rating_avg, 1) }}</span>
                <span>({{ $product->rating_count }})</span>
            @else
                <span class="text-muted/70 text-[11px]">No reviews yet</span>
            @endif
        </div>

        <!-- Price + action. Icon-only button on phones, labelled from sm up. -->
        <div class="mt-auto pt-3 flex items-center justify-between gap-2">
            <div class="min-w-0 flex flex-col leading-tight">
                @if ($onSale)
                    <span class="text-[11px] text-muted line-through truncate">{{ $product->formattedCompareAtPrice() }}</span>
                @endif
                <span class="font-semibold text-[15px] sm:text-base truncate {{ $onSale ? 'text-rose-600' : 'text-ink' }}">{{ $product->formattedPrice() }}</span>
            </div>

            @if ($product->inStock())
                @auth
                    <button type="button"
                            @click="addToCart()"
                            :disabled="adding"
                            :class="added ? 'bg-emerald-600 border-emerald-600 text-white' : 'bg-navy border-navy text-white md:hover:bg-gold md:hover:border-gold md:hover:text-ink active:bg-gold active:border-gold active:text-ink'"
                            aria-label="Add {{ $product->name }} to cart"
                            class="shrink-0 inline-flex items-center justify-center gap-2 h-11 w-11 sm:w-auto sm:px-4 rounded-full border text-xs font-semibold transition-all active:scale-95 focus:outline-none focus-visible:ring-2 focus-visible:ring-gold focus-visible:ring-offset-2 disabled:opacity-70 disabled:cursor-wait">
                        <i class="fas text-sm sm:text-xs" :class="added ? 'fa-check' : (adding ? 'fa-spinner fa-spin' : 'fa-shopping-bag')"></i>
                        <span class="hidden sm:inline" x-text="added ? 'Added' : (adding ? 'Adding' : 'Add to bag')"></span>
                    </button>
                @else
                    <a href="{{ route('login') }}"
                       aria-label="Log in to add {{ $product->name }} to cart"
                       class="shrink-0 inline-flex items-center justify-center gap-1.5 h-11 px-4 rounded-full text-xs font-semibold bg-white border border-line text-navy transition-all active:scale-95 md:hover:border-gold md:hover:text-gold focus:outline-none focus-visible:ring-2 focus-visible:ring-gold focus-visible:ring-offset-2">
                        <i class="fas fa-lock text-[10px]"></i>
                        <span>Log in</span>
                    </a>
                @endauth
            @else
                <button type="button" disabled
                        aria-label="{{ $product->name }} is unavailable"
                        class="shrink-0 inline-flex items-center justify-center gap-2 h-11 w-11 sm:w-auto sm:px-4 rounded-full border border-line bg-line/40 text-muted text-xs font-semibold cursor-not-allowed">
                    <i class="fas fa-ban text-sm sm:text-xs"></i>
                    <span class="hidden sm:inline">Unavailable</span>
                </button>
            @endif
        </div>
    </div>
</article>