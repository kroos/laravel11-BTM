<x-app-layout>

	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Equipment Loan Application Form') }}
		</h2>
	</x-slot>

	<form action="{{ route('btmloanapplications.update', $loanapp->id) }}" method="POST">
			@csrf
			@method('PATCH')
		<div class="container row justify-content-between">
			<!-- 1st column -->
			<div class="col-sm-6 m-0 p-1">
				<h3>Applicant</h3>
				<!-- staff id -->
				<div class="col-sm-12 mt-2 row">
					<x-input-label for="id" class="col-sm-4" :value="__('Staff ID : ')" />
					<div class="col-sm-8">
						<x-text-input id="id" name="nostaf" value="{{ $loanapp->nostaf }}" class="{{ ($errors->has('nostaf')?'is-invalid':NULL) }}" readonly />
						<x-input-error :messages="$errors->get('nostaf')" />
					</div>
				</div>

				<!-- staff name -->
				<div class="col-sm-12 mt-2 row">
					<x-input-label for="staf" class="col-sm-4" :value="__('Staff : ')" />
					<div class="col-sm-8">
						<x-text-input id="staf" name="nama" value="{{ $loanapp->belongstostaff->nama }}" class="{{ ($errors->has('nama')?'is-invalid':NULL) }}" readonly />
						<x-input-error :messages="$errors->get('nama')" />
					</div>
				</div>

				<!-- date loan -->
				<div class="col-sm-12 mt-2 row">
					<x-input-label for="dafrom" class="col-sm-4" :value="__('Date From : ')" />
					<div class="col-sm-8">
						<x-text-input id="dafrom" name="date_loan_from" value="{{ \Carbon\Carbon::parse($loanapp->date_loan_from)->format('Y-m-d') }}" class="{{ ($errors->has('date_loan_from')?'is-invalid':NULL) }}"  />
						<x-input-error :messages="$errors->get('date_loan_from')" />
					</div>
				</div>

				<!-- date loan -->
				<div class="col-sm-12 mt-2 row">
					<x-input-label for="dato" class="col-sm-4" :value="__('Date To : ')" />
					<div class="col-sm-8">
						<x-text-input id="dato" name="date_loan_to" value="{{ \Carbon\Carbon::parse($loanapp->date_loan_to)->format('Y-m-d') }}" class="{{ ($errors->has('date_loan_from')?'is-invalid':NULL) }}"  />
						<x-input-error :messages="$errors->get('date_loan_to')" />
					</div>
				</div>

				<!-- purpose -->
				<div class="col-sm-12 mt-2 row">
					<x-input-label for="purp" class="col-sm-4" :value="__('Purpose of Loan : ')" />
					<div class="col-sm-8">
						<textarea name="loan_purpose" class="form-control form-control-sm {{ ($errors->has('date_loan_from')?'is-invalid':NULL) }}" id="purp">{{ $loanapp->loan_purpose }}</textarea>
						<x-input-error :messages="$errors->get('loan_purpose')" />
					</div>
				</div>
			</div>

			<!-- 2nd column -->
			<div class="col-sm-6 m-0 p-1">
				<h3>Equipments</h3>

				@if($loanapp->count())
				<?php
					$i = 0;
				?>
					@foreach($loanapp->hasmanyequipments()->get() as $k)
					<div class="col-sm-12 row mt-3">
						<!-- equipment -->
						<div class="col-sm-11 m-0 row">
							<x-input-label for="catequip_{{ $i }}" class="col-sm-4" :value="__('Equipment Category : ')" />
							<div class="col-sm-8">
								<select id="catequip_{{ $i }}" name="lequ[{{ $i }}][catequipment_id]" class="form-select form-select-sm {{ ($errors->has('lequ.*.catequipment_id')?'is-invalid':NULL) }}" placeholder="Please Choose Category"/>
									<!-- must have this to make sure $request catch the data -->
									<option value="">Please choose category</option>
								</select>
							</div>
						</div>

						<div class="col-sm-11 m-0 row">
							<input type="hidden" name="lequ[{{ $i }}][id]" value="{{ $k->id }}">
							<x-input-label for="equip_{{ $i }}" class="col-sm-4" :value="__('Equipment : ')" />
							<div class="col-sm-8">
								<select id="equip_{{ $i }}" name="lequ[{{ $i }}][equipment_id]" class="form-select form-select-sm {{ ($errors->has('lequ.*.equipment_id')?'is-invalid':NULL) }}" palceholder="Please Choose Equipment"/>
									<!-- must have this to make sure $request catch the data -->
									<option value="">Please Choose Equipment</option>
								</select>
							</div>
						</div>
						<!-- remove button -->
						<div class="col-sm-1 m-0">
							<x-danger-button type="button" class="delete_equipments" data-id="{{ $k->id }}">
								<i class="fa-regular fa-trash-can"></i>
							</x-danger-button>
						</div>

						<!-- equipment description -->
						<div class="col-sm-12 m-0" id="desc_{{ $i }}">
							<div id="desc_wrap_{{ $i }}">
								<p>Brand : {{ $k->belongstoequipment->brand }}</br>
									Model : {{ $k->belongstoequipment->model }}</br>
									Serial Number : {{ $k->belongstoequipment->serial_number }}</br>
									Description : {{ $k->belongstoequipment->description }}</p>
							</div>
						</div>
						<div class="col-sm-12 m-0">
							<div class="col-sm-12 mt-2 row">
								<x-input-label for="take_{{ $i }}" class="col-sm-4" :value="__('Taken On : ')" />
								<div class="col-sm-8">
									<x-text-input id="take_{{ $i }}" name="lequ[{{ $i }}][taken_on]" value="{{ ($k->taken_on)?\Carbon\Carbon::parse($k->taken_on)->format('Y-m-d'):NULL }}" class="{{ ($errors->has('lequ.*.taken_on')?'is-invalid':NULL) }}"  />
									<x-input-error :messages="$errors->get('taken_on')" />
								</div>
							</div>
							<div class="col-sm-12 mt-2 row">
								<x-input-label for="return_{{ $i }}" class="col-sm-4" :value="__('Return On : ')" />
								<div class="col-sm-8">
									<x-text-input id="return_{{ $i }}" name="lequ[{{ $i }}][return_on]" value="{{ ($k->return_on)?\Carbon\Carbon::parse($k->return_on)->format('Y-m-d'):NULL }}" class="{{ ($errors->has('lequ.*.return_on')?'is-invalid':NULL) }}"  />
									<x-input-error :messages="$errors->get('return_on')" />
								</div>
							</div>
							<div class="col-sm-12 mt-2 row">
								<x-input-label for="status_{{ $i }}" class="col-sm-4" :value="__('Equipment Status After Return : ')" />
								<div class="col-sm-8">
									<x-select-input id="status_{{ $i }}" name="lequ[{{ $i }}][status_item_id]" class="{{ ($errors->has('lequ.*.status_item_id')?'is-invalid':NULL) }}" />
									<x-input-error :messages="$errors->get('status_item_id')" />
								</div>
							</div>
							<div class="col-sm-12 mt-2 row">
								<x-input-label for="remarks_{{ $i }}" class="col-sm-4" :value="__('Equipment Remarks : ')" />
								<div class="col-sm-8">
									<x-textarea-input id="remarks_{{ $i }}" name="lequ[{{ $i }}][status_condition_remarks]" value="{{ ($k->status_condition_remarks) }}" class="{{ ($errors->has('lequ.*.status_condition_remarks')?'is-invalid':NULL) }}" >
										{{ $k->status_condition_remarks }}
									</x-textarea-input>
									<x-input-error :messages="$errors->get('status_condition_remarks')" />
								</div>
							</div>
						</div>
					</div>
					<?php
						$i++;
					?>
					@endforeach
				@endif

				<div class="wrap_equipments">
				</div>

				<div class="col-sm-12 text-right mt-3">
					<x-primary-button type="button" class="add_equipments">
						<i class="fa-solid fa-screwdriver-wrench fa-beat"></i></i>&nbsp;Add Equipments
					</x-primary-button>
				</div>
			</div>

			<!-- 3rd column -->
			<div class="col-sm-12 m-0 p-1">
				<h3>Department</h3>
				<div class="col-sm-12 m-0 p-1">
					<p>Department :
					@php
					$r = \App\Models\Staff::find($loanapp->nostaf);
					echo $r->belongstomanydepartment()->first()->namajabatan;
					$idj = $r->belongstomanydepartment()->first()->kodjabatan;
					@endphp
					</p>
					<h3>Approval From Director/Dean/Head of Department</h3>
					<p>Approver :
					@php
					$j = \App\Models\Jabatan::find($idj);
					if($j->belongstomanyappr->count()){
						echo $j->belongstomanyappr->first()->nama;
					} else {
						echo '<span class="text-danger fw-bold">Sila hubungi pihak BTM</span>';
					}
					@endphp
					</p>
					<p>Date : {{ (!is_null($loanapp->approver_date))?\Carbon\Carbon::parse($loanapp->approver_date)->format('D, j F Y'):NULL }}</p>
					<p class="text-sm fs-6 fw-bolder">I hereby confirm that the loaned equipment is intended for official purposes.</p>
				</div>
			</div>

			<!-- 4th column -->
			<div class="col-sm-12 m-0 p-1">
				<h3>BTM Used</h3>
				<!-- <legend class="m-4">Loan Equipment Approval</legend> -->
				<div class="btn-group" role="group" aria-label="Loan Equipment Approval">
					<?php
						$p = 0;
					?>
					@foreach(\App\Models\StatusLoan::whereIn('id', [1,2])->get() as $v)
						<input type="radio" class="btn-check {{ ($errors->has('status_loan_id')?'is-invalid':NULL) }}" name="status_loan_id" id="status_loan{{ $p }}" value="{{ $v->id }}" {{ ($loanapp->status_loan_id == $v->id)?'checked="checked"':NULL }} autocomplete="off">
						<label class="btn btn-sm btn-outline-primary" for="status_loan{{ $p }}">{{ $v->status_loan }}</label>
						<?php
							$p++;
						?>
					@endforeach
					<x-input-error :messages="$errors->get('status_loan_id')" />
				</div>

				<div class="col-sm-12 mt-2 row">
					<x-input-label for="rem" class="col-sm-4" :value="__('BTM Remarks : ')" />
					<div class="col-sm-8">
						<textarea name="btm_remarks" class="form-control form-control-sm {{ ($errors->has('btm_remarks')?'is-invalid':NULL) }}" id="rem">{{ $loanapp->btm_remarks }}</textarea>
						<x-input-error :messages="$errors->get('btm_remarks')" />
					</div>
				</div>

			</div>

			<div class="col-sm-12 m-0 p-1 text-center">
				<x-primary-button type="submit" class="m-2">
					<i class="fa-solid fa-floppy-disk fa-beat"></i>&nbsp;{{ __('Update') }}
				</x-primary-button>
			</div>
		</div>


