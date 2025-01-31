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
	<link href="{{ URL::asset('css/bootstrap.css') }}" rel="stylesheet">
	@livewireStyles

</head>
<body class="bg-secondary bg-opacity-75">

	<div class="container-fluid row min-vh-100 align-items-center justify-content-center mx-auto">

			<!-- navigator -->
			<nav class="navbar navbar-expand-lg align-self-start bg-primary rounded" data-bs-theme="dark">
				<div class="container-fluid">
					<a class="navbar-brand" href="{{ url('/') }}">
						<img src="{{ asset('images/logo.png') }}" alt="UniSHAMS" class="img-thumbnail" width="30%">
					</a>
					<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse" id="navbarColor01">
						<ul class="navbar-nav me-auto">
							<li class="nav-item">
								<a class="nav-link" href="{{ url('/') }}">Home
								</a>
							</li>
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
							<a href="{{ route('login') }}" class="btn btn-info btn-sm text-white my-2 my-sm-0">Sign In</a>
						@endauth
					</div>
				</div>
			</nav>
			<!-- navigator end -->

		<div class="col-sm-12 row justify-content-center m-0">
			@include('layouts.messages')
			@isset($header)
				<div class="shadow">
					{{ $header }}
				</div>
			@endisset
		</div>

		<div class="container row justify-content-center m-0">
			@yield('content')
			{{ $slot }}
		</div>

		<!-- footer -->
		<div class="container align-self-end py-3 text-center text-sm text-secondary fw-lighter">
			Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
		</div>
		<!-- footer end -->

	</div>

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
