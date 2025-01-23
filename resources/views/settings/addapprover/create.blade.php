<x-app-layout>

	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Add Approver') }}
		</h2>
	</x-slot>

	<div class="colontainer d-flex justify-content-center">
		<form action="{{ route('addapprover.store') }}" method="POST">
			@csrf

			<div class="col-sm-12 text-right mt-3">
				<x-primary-button type="button" class="add_approver">
					<i class="fa-solid fa-user-plus"></i>&nbsp;Add Approver
				</x-primary-button>
			</div>

			<div class="wrap_approver">
				<div class="col-sm-12 row mt-3">
					<!-- Staff -->
					<div class="col-sm-5 m-0 row">
						<x-input-label for="staf_1" class="col-sm-4" :value="__('Staff : ')" />
						<div class="col-sm-8">
							<x-select-input id="staf_1" name="approver[1][nostaf]" class="{{ ($errors->has('approver.*.nostaf')?'is-invalid':NULL) }}" >
							</x-select-input>
						</div>
					</div>
					<!-- department -->
					<div class="col-sm-5 m-0 row">
						<x-input-label for="dep_1" class="col-sm-4" :value="__('Department : ')" />
						<div class="col-sm-8">
							<x-select-input id="dep_1" name="approver[1][kod_jabatan]" class="{{ ($errors->has('approver.*.kod_jabatan')?'is-invalid':NULL) }}" >
							</x-select-input>
						</div>
					</div>
					<!-- opt -->
					<div class="col-sm-2 m-0 ">
						<x-danger-button type="button" class="remove_approver">
							<i class="fa-regular fa-trash-can"></i>
						</x-danger-button>
					</div>
				</div>

			</div>

			<x-primary-button type="submit" class="m-3">
				{{ __('Save') }}
			</x-primary-button>
		</form>
	</div>


@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
//enable select 2 for backup
$('#staf_1').select2({
	placeholder: 'Please Choose Staff',
	width: '100%',
	ajax: {
		url: '{{ route('liststaff') }}',
		// data: { '_token': '{!! csrf_token() !!}' },
		// theme: 'bootstrap5',
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

$('#dep_1').select2({
	placeholder: 'Please Choose Department',
	width: '100%',
	ajax: {
		url: '{{ route('listjabatan') }}',
		// data: { '_token': '{!! csrf_token() !!}' },
		// theme: 'bootstrap5',
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

/////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////
// add item
var apprv_max_fields = 10;						//maximum input boxes allowed
var appr_btn = $(".add_approver");
var apprv_wrapper = $(".wrap_approver");

var counter = 2;
$(appr_btn).click(function(){
	// e.preventDefault();

	//max input box allowed
	if(counter < apprv_max_fields){
		counter++;
		apprv_wrapper.append(
				'<div class="col-sm-12 row mt-3">' +
					'<div class="col-sm-5 m-0 row">' +
						'<label class="form-label form-label-sm col-sm-4" for="staf_' + counter + '">Staff : </label>' +
						'<div class="col-sm-8">' +
							'<select id="staf_' + counter + '" name="approver[' + counter + '][nostaf]" class="{{ ($errors->has('approver.*.nostaf')?'is-invalid':NULL) }}" >' +
							'</select>' +
							'@error('approver.*.nostaf')' +
								'<div class="invalid-feedback text-sm" id="staf_' + counter + '">{{ $message }}</div>' +
							'@enderror' +
						'</div>' +
					'</div>' +
					'<div class="col-sm-5 m-0 row">' +
						'<label class="form-label form-label-sm col-sm-4" for="dep_' + counter + '">Department : </label>' +
						'<div class="col-sm-8">' +
							'<select id="dep_' + counter + '" name="approver[' + counter + '][kod_jabatan]" class="{{ ($errors->has('approver.*.kod_jabatan')?'is-invalid':NULL) }}" >' +
							'</select>' +
							'@error('approver.*.kod_jabatan')' +
								'<div class="invalid-feedback text-sm" id="dep_' + counter + '">{{ $message }}</div>' +
							'@enderror' +
						'</div>' +
					'</div>' +
					'<div class="col-sm-2 m-0 ">' +
						'<button type="button" class="btn btn-sm btn-danger remove_approver">' +
							'<i class="fa-regular fa-trash-can"></i>' +
						'</button>' +
					'</div>' +
				'</div>'
		);

		// $('.form-check').find('[name="jobdesc[' + counter + '][sales_get_item_id][]"]').css('border', '3px solid red');

		$('#staf_' + counter ).select2({
			placeholder: 'Please Choose Staff',
			width: '100%',
			allowClear: true,
			closeOnSelect: true,
			ajax: {
				url: '{{ route('liststaff') }}',
				type: 'GET',
				dataType: 'json',
				data: function (params) {
					var query = {
						_token: '{!! csrf_token() !!}',
						search: params.term,
					}
					return query;
				}
			},
		});
		$('#dep_' + counter ).select2({
			placeholder: 'Please Choose Department',
			width: '100%',
			allowClear: true,
			closeOnSelect: true,
			ajax: {
				url: '{{ route('listjabatan') }}',
				type: 'GET',
				dataType: 'json',
				data: function (params) {
					var query = {
						_token: '{!! csrf_token() !!}',
						search: params.term,
					}
					return query;
				}
			},
		});

	}
})

$(apprv_wrapper).on("click",".remove_approver", function(e){
	//user click on remove text
	e.preventDefault();
	var $row = $(this).parent().parent();
	$row.remove();
	counter--;
})

/////////////////////////////////////////////////////////////////////////////////////////
@endsection
</x-app-layout>
