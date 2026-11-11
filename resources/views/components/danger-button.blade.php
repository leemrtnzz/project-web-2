<button {{ $attributes->merge(['type' => 'submit', 'class' => 'nb-btn nb-btn-danger']) }}>
    {{ $slot }}
</button>
