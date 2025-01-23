<x-app-layout>

	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Equipment Loan Application Form') }}
		</h2>
	</x-slot>

	<form action="{{ route('loanapp.store') }}" method="POST">
			@csrf
		<div class="container d-flex justify-content-between">
			<!-- 1st column -->
			<div class="col-sm-5 m-0 p-1">
				<h3>Applicant</h3>
				<!-- staff id -->
				<div class="col-sm-12 mt-2 row">
					<x-input-label for="id" class="col-sm-4" :value="__('Staff ID : ')" />
					<div class="col-sm-8">
						<x-text-input id="id" name="nostaf" value="{{ Auth::user()->nostaf }}" class="{{ ($errors->has('nostaf')?'is-invalid':NULL) }}" readonly />
						<x-input-error :messages="$errors->get('nostaf')" />
					</div>
				</div>

				<!-- staff name -->
				<div class="col-sm-12 mt-2 row">
					<x-input-label for="staf" class="col-sm-4" :value="__('Staff : ')" />
					<div class="col-sm-8">
						<x-text-input id="staf" name="nama" value="{{ Auth::user()->name }}" class="{{ ($errors->has('nama')?'is-invalid':NULL) }}" readonly />
						<x-input-error :messages="$errors->get('nama')" />
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
			<div class="col-sm-5 m-0 p-1">
				<h3>Equipments</h3>

				<div class="wrap_equipments">
					<div class="col-sm-12 row mt-3">

						<!-- chainedselect2 -->
						<div class="col-sm-11 m-0 row">
							<x-input-label for="catequip_0" class="col-sm-4" :value="__('Equipment Category : ')" />
							<div class="col-sm-8">
								<select id="catequip_0" name="lequ[0][catequipment_id]" class="{{ ($errors->has('lequ.*.catequipment_id')?'is-invalid':NULL) }}" palceholder="Please Choose Category"/>
									<!-- must have this to make sure $request catch the data -->
									<option value="">Please choose category</option>
								</select>
							</div>
						</div>


						<!-- equipment -->
						<div class="col-sm-11 m-0 row">
							<x-input-label for="equip_0" class="col-sm-4" :value="__('Equipment : ')" />
							<div class="col-sm-8">
								<select id="equip_0" name="lequ[0][equipment_id]" class="{{ ($errors->has('lequ.*.equipment_id')?'is-invalid':NULL) }}" palceholder="Please Choose Equipment"/>
									<!-- must have this to make sure $request catch the data -->
									<option value="">Please choose equipment</option>
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
						<div class="col-sm-12 m-0" id="desc_0">
							<div id="desc_wrap_0">
								<p>Brand :<br/>
								Model :<br/>
								Serial Number :<br/>
								Description :</p>
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

		</div>
		<!-- 3rd column -->
		<div class="col-sm-12 m-0 p-1">
			<h3>Department</h3>
			<div class="col-sm-12 m-0 p-1">
				<p>Department :
				@php
				$r = \App\Models\Staff::find(Auth::user()->nostaf);
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
				<p>Date : </p>
				<p class="text-sm fs-6 fw-bolder">I hereby confirm that the loaned equipment is intended for official purposes.</p>
			</div>
		</div>

		<div class="col-sm-12 text-center">
			<x-primary-button type="submit" class="m-2">
				<i class="fa-solid fa-floppy-disk fa-beat"></i>&nbsp;{{ __('Save') }}
			</x-primary-button>
		</div>


@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////
//enable select 2
//		$('#catequip_0').select2({
//			placeholder: 'Please choose category',
//			width: '100%',
//			ajax: {
//				url: '{{ route('listcategory') }}',
//				// data: { '_token': '{!! csrf_token() !!}' },
//				// theme: 'bootstrap5',
//				type: 'GET',
//				dataType: 'json',
//				data: function (params) {
//					var query = {
//						_token: '{!! csrf_token() !!}',
//						search: params.term,
//						// type: 'public'
//					}
//					return query;
//				},
//				processResults: function (data) {
//					// Transforms the top-level key of the response object from 'items' to 'results'
//					return {
//						results: [
//							{
//								children: data.map(function (item) {
//									return {
//										id: item.id,
//										text: item.cat,
//									};
//								}),
//							},
//						],
//					};
//				}
//			},
//			allowClear: true,
//			closeOnSelect: true,
//		});

