<x-app-layout>

	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('404') }}
		</h2>
	</x-slot>

	<div class="col-12-sm" >
		<a href="{{ url('/dashboard') }}" class="">
			<img src="{{ asset('images/errors/404-error.jpg') }}" class="img-fluid rounded " alt="">
		</a>
	</div>

@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////
@endsection
</x-app-layout>
