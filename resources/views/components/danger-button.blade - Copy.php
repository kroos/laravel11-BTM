<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-sm btn-danger']) }}>
    {{ $slot }}
</button>
