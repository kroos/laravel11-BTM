<x-guest-layout>
	<form method="POST" action="{{ route('login') }}" id="form" class="" >
		@csrf

		<!-- Username -->
		<div class="form-group row mb-3">
			<x-input-label for="username" :value="__('Username : ')" />
			<x-text-input id="username" name="username" :value="old('username')" class="{{ $errors->has('username') ? 'is-invalid' : NULL }}"/>
			<x-input-error :messages="$errors->get('username')" />
		</div>

		<!-- Password -->
		<div class="form-group row mb-3">
			<x-input-label for="password" :value="__('Password : ')" />
			<x-text-input type="password" id="password" name="password" :value="old('password')" autocomplete="current-password" class="{{ $errors->has('password') ? 'is-invalid' : NULL }}" />
			<x-input-error :messages="$errors->get('password')" />
		</div>

		<!-- Remember Me -->
		<div class="form-check mb-3">
			<label for="remember_me" class="form-check-label">
				<input type="checkbox" name="remember" id="remember_me" class="form-check-input rounded" >
				<span class="text-sm">Remember me</span>
			</label>
			<x-primary-button class="ml-3">
				{{ __('Log in') }}
			</x-primary-button>
		</div>
	</form>

@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
// validator
// $(document).ready(function() {
// 	$('#form').bootstrapValidator({
// 		feedbackIcons: {
// 			valid: 'fas fa-light fa-check',
// 			invalid: 'fas fa-sharp fa-light fa-xmark',
// 			validating: 'fas fa-duotone fa-spinner-third'
// 		},
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
