<x-app-layout>

	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Add Approver') }}
		</h2>
	</x-slot>

	<div class="col-sm-12 row align-items-center">
		<form wire:submit.prevent="store">
			@csrf
			<!-- Staff -->
			<div class="col-sm-8 row m-2 border border-info rounded">
				<x-input-label for="staf" class="col-sm-2" :value="__('Staff : ')" />
				<div class="col-sm-4">
					<x-select-input id="staf" name="nostaf" class="{{ ($errors->has('nostaf')?'is-invalid':NULL) }}" >
					</x-select-input>
					<x-input-error id="staff" :messages="$errors->get('nostaf')" />
				</div>
			</div>







			<x-primary-button class="m-3">
				{{ __('Add Approver') }}
			</x-primary-button>
		</form>
	</div>


@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
//enable select 2 for backup
$('#staf').select2({
	placeholder: 'Please Choose Staff',
	width: '100%',
	ajax: {
		url: '{{ url('api/liststaff') }}',
		// data: { '_token': '{!! csrf_token() !!}' },
		theme: 'bootstrap5',
		type: 'GET',
		dataType: 'json',
		data: function (params) {
			var query = {
				_token: '{!! csrf_token() !!}',
				search: params.term,
				type: 'public'
			}
			return query;
		}
	},
	allowClear: true,
	closeOnSelect: true,
});

@endsection
</x-app-layout>
