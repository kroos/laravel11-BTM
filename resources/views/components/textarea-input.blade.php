@props(['disabled' => false])

<textarea {{ $disabled ? 'disabled' : NULL }} {!! $attributes->merge(['class' => 'form-control form-control-sm']) !!}>
	{{ $slot }}
</textarea>
