<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="description" content="">
	<meta name="keywords" content="btm loan equipment" />

	<title>{{ config('app.name', 'Laravel') }}</title>

	<!-- Fonts -->
	<link rel="dns-prefetch" href="//fonts.gstatic.com">
	<link href="{{ asset('images/logo.jpg') }}" type="image/x-icon" rel="icon" />
	<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{!! config('app.name') !!}</title>
	<!-- Styles -->
	<link href="{{ URL::asset('css/app.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('css/bootstrap.css') }}" rel="stylesheet">
	{{-- <link href="{{ URL::asset('css/jquery-ui-bootstrap5-datepicker.css') }}" rel="stylesheet"> --}}
	@livewireStyles

</head>
<body class=" bg-secondary bg-opacity-75">
	<div class="container-fluid row min-vh-100 align-items-center justify-content-center mx-auto">

		<!-- navigator -->
		<nav class="navbar navbar-expand-lg align-self-start bg-primary rounded" data-bs-theme="dark">
			<div class="container-fluid">
				<a class="navbar-brand" href="{{ url('/dashboard') }}">
					<img src="{{ asset('images/logo.png') }}" alt="UniSHAMS" class="img-thumbnail" width="30%">
				</a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarColor01">
					<ul class="navbar-nav me-auto">
						<li class="nav-item">
							<a class="nav-link" href="{{ url('/dashboard') }}">Home
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
@php
$user = \App\Models\Login::find(\Auth::user()->nostaf);
$user->setConnection('mysql3');
// echo $user->unreadNotifications->count();
// dd($user->unreadNotifications->first()->data);
// foreach ($user->unreadNotifications as $notification) {
// 	echo $notification->data['data'];
// }
@endphp
						<div class="dropdown">
							<a href="{{ url('/dashboard') }}" class="btn btn-sm btn-outline-secondary dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
								@if($user->unreadNotifications->count())<span class="badge text-bg-warning">{{$user->unreadNotifications->count()}}</span>@endif
								{{ Auth::user()->name }}
							</a>
							<ul class="dropdown-menu">
								@if($user->unreadNotifications->count())
									@foreach($user->unreadNotifications as $v)
										<li>
											<a class="dropdown-item" href="{{ $v->data['link'] }}">
												<i class="fa-regular fa-comment"></i>
												{{ $v->data['data'] }}
											</a>
										</li>
									@endforeach
								@endif
								<form method="POST" action="{{ route('logout') }}">
									@csrf
									<li>
										<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"><i class="fas fa-light fa-right-from-bracket"></i> Log Out</a>
									</li>
								</form>
							</ul>
						</div>
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

		<div class="container row align-self-start justify-content-center m-0">
			@yield('content')
			{{ $slot }}
		</div>

		<!-- footer -->
		<div class="container py-3 align-self-end text-center text-sm text-secondary">
			Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
		</div>
		<!-- footer end -->

	</div>

</body>
<script src="{{ asset('js/fullcalendar/index.global.js') }}"></script>
<!-- <script type="module" src="{{ asset('js/fullcalendar/bootstrap5/index.global.js') }}"></script> -->
<!-- <script type="module" src="{{ asset('js/fullcalendar/daygrid/index.global.js') }}"></script> -->
<!-- <script type="module" src="{{ asset('js/fullcalendar/multimonth/index.global.js') }}"></script> -->
<!-- <script src="https://unpkg.com/popper.js/dist/umd/popper.min.js"></script> -->
<!-- <script src="https://unpkg.com/tooltip.js/dist/umd/tooltip.min.js"></script> -->
<script src="{{ asset('js/chartjs/chart.umd.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('js/ckeditor/adapters/jquery.js') }}"></script>
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