// 					$("#catequip_0").select2({
// 						placeholder: "Please choose category",
// 						width: '100%',
// 						allowClear: true,
// 						closeOnSelect: true,
// 					}).on('change', function(e) {
// 						$('#desc_wrap_0').remove();
// 						$('#desc_0').append(
// 										'<div id="desc_wrap_0">' +
// 											'<p>Brand : <br/>' +
// 											'Model : <br/>' +
// 											'Serial Number : <br/>' +
// 											'Description : </p>' +
// 										'</div>'
// 						);
// 					});
//
// 					$("#equip_0").select2({
// 						placeholder: "Please choose equipment",
// 						width: '100%',
// 						allowClear: true,
// 						closeOnSelect: true,
// 					}).on('change', function(e) {
// 						$('#desc_wrap_0').remove();
// 						var id = $("#equip_0 option:selected").val();
//
// 						var dat1 = $.ajax({
// 							url: "{{ route('equipmentdescription') }}",
// 							type: "GET",
// 							data : { 'id': id },
// 							dataType: 'json',
// 							global: false,
// 							async:false,
// 							success: function (response) {
// 								$('#desc_0').append(
// 												'<div id="desc_wrap_0">' +
// 													'<p>Brand : '+ response.brand +'<br/>' +
// 													'Model : '+ response.model +'<br/>' +
// 													'Serial Number : '+ response.serial_number +'<br/>' +
// 													'Description : '+ response.description +'</p>' +
// 												'</div>'
// 								);
// 							},
// 							error: function(jqXHR, textStatus, errorThrown) {
// 								console.log(textStatus, errorThrown);
// 							}
// 						});
// 					});
//
//
// 					// Fetch and populate parent dropdown
// 					fetchParentOptions();
// 					function fetchParentOptions() {
// 						$.ajax({
// 							url: "{{ route('listcategory') }}", // Replace with your API
// 							method: "GET",
// 							success: function (response) {
// 								// Clear existing options
// 								$("#catequip_0").empty().append('<option value="">Please choose category</option>');
//
// 								// Populate options
// 								response.forEach(function (category) {
// 										$("#catequip_0").append(
// 												`<option value="${category.id}">${category.cat}</option>`
// 										);
// 								});
//
// 								// Refresh Select2
// 								$("#catequip_0").select2({
// 									placeholder: "Please choose category",
// 									width: '100%',
// 									allowClear: true,
// 									closeOnSelect: true,
// 								});
// 							},
// 							error: function () {
// 								alert("Failed to load categories.");
// 							},
// 						});
// 					}
//
// 					$("#catequip_0").change(function () {
// 						const parentId = $(this).val(); // Get selected value
// 						if (parentId) {
// 							$.ajax({
// 								url: "{{ route('equipmentstatus') }}", // Replace with your API
// 								method: "GET",
// 								data: { categoryId: parentId }, // Pass parent value to API
// 								success: function (response) {
// 									console.log(response.results);
//
// 									// Clear existing options
// 									$("#equip_0").empty().append('<option value="">Please choose category</option>');
//
// 									// Check if response.results exists and has children
// 									if (response.results && response.results[0].children) {
// 										response.results[0].children.forEach(function (child) {
// 											// Access id, text, and class here
// 											const { id, text, class: classValue } = child;
//
// 											// Append options
// 											$("#equip_0").append(
// 												`<option value="${id}" data-class="${classValue}">${text}</option>`
// 											);
// 										});
// 									}
// 									// Refresh Select2
// 									$("#equip_0").select2({
// 										placeholder: "Please choose equipment",
// 										width: '100%',
// 										allowClear: true,
// 										closeOnSelect: true,
// 									});
// 								},
// 								error: function () {
// 									alert("Failed to load subcategories.");
// 								},
// 							});
// 						} else {
// 							// Reset child dropdown if no parent selected
// 							$("#equip_0").empty().append('<option value="">Please choose equipment</option>').select2();
// 						}
// 					});

