<x-app-layout>

	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('404') }}
		</h2>
	</x-slot>

	<div class="p-4 p-md-5 mb-4 rounded text-body-emphasis bg-body-secondary" style="background-image: url('{{ asset('images/errors/404-error.jpg') }}'); background-repeat: no-repeat; background-position: center center; ">
		<div class="col-lg-6 px-0">
			<h1 class="display-4 fst-italic">404 : Page Not Found</h1>
			<p class="lead my-3">Please click on link below.</p>
			<p class="lead mb-0"><a href="{{ url('/') }}" class="btn btn-lg btn-outline-secondary text-body-emphasis fw-bold">Home</a></p>
		</div>
	</div>

@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////
@endsection
</x-app-layout>