@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
// ajax category
// URLs for API
const CATEGORY_API = "{{ route('listcategory') }}";
const EQUIPMENT_API = "{{ route('equipmentstatus') }}";
const DESCRIPTION_API = "{{ route('equipmentdescription') }}";

/////////////////////////////////////////////////////////////////////////////////////////
//enable select 2
@if($loanapp->hasmanyequipments()->count())
	<?php
		$i = 0;
	?>
	@foreach($loanapp->hasmanyequipments()->get() as $t)

		initializeChainedSelects({{ $i }});
		var newOption{{ $i }} = new Option('{{ $t->belongstoequipment->belongstocategory->category }}', {{ $t->belongstoequipment->category_id }}, true, true);
		$('#catequip_{{ $i }}').append(newOption{{ $i }}).trigger('change');
		var newOption{{ $i }}{{ $i }} = new Option('{{ $t->belongstoequipment->item }}', {{ $t->equipment_id }}, true, true);
		$('#equip_{{ $i }}').append(newOption{{ $i }}{{ $i }}).trigger('change');


		$('#take_{{ $i }}').datepicker({
			dateFormat: 'yy-mm-dd',
			//disable friday and saturday
			beforeShowDay: function(d) {
				return [!(d.getDay()==5||d.getDay()==6)]
			},
		});

		$('#return_{{ $i }}').datepicker({
			dateFormat: 'yy-mm-dd',
			//disable friday and saturday
			beforeShowDay: function(d) {
				return [!(d.getDay()==5||d.getDay()==6)]
			},
		});

		$('#status_{{ $i }}').select2({
			placeholder: 'Please Choose',
			width: '100%',
			ajax: {
				url: '{{ route('status') }}',
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
		var newOption2 = new Option('{{ $t->belongstoequipmentstatus->status_item }}', {{ $t->status_item_id }}, true, true);
		$('#status_{{ $i }}').append(newOption2).trigger('change');

		<?php
		$i++;
		?>
	@endforeach
@endif

/////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////
// datepicker
$('#dafrom').datepicker({
	dateFormat: 'yy-mm-dd',
	// minDate: 3,
	//disable friday and saturday
	beforeShowDay: function(d) {
		return [!(d.getDay()==5||d.getDay()==6)]
	},
}).on('change', function() {
	$('#dato').datepicker('option', 'minDate', this.value);
});

$('#dato').datepicker({
	dateFormat: 'yy-mm-dd',
	// minDate: 3,
	//disable friday and saturday
	beforeShowDay: function(d) {
		return [!(d.getDay()==5 || d.getDay()==6)]
	}
}).on('change', function() {
	$('#dafrom').datepicker('option', 'maxDate', this.value);
});

/////////////////////////////////////////////////////////////////////////////////////////
// add item
// Maximum input boxes allowed
var apprv_max_fields = 10;

// Buttons and wrapper
var appr_btn = $(".add_equipments");
var apprv_wrapper = $(".wrap_equipments");

// Counter to track added dropdowns
var counter = {{ ($loanapp->hasmanyequipments()->count())?($loanapp->hasmanyequipments()->count() - 1):0 }};
// var counter = 0;

// Function to update the description dynamically
function updateDescription(equipSelector, descSelector) {
	$(equipSelector).on('change', function () {
		const selectedEquipmentId = $(this).val();
		const descriptionWrapper = $(descSelector);

		// Clear the description initially
		descriptionWrapper.html('<p>Loading description...</p>');

		if (selectedEquipmentId) {
			$.ajax({
				url: `${DESCRIPTION_API}`,
				dataType: 'json',
				data : { 'id': selectedEquipmentId },
				success: function (data) {
					// Update the description content
					descriptionWrapper.html(`
						<p>Brand: ${data.brand || 'N/A'}<br/>
						Model: ${data.model || 'N/A'}<br/>
						Serial Number: ${data.serial_number || 'N/A'}<br/>
						Description: ${data.description || 'N/A'}</p>
					`);
				},
				error: function () {
					descriptionWrapper.html('<p>Error loading description. Please try again.</p>');
				}
			});
		} else {
			// If no equipment is selected, clear the description
			descriptionWrapper.html(`
				<p>Brand: <br/>
				Model: <br/>
				Serial Number: <br/>
				Description: </p>
			`);
		}
	});
}

// Function to initialize Select2 and chain dropdowns with description update
function initializeChainedSelects(counter) {
	const categorySelector = `#catequip_${counter}`;
	const equipmentSelector = `#equip_${counter}`;
	const descriptionSelector = `#desc_wrap_${counter}`;

	// Initialize Select2 for category dropdown
	$(categorySelector).select2({
		placeholder: "Please choose category",
		width: '100%',
		allowClear: true,
		closeOnSelect: true,
		ajax: {
			url: CATEGORY_API,
			dataType: 'json',
			processResults: function (data) {
				return {
					results: data.map(cat => ({
						id: cat.id,
						text: cat.cat
					}))
				};
			}
		}
	});

	// Initialize Select2 for equipment dropdown
	$(equipmentSelector).select2({
		placeholder: "Please choose equipment",
		width: '100%',
		allowClear: true,
		closeOnSelect: true,
	});

	// Chain the category dropdown to the equipment dropdown
	$(categorySelector).on('change', function () {
		const selectedCategoryId = $(this).val();

		// Clear and reload the equipment dropdown
		$(equipmentSelector).empty().trigger('change'); // Clear existing options

		if (selectedCategoryId) {
			$.ajax({
				url: EQUIPMENT_API,
				dataType: 'json',
				success: function (data) {
					const equipmentOptions = data.results[0].children
						.filter(item => item.class == selectedCategoryId)
						.map(item => ({
							id: item.id,
							text: item.text
						}));

					$(equipmentSelector).select2({
						placeholder: 'Please choose equipments',
						width: '100%',
						allowClear: true,
						closeOnSelect: true,
						data: equipmentOptions
					});
				}
			});
		}
	});

	$('#take_' + counter + '').datepicker({
		dateFormat: 'yy-mm-dd',
		//disable friday and saturday
		beforeShowDay: function(d) {
			return [!(d.getDay()==5||d.getDay()==6)]
		},
	});

	$('#return_' + counter + '').datepicker({
		dateFormat: 'yy-mm-dd',
		//disable friday and saturday
		beforeShowDay: function(d) {
			return [!(d.getDay()==5||d.getDay()==6)]
		},
	});

	$('#status_' + counter + '').select2({
		placeholder: 'Please Choose',
		width: '100%',
		allowClear: true,
		closeOnSelect: true,
		ajax: {
			url: '{{ route('status') }}',
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
	});

	// Update the description when equipment is changed
	updateDescription(equipmentSelector, descriptionSelector);
}

$(appr_btn).click(function(){
	// e.preventDefault();

	//max input box allowed
	if(counter < apprv_max_fields){
		counter++;
		apprv_wrapper.append(
			'<div class="col-sm-12 row mt-3">' +
				'<!-- equipment -->' +
				'<div class="col-sm-11 m-0 row">' +
					'<label for="catequip_' + counter + '" class="form-label form-label-sm col-sm-4">Equipment Category : </label>' +
					'<div class="col-sm-8">' +
						'<select id="catequip_' + counter + '" name="lequ[' + counter + '][catequipment_id]" class="form-select form-select-sm "></select>' +
					'</div>' +
				'</div>' +
				'<div class="col-sm-11 m-0 row">' +
					'<input type="hidden" name="lequ[' + counter + '][id]" value="">' +
					'<label class="form-label form-label-sm col-sm-4" for="equip_' + counter + '">Equipment :</label>' +
					'<div class="col-sm-8">' +
						'<select id="equip_' + counter + '" name="lequ[' + counter + '][equipment_id]" class="form-select form-select-sm {{ ($errors->has('lequ.*.equipment_id')?'is-invalid':NULL) }}" palceholder="Please Choose Equipment"/>' +
							'<option value="">Please Choose Equipment</option>' +
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
						'<p>Brand :</br>' +
						'Model :</br>' +
						'Serial Number :</br>' +
						'Description :</p>' +
					'</div>' +
				'</div>' +
			'</div>' +
			'<div class="col-sm-12 m-0">' +
				'<div class="col-sm-12 mt-2 row">' +
					'<label for="take_' + counter + '" class="col-sm-4">Taken On : </label>' +
					'<div class="col-sm-8">' +
						'<input type="text" id="take_' + counter + '" name="lequ[' + counter + '][taken_on]" value="" class="form-control form-control-sm {{ ($errors->has('lequ.*.taken_on')?'is-invalid':NULL) }}"  />' +
					'</div>' +
				'</div>' +
				'<div class="col-sm-12 mt-2 row">' +
					'<label for="return_' + counter + '" class="col-sm-4">Return On : </label>' +
					'<div class="col-sm-8">' +
						'<input type="type" id="return_' + counter + '" name="lequ[' + counter + '][return_on]" value="" class="form-control form-control-sm {{ ($errors->has('lequ.*.return_on')?'is-invalid':NULL) }}"/>' +
					'</div>' +
				'</div>' +
				'<div class="col-sm-12 mt-2 row">' +
					'<label for="status_' + counter + '" class="col-sm-4">Status Item After Return : </label>' +
					'<div class="col-sm-8">' +
						'<select name="lequ[' + counter + '][status_condition_remarks]" id="status_' + counter + '" class="form-select form-select-sm {{ ($errors->has('lequ.*.status_condition_remarks')?'is-invalid':NULL) }}">' +
							'<option value="">Please Choose</option>' +
						'</select>' +
					'</div>' +
				'</div>' +
				'<div class="col-sm-12 mt-2 row">' +
					'<label for="remarks_' + counter + '" class="col-sm-4">Remarks : </label>' +
					'<div class="col-sm-8">' +
						'<textarea id="remarks_' + counter + '" name="lequ[' + counter + '][status_condition_remarks]" value="" class="form-control form-control-sm {{ ($errors->has('lequ.*.status_condition_remarks')?'is-invalid':NULL) }}"></textarea>' +
					'</div>' +
				'</div>' +
			'</div>'
		);

		// Initialize the chained selects and description updater for the new set
		initializeChainedSelects(counter);
	}
})

// Remove equipment fields dynamically
$(apprv_wrapper).on("click", ".remove_equipments", function (e) {
	e.preventDefault();
	$(this).closest('.row').remove();
	counter--;
});

// Initialize Select2 and description updater for the first set
initializeChainedSelects(counter);

/////////////////////////////////////////////////////////////////////////////////////////
$(document).on('click', '.delete_equipments', function(e){
	var ackID = $(this).data('id');
	SwalDeleteR(ackID);
	e.preventDefault();
});

function SwalDeleteR(ackID){
	swal.fire({
		title: 'Delete Loan Equipment',
		text: 'Are you sure to delete Loan Equipment?',
		icon: 'info',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		cancelButtonText: 'Cancel',
		confirmButtonText: 'Yes',
		showLoaderOnConfirm: true,

		preConfirm: function() {
			return new Promise(function(resolve) {
				$.ajax({
					url: '{{ url('loanequipments') }}' + '/' + ackID,
					type: 'DELETE',
					dataType: 'json',
					data: {
							id: ackID,
							_token : $('meta[name=csrf-token]').attr('content')
					},
				})
				.done(function(response){
					swal.fire('Accept', response.message, response.status)
					.then(function(){
						window.location.reload(true);
					});
					// $('#cancel_btn_' + ackID).parent().parent().remove();
				})
				.fail(function(){
					swal.fire('Oops...', 'Something went wrong with ajax !', 'error');
					// swal.fire('Unauthorised', 'Error 401 : Unauthorised Action!', 'error');
				})
			});
		},
		allowOutsideClick: false
	})
	.then((result) => {
		if (result.dismiss === swal.DismissReason.cancel) {
			swal.fire('Cancel Action', 'Loan Equipment is still active.', 'info')
		}
	});
}
//auto refresh right after clicking OK button
$(document).on('click', '.swal2-confirm', function(e){
	window.location.reload(true);
});

/////////////////////////////////////////////////////////////////////////////////////////
@endsection
	</form>
</x-app-layout>