/////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////
// datepicker
$('#dafrom').datepicker({
	dateFormat: 'yy-mm-dd',
	minDate: 3,
	//disable friday and saturday
	beforeShowDay: function(d) {
		return [!(d.getDay()==5||d.getDay()==6)]
	},
}).on('change', function() {
	$('#dato').datepicker('option', 'minDate', this.value);
});

$('#dato').datepicker({
	dateFormat: 'yy-mm-dd',
	minDate: 3,
	//disable friday and saturday
	beforeShowDay: function(d) {
		return [!(d.getDay()==5 || d.getDay()==6)]
	}
}).on('change', function() {
	$('#dafrom').datepicker('option', 'maxDate', this.value);
});

/////////////////////////////////////////////////////////////////////////////////////////
// add item
// URLs for API
const CATEGORY_API = "{{ route('listcategory') }}";
const EQUIPMENT_API = "{{ route('equipmentstatus') }}";
const DESCRIPTION_API = "{{ route('equipmentdescription') }}";

// Maximum input boxes allowed
var apprv_max_fields = 10;

// Buttons and wrapper
var appr_btn = $(".add_equipments");
var apprv_wrapper = $(".wrap_equipments");

// Counter to track added dropdowns
var counter = 0;

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
		$(equipmentSelector).empty().trigger('change').append('<option value="">Please choose category</option>'); // Clear existing options

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

	// Update the description when equipment is changed
	updateDescription(equipmentSelector, descriptionSelector);
}

// Add equipment fields dynamically
$(appr_btn).click(function () {
	if (counter < apprv_max_fields) {
		counter++;
		apprv_wrapper.append(
			'<div class="col-sm-12 row mt-3">' +
				'<div class="col-sm-11 m-0 row">' +
					'<label for="catequip_' + counter + '" class="form-label form-label-sm col-sm-4">Equipment Category : </label>' +
					'<div class="col-sm-8">' +
						'<select id="catequip_' + counter + '" name="lequ[' + counter + '][catequipment_id]" class="form-control"></select>' +
					'</div>' +
				'</div>' +
				'<div class="col-sm-11 m-0 row">' +
					'<label class="form-label form-label-sm col-sm-4" for="equip_' + counter + '">Equipment :</label>' +
					'<div class="col-sm-8">' +
						'<select id="equip_' + counter + '" name="lequ[' + counter + '][equipment_id]" class="form-control"></select>' +
					'</div>' +
				'</div>' +
				'<div class="col-sm-1 m-0">' +
					'<button type="button" class="btn btn-sm btn-danger remove_equipments">' +
						'<i class="fa-regular fa-trash-can"></i>' +
					'</button>' +
				'</div>' +
				'<div class="col-sm-12 m-0" id="desc_' + counter + '">' +
					'<div id="desc_wrap_' + counter + '">' +
						'<p>Brand :<br/>' +
						'Model :<br/>' +
						'Serial Number :<br/>' +
						'Description :</p>' +
					'</div>' +
				'</div>' +
			'</div>'
		);

		// Initialize the chained selects and description updater for the new set
		initializeChainedSelects(counter);
	}
});

// Remove equipment fields dynamically
$(apprv_wrapper).on("click", ".remove_equipments", function (e) {
	e.preventDefault();
	$(this).closest('.row').remove();
	counter--;
});

// Initialize Select2 and description updater for the first set
initializeChainedSelects(counter);

/////////////////////////////////////////////////////////////////////////////////////////
@endsection
	</form>
</x-app-layout>
