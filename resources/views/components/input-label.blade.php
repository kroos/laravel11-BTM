@props(['value'])
<label {{ $attributes->merge(['class' => 'form-label form-label-sm']) }}>
	{{ $value ?? $slot }}
</label>
