<x-app-layout>

	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Edit Equipment Loan Application Form') }}
		</h2>
	</x-slot>

	<form action="{{ route('loanapp.update', $loanapp->id) }}" method="POST">
			@csrf
			@method('PATCH')
			@include('loan._form')
	</form>

@section('js')
	@include('loan._js')
@endsection
</x-app-layout>
