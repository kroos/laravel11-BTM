<x-app-layout>

	<x-slot name="header">
		<h2 class="font-montserrat font-semibold text-xl text-gray-800 leading-tight text-center">
			{{ __('BTM02 - BORANG PENDAFTARAN AKAUN DAN MODUL ICMS') }}
		</h2>
	</x-slot>

	<form action="{{ route('regaccicms.update', $regaccicm) }}" method="POST" class="needs-validation" novalidate>
		@method('PATCH')
		@csrf
		@include('regaccicms._form')
	</form>

	@section('js')
		@include('regaccicms._js')
	@endsection
</x-app-layout>
