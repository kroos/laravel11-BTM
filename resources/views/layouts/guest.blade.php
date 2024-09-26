<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Laravel') }}</title>

	<!-- Fonts -->
	<link rel="dns-prefetch" href="//fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
	@vite('resources/css/app.css')
	@livewireStyles
	<link href="{{ asset('assets/bootstrap.css') }}" rel="stylesheet">

</head>
<body class="container-fluid d-flex flex-column min-vh-100 align-items-center justify-content-center border border-danger">
	<div class="container-fluid border border-primary rounded">

		<!-- navigator -->
		<nav class="navbar navbar-expand-lg bg-primary rounded" data-bs-theme="dark">
			<div class="container-fluid">
				<a class="navbar-brand" href="{{ url('/') }}">
					<img src="{{ asset('assets/image/UniSHAMS.webp') }}" alt="UniSHAMS" class="img-thumbnail" width="30%">
				</a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarColor01">
					<ul class="navbar-nav me-auto">
						<li class="nav-item">
							<a class="nav-link {{ (request()->route()->uri == '/')?'active':NULL }}" href="{{ url('/') }}">Home
								<span class="visually-hidden">(current)</span>
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

	</div>

	<div class="container d-flex align-items-center justify-content-center border border-secondary rounded">
		<noscript>
			<style type="text/css">
				.pagecontainer {display:none;}
			</style>
			<div class="noscriptmsg text-danger">
				This page requires JavaScript. Please enable it or you can contact your IT administrator.
				<meta http-equiv="refresh" content="3; url={{ url('/') }}" />
			</div>
		</noscript>

		<!-- IF SUCCESS -->
		@if(Session::has('success'))
		<h6 class="pb-4 mb-4 border-bottom text-center alert alert-success">
			{{ Session::get('success') }}
		</h6>
		@endif

		<!-- IF ERROR -->
		@if(Session::has('danger'))
		<h6 class="pb-4 mb-4 border-bottom text-center alert alert-danger">
			{{ Session::get('danger') }}
		</h6>
		@endif

		@if(Session::has('status'))
		<h6 class="pb-4 mb-4 border-bottom text-center alert alert-primary">
			{{ Session::get('status') }}
		</h6>
		@endif
	</div>

	<div class="container d-flex align-items-center justify-content-center row border border-warning rounded">

		<!-- Page Heading -->
		@isset($header)
				<div class="shadow">
					{{ $header }}
				</div>
		@endisset

		@yield('content')
		{{ $slot }}
	</div>

	<!-- footer -->
	<div class="container-fluid d-flex align-items-center justify-content-center text-sm text-black mt-auto border border-warning rounded">
		Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
	</div>
	<!-- footer end -->

</body>
<script type="text/javascript" src="{{ asset('assets/bootstrap/dist/js/bootstrap.bundle.js') }}"></script>
@vite('resources/js/app.js')
<script type="module" src="{{ asset('assets/jquery-chained/jquery.chained.js') }}"></script>
<script type="module" src="{{ asset('assets/jquery-chained/jquery.chained.remote.js') }}"></script>
<script type="module" src="{{ asset('assets/jquery-ui/dist/jquery-ui.js') }}"></script>
<script type="module" src="{{ asset('assets/bootstrapValidator/bootstrapValidator.js') }}"></script>
<script type="module" src="{{ asset('assets/datatable/dataTable-any-number.js') }}"></script>
<script type="module" src="{{ asset('assets/datatable/datetime-moment.js') }}"></script>

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
