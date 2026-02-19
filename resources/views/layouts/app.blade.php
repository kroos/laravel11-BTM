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
	<!--<link rel="dns-prefetch" href="//fonts.gstatic.com"> -->
	<!-- <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> -->
	<!-- <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet"> -->
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet"
  />
	<link href="{{ asset('images/logo.jpg') }}" type="image/x-icon" rel="icon" />
	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{!! config('app.name') !!}</title>
	@vite(['resources/css/app.css', 'resources/scss/app.scss'])
	<link href="{{ URL::asset('css/bootstrap.css') }}" rel="stylesheet">
	@livewireStyles

</head>
<body class="bg-primary-subtle bg-opacity-75 min-vh-100 d-flex flex-column" data-route="{{ Route::currentRouteName() }}">

	<!-- navigator -->
	<nav class="navbar navbar-expand-lg bg-primary rounded" data-bs-theme="dark">
		<div class="container">
				<img src="{{ asset('images/logo.png') }}" alt="UniSHAMS" class="my-auto img-fluid rounded-1" width="3%">
			<a class="navbar-brand" href="{{ url('/dashboard') }}">
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

	<div class="container-fluid flex-fill d-flex flex-column">

		<div class="container-fluid p-1 mx-auto d-flex justify-content-between flex-fill">

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

	</div>

	<!-- footer -->
	<div class="container py-3 align-self-bottom text-center text-sm text-secondary">
		&copy; Bahagian Teknologi Maklumat, UniSHAMS.<br />
		{{ config('app.name', 'Laravel') }} develop using Laravel v{{ Illuminate\Foundation\Application::VERSION }}
	</div>
	<!-- footer end -->

</body>
@livewireScripts
@vite(['resources/js/app.js'])
<script type="module">
	$(document).ready(function(){
		@section('js')
		@show
	});
</script>
</html>
