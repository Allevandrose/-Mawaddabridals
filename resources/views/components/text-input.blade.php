@props(['disabled' => false])

<input @disabled($disabled)
    {{ $attributes->merge([
        'class' => 'rounded-full border border-line bg-paper px-5 h-12 text-sm text-ink placeholder:text-muted/60
                    focus:border-gold focus:ring-2 focus:ring-gold/30 focus:outline-none transition
                    disabled:opacity-60 disabled:cursor-not-allowed'
    ]) }}>