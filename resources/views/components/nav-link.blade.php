@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center whitespace-nowrap border-4 border-ink bg-pop-yellow px-3 py-2 text-sm font-bold uppercase tracking-wide text-ink shadow-nb-sm'
            : 'inline-flex items-center whitespace-nowrap border-4 border-transparent px-3 py-2 text-sm font-bold uppercase tracking-wide text-ink transition hover:border-ink hover:bg-pop-cyan';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
