<x-guest-layout>
	<x-slot name="header" >
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Welcome to BTMgo') }}
		</h2>
	</x-slot>
	<form method="POST" action="{{ route('login') }}" id="form" class="" >
		@csrf

		<!-- Username -->
		<div class="form-group col-sm-12 row mb-3 @error('username') is-invalid @enderror ">
			<label class="col-form-label col-sm-4" for="username">No. Staf : </label>
			<div class="col-sm-8 my-auto">
				<input id="username" name="username" :value="old('username')" class="form-control form-control-sm @error('username') is-invalid @enderror"/>
				<x-input-error :messages="$errors->get('username')" />
			</div>
		</div>

		<!-- Password -->
		<div class="form-group col-sm-12 row mb-3 @error('password') is-invalid @enderror">
			<x-input-label for="password" class="col-sm-4 col-form-label" :value="__('Password : ')" />
			<div class="col-sm-8 my-auto">
				<input type="password" id="password" name="password" :value="old('password')" autocomplete="current-password" class="form-control form-control-sm @error('password') is-invalid @enderror" />
				<x-input-error :messages="$errors->get('password')" />
			</div>
		</div>

		<!-- Remember Me -->
		<div class="form-check mb-3">
			<label for="remember_me" class="form-check-label">
				<input type="checkbox" name="remember" id="remember_me" class="form-check-input rounded" >
				<span class="text-sm">Remember me</span>
			</label>
		</div>
			<x-primary-button class="ml-3" type="submit">
				{{ __('Log Masuk') }}
			</x-primary-button>
	</form>

@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
// validator
// $(document).ready(function() {
// 	$('#form').bootstrapValidator({
// 		fields: {
// 			username: {
// 				validators: {
// 					notEmpty: {
// 						message: 'Please insert username'
// 					},
// 				}
// 			},
// 			password: {
// 				validators: {
// 					notEmpty : {
// 						message: 'Please insert password'
// 					},
// 				}
// 			},
// 		}
// 	})
// 	.find('[name="reason"]')
// 	// .ckeditor()
// 	// .editor
// 		.on('change', function() {
// 			// Revalidate the bio field
// 		$('#form').bootstrapValidator('revalidateField', 'reason');
// 		// console.log($('#reason').val());
// 	})
// 	;
// });

/////////////////////////////////////////////////////////////////////////////////////////
@endsection

</x-guest-layout>
