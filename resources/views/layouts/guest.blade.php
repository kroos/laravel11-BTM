<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="description" content="">
	<meta name="keywords" content="erp system, erp" />

	<title>{{ config('app.name', 'Laravel') }}</title>

	<!-- Fonts -->
	<link rel="dns-prefetch" href="//fonts.gstatic.com">
	<link href="{{ asset('images/logo.jpg') }}" type="image/x-icon" rel="icon" />
	<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{!! config('app.name') !!}</title>
	<!-- Styles -->
	@vite(['resources/css/app.css', 'resources/scss/app.scss', 'resources/js/app.js'])
	<link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
	@livewireStyles

</head>
<body class="bg-primary-subtle bg-opacity-75 min-vh-100 d-flex flex-column">

			<!-- navigator -->
			<nav class="navbar navbar-expand-lg bg-primary rounded" data-bs-theme="dark">
				<div class="container-fluid">
						<img src="{{ asset('images/logo.png') }}" alt="UniSHAMS" class="my-auto img-fluid rounded-1" width="3%">
					<a class="navbar-brand" href="{{ url('/') }}">
						{!! config('app.name') !!}
					</a>
					<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse" id="navbarColor01">
						<ul class="navbar-nav mx-auto">
							@auth
								@include('layouts.nav-app')
							@else
								@include('layouts.nav-guest')
							@endauth
						</ul>
						@auth
							<form method="POST" action="{{ route('logout') }}">
								@csrf
								<a href="{{ route('logout') }}" class="btn btn-info btn-sm text-white my-2 my-sm-0" type="submit" onclick="event.preventDefault();this.closest('form').submit();">Log Out</a>
							</form>
						@else
							<a href="{{ route('login') }}" class="btn btn-info btn-sm text-white my-2 my-sm-0">Log Masuk</a>
						@endauth
					</div>
				</div>
			</nav>
			<!-- navigator end -->

	<div class="container-fluid mx-auto d-flex flex-fill justify-content-evenly p-1">

		<div class="col-sm-2 m-0">
		</div>

		<div class="col-sm-8 m-0 my-2 p-1 align-self-center">

			<div class="col-sm-12 row justify-content-center m-0">
				@include('layouts.messages')
				@isset($header)
					<div class="shadow">
						{{ $header }}
					</div>
				@endisset
			</div>

			<div class="col-sm-12 row justify-content-center m-0">
				@yield('content')
				{{ $slot }}
			</div>

		</div>

		<div class="col-sm-2 m-0 p-1">
		</div>

	</div>

	<!-- footer -->
	<div class="container align-self-bottom py-3 text-center text-sm text-secondary fw-lighter">
		&copy; Bahagian Teknologi Maklumat, UniSHAMS.<br />
		{{ config('app.name', 'Laravel') }} develop using Laravel v{{ Illuminate\Foundation\Application::VERSION }}
	</div>
	<!-- footer end -->

</body>
<script type="javascript" src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
<script type="javascript" src="{{ asset('js/ckeditor/adapters/jquery.js') }}"></script>

<script type="module">
	jQuery.noConflict ();
	(function($){
		$(document).ready(function(){
			@section('js')
			@show
		});
	})(jQuery);
</script>
@livewireScripts
</html>
