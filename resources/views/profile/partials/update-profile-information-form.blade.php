<section>
    <header class="mb-6">
        <h2 class="font-serif text-xl font-semibold text-navy flex items-center gap-2">
            <i class="fas fa-user text-gold text-base"></i> {{ __('Profile Information') }}
        </h2>
        <p class="mt-1 text-sm text-muted">{{ __("Update your account's profile information and email address.") }}</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Full Name')" class="!text-xs !uppercase !tracking-luxe !text-muted !font-semibold !mb-2" />
            <x-text-input id="name" name="name" type="text" class="block w-full !rounded-full !border-line !bg-paper !px-5 !h-12 !text-sm focus:!border-gold focus:!ring-2 focus:!ring-gold/30" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2 !text-rose-500" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email Address')" class="!text-xs !uppercase !tracking-luxe !text-muted !font-semibold !mb-2" />
            <x-text-input id="email" name="email" type="email" class="block w-full !rounded-full !border-line !bg-paper !px-5 !h-12 !text-sm focus:!border-gold focus:!ring-2 focus:!ring-gold/30" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2 !text-rose-500" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 p-3 rounded-xl bg-gold/10 border border-gold/30 text-sm">
                    <p class="text-[#A88B5E]">
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification" class="underline font-semibold hover:text-navy transition-colors">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="inline-flex items-center justify-center gap-2 h-11 px-6 rounded-full bg-navy text-white text-sm font-semibold tracking-wide hover:bg-navy/90 transition shadow-sm">
                {{ __('Save Changes') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-green-600 flex items-center gap-1.5">
                    <i class="fas fa-check-circle"></i> {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>