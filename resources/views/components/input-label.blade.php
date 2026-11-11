@props(['value'])

<label {{ $attributes->merge(['class' => 'nb-label']) }}>
    {{ $value ?? $slot }}
</label>
