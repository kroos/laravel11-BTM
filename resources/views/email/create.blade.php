<x-app-layout>

	<x-slot name="header">
		<h2 class="font-montserrat font-semibold text-xl text-gray-800 leading-tight">
			{{ __('BTM01 - BORANG PERMOHONAN ALAMAT EMEL RASMI unishams.edu.my') }}
		</h2>
	</x-slot>

	<form method="POST" action="{{ route('emailaccapp.store') }}" accept-charset="UTF-8" id="form" autocomplete="off" class="needs-validation" enctype="multipart/form-data">
		@csrf
		@include('email._form')
	</form>

@section('js')
		@include('email._js')
@endsection
</x-app-layout>
