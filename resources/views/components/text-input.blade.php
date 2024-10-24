@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : NULL }} {!! $attributes->merge(['class' => 'form-control form-control-sm']) !!} />
