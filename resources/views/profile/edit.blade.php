<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="font-serif text-2xl sm:text-3xl font-semibold text-navy tracking-tight leading-tight">
                    {{ __('My Account') }}
                </h2>
                <p class="text-sm text-muted mt-1">Manage your personal details, security, and preferences.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 sm:py-12 bg-paper min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-[300px_minmax(0,1fr)] gap-8">
                
                {{-- LEFT SIDEBAR: User Summary & Quick Nav --}}
                <aside class="space-y-6">
                    {{-- Profile Card --}}
                    <div class="bg-navy rounded-3xl p-6 text-white shadow-lg relative overflow-hidden">
                        <i class="fas fa-gem absolute -right-4 -bottom-4 text-6xl text-white/[0.05] rotate-12 pointer-events-none"></i>
                        
                        <div class="relative z-10 flex flex-col items-center text-center">
                            <div class="h-20 w-20 rounded-full bg-gradient-to-br from-gold to-gold-soft flex items-center justify-center text-navy text-3xl font-bold border-4 border-navy shadow-inner mb-4">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <h3 class="font-serif text-xl font-semibold truncate w-full">{{ auth()->user()->name }}</h3>
                            <p class="text-sm text-white/60 truncate w-full">{{ auth()->user()->email }}</p>
                            <span class="inline-block mt-3 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-luxe bg-white/10 text-gold border border-white/10">
                                {{ ucfirst(auth()->user()->user_type) }}
                            </span>
                        </div>
                    </div>

                    {{-- Quick Links --}}
                    <div class="bg-white rounded-2xl border border-line shadow-sm p-2">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-ink hover:bg-paper transition-colors">
                            <i class="fas fa-gauge w-5 text-center text-gold"></i> Dashboard
                        </a>
                        <a href="{{ route('cart.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-ink hover:bg-paper transition-colors">
                            <i class="fas fa-shopping-bag w-5 text-center text-gold"></i> My Bag
                        </a>
                        <a href="{{ route('wishlist.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-ink hover:bg-paper transition-colors">
                            <i class="far fa-heart w-5 text-center text-rose-400"></i> My Wishlist
                        </a>
                    </div>
                </aside>

                {{-- RIGHT CONTENT: Forms --}}
                <div class="space-y-6 min-w-0">
                    <!-- Profile Information -->
                    <div class="bg-white rounded-2xl border border-line shadow-sm p-6 sm:p-8">
                        @include('profile.partials.update-profile-information-form')
                    </div>

                    <!-- Vendor Shop Information (vendors only) -->
                    @if (auth()->user()->isVendor())
                        <div class="bg-white rounded-2xl border border-line shadow-sm p-6 sm:p-8">
                            @include('profile.partials.vendor-shop-information')
                        </div>
                    @endif

                    <!-- Google Account (Passing $user explicitly) -->
                    <div class="bg-white rounded-2xl border border-line shadow-sm p-6 sm:p-8">
                        @include('profile.partials.google-account-form', ['user' => auth()->user()])
                    </div>

                    <!-- Update Password -->
                    <div class="bg-white rounded-2xl border border-line shadow-sm p-6 sm:p-8">
                        @include('profile.partials.update-password-form')
                    </div>

                    <!-- Delete User -->
                    <div class="bg-white rounded-2xl border-2 border-rose-400/20 shadow-sm p-6 sm:p-8 relative overflow-hidden">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function togglePasswordVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
    @endpush
</x-app-layout>