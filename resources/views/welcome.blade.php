<x-guest-layout>

@section('content')
<div class="col-12 text-center jumbotron">
	<!-- <img src="{{ asset('images/front.jpg') }}" class="rounded img-fluid img-thumbnail mx-auto d-block" alt="Welcome to {{ env('APP_NAME') }}"> -->
	<picture>
	  <source srcset="{{ asset('images/front1.jpg') }}">
	  <source srcset="{{ asset('images/front2.jpg') }}">
	  <source srcset="{{ asset('images/front3.jpg') }}">
	  <img src="{{ asset('images/front.jpg') }}" class="rounded img-fluid img-thumbnail mx-auto d-block" alt="Welcome to {{ env('APP_NAME') }}">
	</picture>

</div>
@endsection

@section('js')
@endsection
</x-guest-layout>
