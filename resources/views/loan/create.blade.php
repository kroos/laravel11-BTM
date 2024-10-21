<x-app-layout>

	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Equipment Loan Application Form') }}
		</h2>
	</x-slot>

	<form action="{{ route('loanapps.store') }}" method="POST">
			@csrf
		<div class="container row justify-content-between">
			<!-- 1st column -->
			<div class="col-sm-6 m-0 p-1">
				<h3>Applicant</h3>
				<!-- staff id -->
				<div class="col-sm-12 mt-2 row">
					<x-input-label for="id" class="col-sm-4" :value="__('Staff ID : ')" />
					<div class="col-sm-8">
						<x-text-input id="id" name="username" value="{{ Auth::user()->username }}" class="{{ ($errors->has('username')?'is-invalid':NULL) }}" readonly />
						<x-input-error :messages="$errors->get('username')" />
					</div>
				</div>

				<!-- staff name -->
				<div class="col-sm-12 mt-2 row">
					<x-input-label for="staf" class="col-sm-4" :value="__('Staff : ')" />
					<div class="col-sm-8">
						<x-text-input id="staf" name="nostaf" value="{{ Auth::user()->name }}" class="{{ ($errors->has('nostaf')?'is-invalid':NULL) }}" readonly />
						<x-input-error :messages="$errors->get('nostaf')" />
					</div>
				</div>

				<!-- date loan -->
				<div class="col-sm-12 mt-2 row">
					<x-input-label for="dafrom" class="col-sm-4" :value="__('Date From : ')" />
					<div class="col-sm-8">
						<x-text-input id="dafrom" name="date_loan_from" value="{{ old('date_loan_from') }}" class="{{ ($errors->has('date_loan_from')?'is-invalid':NULL) }}"  />
						<x-input-error :messages="$errors->get('date_loan_from')" />
					</div>
				</div>

				<!-- date loan -->
				<div class="col-sm-12 mt-2 row">
					<x-input-label for="dato" class="col-sm-4" :value="__('Date To : ')" />
					<div class="col-sm-8">
						<x-text-input id="dato" name="date_loan_to" value="{{ old('date_loan_to') }}" class="{{ ($errors->has('date_loan_from')?'is-invalid':NULL) }}"  />
						<x-input-error :messages="$errors->get('date_loan_to')" />
					</div>
				</div>

				<!-- purpose -->
				<div class="col-sm-12 mt-2 row">
					<x-input-label for="purp" class="col-sm-4" :value="__('Purpose of Loan : ')" />
					<div class="col-sm-8">
						<x-textarea-input id="purp" name="loan_purpose" value="{{ old('loan_purpose') }}" class="{{ ($errors->has('date_loan_from')?'is-invalid':NULL) }}"  />
						<x-input-error :messages="$errors->get('loan_purpose')" />
					</div>
				</div>
			</div>

			<!-- 2nd column -->
			<div class="col-sm-6 m-0 p-1">
				<h3>Equipments</h3>

				<div class="wrap_equipments">
					<div class="col-sm-12 row mt-3">

						<!-- equipment -->
						<div class="col-sm-11 m-0 row">
							<x-input-label for="equip_1" class="col-sm-4" :value="__('Equipment : ')" />
							<div class="col-sm-8">
								<select id="equip_1" name="lequ[1][equipment_id]" class="{{ ($errors->has('lequ.*.equipment_id')?'is-invalid':NULL) }}" palceholder="Please Choose Equipment"/>
								</select>
							</div>
						</div>
						<!-- remove button -->
						<div class="col-sm-1 m-0">
							<x-danger-button type="button" class="remove_equipments">
								<i class="fa-regular fa-trash-can"></i>
							</x-danger-button>
						</div>

						<!-- equipment description -->
						<div class="col-sm-12 m-0" id="desc_1">
							<div id="desc_wrap_1">
								<p>Brand :</p>
								<p>Model :</p>
								<p>Serial Number :</p>
								<p>Description :</p>
							</div>
						</div>
					</div>

				</div>

				<div class="col-sm-12 text-right mt-3">
					<x-primary-button type="button" class="add_equipments">
						<i class="fa-solid fa-screwdriver-wrench fa-beat"></i></i>&nbsp;Add Equipments
					</x-primary-button>
				</div>
			</div>

			<!-- 2nd column -->
			<div class="col-sm-6 m-0 p-1 border border-primary">
				<h3>Department</h3>
				<div class="col-sm-12 m-0 p-1 border border-primary">
					<p>Department :
					@php
					$r = \App\Models\Staff::find(Auth::user()->nostaf);
					echo $r->belongstomanydepartment()->first()->namajabatan;
					@endphp
					</p>
					<h3>Approval From Director/Dean/Head of Department</h3>
					<p>Approver : </p>
					<p>Date : </p>
					<p class="text-sm fs-6 fw-bolder">I hereby confirm that the loaned equipment is intended for official purposes.</p>
				</div>
			</div>

			<div class="col-sm-12 text-center">
				<x-primary-button class="m-2">
					{{ __('Save') }}
				</x-primary-button>
			</div>
		</div>
	</form>


