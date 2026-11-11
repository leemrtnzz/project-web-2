@props(['active'])

@php
$classes = ($active ?? false)
            ? 'my-1 block w-full border-4 border-ink bg-pop-yellow px-3 py-2 text-start text-sm font-bold uppercase tracking-wide shadow-nb-sm'
            : 'my-1 block w-full border-4 border-transparent px-3 py-2 text-start text-sm font-bold uppercase tracking-wide transition hover:border-ink hover:bg-pop-cyan';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
