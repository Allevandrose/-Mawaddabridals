@props(['status'])

@if ($status)
    <div {{ $attributes->merge([
        'class' => 'p-3 rounded-xl bg-gold/15 border border-gold/40 text-sm text-[#A88B5E] flex items-start gap-2'
    ]) }}>
        <i class="fas fa-check-circle text-gold mt-0.5"></i>
        <span>{{ $status }}</span>
    </div>
@endif