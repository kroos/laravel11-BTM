<x-app-layout>

	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Email Registration Account Form') }}
		</h2>
	</x-slot>

	<form action="{{ route('emailaccapp.update', $emailaccapp->id) }}" method="POST">
		@method('PATCH')
		@csrf
		@include('email._form')
	</form>

@section('js')
	@include('email._js')
@endsection
</x-app-layout>
