<section>
    <header class="mb-6">
        <h2 class="font-serif text-xl font-semibold text-navy flex items-center gap-2">
            <i class="fas fa-lock text-gold text-base"></i> {{ __('Update Password') }}
        </h2>
        <p class="mt-1 text-sm text-muted">{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" class="!text-xs !uppercase !tracking-luxe !text-muted !font-semibold !mb-2" />
            <div class="relative">
                <x-text-input id="update_password_current_password" name="current_password" type="password" 
                    class="block w-full !rounded-full !border-line !bg-paper !px-5 !pr-12 !h-12 !text-sm focus:!border-gold focus:!ring-2 focus:!ring-gold/30" 
                    autocomplete="current-password" 
                    placeholder="••••••••" />
                <!-- Eye Toggle -->
                <button type="button" 
                    onclick="togglePasswordVisibility('update_password_current_password', 'eye-icon-current')"
                    class="absolute right-4 top-1/2 -translate-y-1/2 text-muted hover:text-navy transition-colors focus:outline-none">
                    <i id="eye-icon-current" class="fas fa-eye text-sm"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 !text-rose-500" />
        </div>

        <!-- New Password -->
        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" class="!text-xs !uppercase !tracking-luxe !text-muted !font-semibold !mb-2" />
            <div class="relative">
                <x-text-input id="update_password_password" name="password" type="password" 
                    class="block w-full !rounded-full !border-line !bg-paper !px-5 !pr-12 !h-12 !text-sm focus:!border-gold focus:!ring-2 focus:!ring-gold/30" 
                    autocomplete="new-password" 
                    placeholder="Leave blank to keep current" />
                <!-- Eye Toggle -->
                <button type="button" 
                    onclick="togglePasswordVisibility('update_password_password', 'eye-icon-new')"
                    class="absolute right-4 top-1/2 -translate-y-1/2 text-muted hover:text-navy transition-colors focus:outline-none">
                    <i id="eye-icon-new" class="fas fa-eye text-sm"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 !text-rose-500" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" class="!text-xs !uppercase !tracking-luxe !text-muted !font-semibold !mb-2" />
            <div class="relative">
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" 
                    class="block w-full !rounded-full !border-line !bg-paper !px-5 !pr-12 !h-12 !text-sm focus:!border-gold focus:!ring-2 focus:!ring-gold/30" 
                    autocomplete="new-password" 
                    placeholder="Leave blank to keep current" />
                <!-- Eye Toggle -->
                <button type="button" 
                    onclick="togglePasswordVisibility('update_password_password_confirmation', 'eye-icon-confirm')"
                    class="absolute right-4 top-1/2 -translate-y-1/2 text-muted hover:text-navy transition-colors focus:outline-none">
                    <i id="eye-icon-confirm" class="fas fa-eye text-sm"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 !text-rose-500" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="inline-flex items-center justify-center gap-2 h-11 px-6 rounded-full bg-navy text-white text-sm font-semibold tracking-wide hover:bg-navy/90 transition shadow-sm">
                {{ __('Update Password') }}
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-green-600 flex items-center gap-1.5">
                    <i class="fas fa-check-circle"></i> {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>

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