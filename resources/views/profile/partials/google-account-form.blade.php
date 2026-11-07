@props(['user'])

<section>
    <header class="mb-6">
        <h2 class="font-serif text-xl font-semibold text-navy flex items-center gap-2">
            <i class="fas fa-user-shield text-gold text-base"></i> {{ __('Google Account') }}
        </h2>
        <p class="mt-1 text-sm text-muted">{{ __("Link or disconnect your Google account for quick login.") }}</p>
    </header>

    <div class="p-5 bg-paper rounded-2xl border border-line">
        @if($user->google_id)
            <!-- Connected -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="h-10 w-10 rounded-full bg-white border border-line flex items-center justify-center shadow-sm">
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 01-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z" fill="#4285F4"/>
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-ink">Connected to Google</p>
                        <p class="text-xs text-muted">{{ $user->email }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('auth.google.disconnect') }}" onsubmit="return confirm('Are you sure you want to disconnect your Google account?');">
                    @csrf
                    <button type="submit" class="inline-flex items-center justify-center gap-2 h-10 px-5 rounded-full bg-rose-400 text-white text-xs font-semibold tracking-wide hover:bg-rose-500 transition-colors shadow-sm">
                        <i class="fas fa-unlink text-[10px]"></i> Disconnect
                    </button>
                </form>
            </div>
        @else
            <!-- Not Connected -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <p class="text-sm font-medium text-ink">No Google account linked.</p>
                    <p class="text-xs text-muted mt-1">Link your Google account for quicker, one-click sign-in.</p>
                </div>
                <a href="{{ route('auth.google.redirect') }}" 
                   class="inline-flex items-center justify-center gap-2 h-10 px-5 rounded-full bg-white border border-line text-ink text-xs font-semibold tracking-wide hover:border-gold hover:bg-paper transition-colors shadow-sm whitespace-nowrap">
                    <svg class="w-4 h-4" viewBox="0 0 24 24">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 01-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    Link Google Account
                </a>
            </div>
        @endif
    </div>
</section>