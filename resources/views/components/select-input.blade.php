@props(['disabled' => false, 'multiple' => false])

<select {{ $disabled ? 'disabled' : NULL }} {{ $multiple ? 'multiple' : NULL }} {!! $attributes->merge(['class' => 'form-select form-select-sm']) !!}>
	<option value="">Please Choose</option>
	{{ $slot }}
</select>
