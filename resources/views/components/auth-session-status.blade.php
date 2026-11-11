@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'inline-flex border-2 border-ink bg-pop-lime px-3 py-2 text-sm font-bold text-ink']) }}>
        {{ $status }}
    </div>
@endif
