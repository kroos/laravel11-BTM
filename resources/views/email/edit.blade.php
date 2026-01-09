<x-app-layout>

	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Email Registration Account Form') }}
		</h2>
	</x-slot>

	<form method="POST" action="{{ route('emailaccapp.update', $emailaccapp) }}" accept-charset="UTF-8" id="form" autocomplete="off" class="needs-validation" enctype="multipart/form-data">
		@method('PATCH')
		@csrf
		@include('email._form')
	</form>

@section('js')
	@include('email._js')
@endsection
</x-app-layout>
