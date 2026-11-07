<x-guest-layout>

    {{-- Heading --}}
    <div class="mb-8">
        <p class="text-xs uppercase tracking-luxe text-gold font-semibold mb-2">Welcome back</p>
        <h2 class="font-display text-4xl sm:text-5xl font-semibold text-navy tracking-tight leading-[1.05]">
            Sign in to <span class="italic">Mawadda.</span>
        </h2>
        <p class="text-sm text-muted mt-3">Manage your bag, wishlist and bridal fittings.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email address')"
                class="!text-xs !uppercase !tracking-luxe !text-muted !font-semibold !mb-2" />
            <x-text-input id="email"
                class="block w-full !rounded-full !border-line !bg-paper !px-5 !h-12 !text-sm focus:!border-gold focus:!ring-2 focus:!ring-gold/30"
                type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                placeholder="you@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 !text-rose-500" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-2">
                <x-input-label for="password" :value="__('Password')"
                    class="!text-xs !uppercase !tracking-luxe !text-muted !font-semibold" />
                @if (Route::has('password.request'))
                    <a class="text-xs font-medium text-gold hover:text-navy transition-colors"
                        href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif
            </div>
            <x-text-input id="password"
                class="block w-full !rounded-full !border-line !bg-paper !px-5 !h-12 !text-sm focus:!border-gold focus:!ring-2 focus:!ring-gold/30"
                type="password" name="password" required autocomplete="current-password"
                placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 !text-rose-500" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center gap-2.5 cursor-pointer select-none">
                <input id="remember_me" type="checkbox" name="remember"
                    class="h-4 w-4 rounded border-line text-gold shadow-sm focus:ring-gold focus:ring-offset-paper">
                <span class="text-sm text-ink/70">Remember me</span>
            </label>
        </div>

        <!-- Submit -->
        <button type="submit"
            class="w-full inline-flex items-center justify-center gap-2 h-12 rounded-full bg-navy text-white text-sm font-semibold tracking-wide hover:bg-navy/90 active:scale-[0.98] transition shadow-[0_12px_24px_-10px_rgba(27,42,74,0.55)]">
            Sign in
            <i class="fas fa-arrow-right text-xs"></i>
        </button>
    </form>

    <!-- Divider -->
    <div class="relative flex items-center my-7">
        <div class="flex-grow border-t border-line"></div>
        <span class="flex-shrink mx-4 text-[11px] uppercase tracking-luxe text-muted">or</span>
        <div class="flex-grow border-t border-line"></div>
    </div>

    <!-- Google -->
    <a href="{{ route('auth.google.redirect') }}"
        class="w-full inline-flex items-center justify-center gap-3 h-12 bg-white border border-line rounded-full text-sm font-medium text-ink hover:border-gold hover:bg-white transition-colors shadow-sm">
        <svg class="w-5 h-5" viewBox="0 0 24 24" aria-hidden="true">
            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 01-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z" fill="#4285F4"/>
            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
        </svg>
        Continue with Google
    </a>

    <!-- Register -->
    <p class="mt-8 text-center text-sm text-ink/60">
        New to Mawaddabridals?
        <a href="{{ route('register') }}" class="font-semibold text-gold hover:text-navy transition-colors">
            Create an account
        </a>
    </p>

</x-guest-layout>