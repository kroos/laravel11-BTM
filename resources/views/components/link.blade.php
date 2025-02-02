@props(['active'])

@php
$classes = ($active ?? false)
            ? 'btn btn-sm btn-primary'
            : '';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
