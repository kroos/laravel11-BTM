@props(['messages'])

<div class="invalid-feedback text-sm">
	@if ($messages)
		@foreach ((array) $messages as $message)
			{{ $message }}
		@endforeach
	@endif
</div>
