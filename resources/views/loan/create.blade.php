<x-app-layout>

	<x-slot name="header">
		<h2 class="font-montserrat font-semibold text-xl text-gray-800 leading-tight">
			{{ __('BTM03 - BORANG PINJAMAN PERALATAN') }}
		</h2>
	</x-slot>

	<form action="{{ route('loanapp.store') }}" method="POST">
			@csrf
			@include('loan._form')
	</form>

@section('js')
	@include('loan._js')
@endsection
</x-app-layout>