@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
// ajax category

/////////////////////////////////////////////////////////////////////////////////////////
//enable select 2
$('#equip_1').select2({
	placeholder: 'Please Choose Equipment',
	width: '100%',
	ajax: {
		url: '{{ route('equipmentstatus') }}',
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
}).on('change', function(e) {
	$('#desc_wrap_1').remove();
	var id = $("#equip_1 option:selected").val();

	var dat1 = $.ajax({
		url: "{{ route('equipmentdescription') }}",
		type: "GET",
		data : { 'id': id },
		dataType: 'json',
		global: false,
		async:false,
		success: function (response) {
			return response;
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.log(textStatus, errorThrown);
		}
	}).responseText;

	// this is how u cange from json to array type data
	var dat2 = $.parseJSON( dat1 );

		$('#desc_1').append(
						'<div id="desc_wrap_1">' +
							'<p>Brand : '+ dat2.brand +'</p>' +
							'<p>Model : '+ dat2.model +'</p>' +
							'<p>Serial Number : '+ dat2.serial_number +'</p>' +
							'<p>Description : '+ dat2.description +'</p>' +
						'</div>'
		);
});



/////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////
// datepicker
$('#dafrom').datepicker({
	dateFormat: 'yy-mm-dd',
	minDate: 3,
}).on('change', function() {
	$('#dato').datepicker('option', 'minDate', this.value);
});

$('#dato').datepicker({
	dateFormat: 'yy-mm-dd',
	minDate: 3,
}).on('change', function() {
	$('#dafrom').datepicker('option', 'maxDate', this.value);
});

/////////////////////////////////////////////////////////////////////////////////////////
// add item
var apprv_max_fields = 10;						//maximum input boxes allowed
var appr_btn = $(".add_equipments");
var apprv_wrapper = $(".wrap_equipments");

var counter = 2;
$(appr_btn).click(function(){
	// e.preventDefault();

	//max input box allowed
	if(counter < apprv_max_fields){
		counter++;
		apprv_wrapper.append(
			'<div class="col-sm-12 row mt-3">' +
				'<!-- equipment -->' +
				'<div class="col-sm-11 m-0 row">' +
					'<label class="form-label form-label-sm col-sm-4" for="equip_' + counter + '">Equipment :</label>' +
					'<div class="col-sm-8">' +
						'<select id="equip_' + counter + '" name="lequ[' + counter + '][equipment_id]" class="{{ ($errors->has('lequ.*.equipment_id')?'is-invalid':NULL) }}" palceholder="Please Choose Equipment"/>' +
						'</select>' +
					'</div>' +
				'</div>' +
				'<!-- remove button -->' +
				'<div class="col-sm-1 m-0">' +
					'<button type="button" class="btn btn-sm btn-danger remove_equipments">' +
						'<i class="fa-regular fa-trash-can"></i>' +
					'</button>' +
				'</div>' +
				'<!-- equipment description -->' +
				'<div class="col-sm-12 m-0" id="desc_' + counter + '">' +
					'<div id="desc_wrap_' + counter + '">' +
						'<p>Brand :</p>' +
						'<p>Model :</p>' +
						'<p>Serial Number :</p>' +
						'<p>Description :</p>' +
					'</div>' +
				'</div>' +
			'</div>'
		);

		$('#equip_' + counter + '').select2({
			placeholder: 'Please Choose Equipment',
			width: '100%',
			ajax: {
				url: '{{ route('equipmentstatus') }}',
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
		}).on('change', function(e) {
			$('#desc_wrap_' + counter + '').remove();
			var id = $('#equip_' + counter + ' option:selected').val();

			var dat1 = $.ajax({
				url: "{{ route('equipmentdescription') }}",
				type: "GET",
				data : { 'id': id },
				dataType: 'json',
				global: false,
				async:false,
				success: function (response) {
					return response;
				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(textStatus, errorThrown);
				}
			}).responseText;

			// this is how u cange from json to array type data
			var dat2 = $.parseJSON( dat1 );

				$('#desc_' + counter + '').append(
								'<div id="desc_wrap_' + counter + '">' +
									'<p>Brand : '+ dat2.brand +'</p>' +
									'<p>Model : '+ dat2.model +'</p>' +
									'<p>Serial Number : '+ dat2.serial_number +'</p>' +
									'<p>Description : '+ dat2.description +'</p>' +
								'</div>'
				);
		});

	}
})

$(apprv_wrapper).on("click",".remove_equipments", function(e){
	//user click on remove text
	e.preventDefault();
	var $row = $(this).parent().parent();
	$row.remove();
	counter--;
})

/////////////////////////////////////////////////////////////////////////////////////////
@endsection
</x-app-layout>
