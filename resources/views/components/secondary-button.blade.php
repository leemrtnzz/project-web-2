<button {{ $attributes->merge(['type' => 'button', 'class' => 'nb-btn nb-btn-ghost']) }}>
    {{ $slot }}
</button>
