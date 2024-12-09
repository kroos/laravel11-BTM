<x-app-layout>

	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Email Registration Account Form') }}
		</h2>
	</x-slot>

	<form action="{{ route('emailaccapp.store') }}" method="POST">
		@csrf
		<x-text-input type="hidden" id="id" name="nostaf" value="{{ Auth::user()->nostaf }}" readonly />
		<div class="container row justify-content-between">
			<!-- 1st column -->
			<div class="col-sm-6 m-0 p-1">
				<h3>Proposed Email ID</h3>
				<small>Please do not use nickname or number in your email ID</small>

				<div class="col-sm-12 text-right mt-3">
					<x-primary-button type="button" class="add_emails">
						<i class="fa-solid fa-screwdriver-wrench fa-beat"></i></i>&nbsp;Add Emails
					</x-primary-button>
				</div>

				<div class="wrap_emails">
					<div class="col-sm-12 row mt-3">

						<div class="col-sm-11 m-0 row">

							<x-input-label for="email_0" class="col-sm-3" :value="__('Email ID : ')" />
							<div class="col-sm-9">
								<div class="input-group">
									<input id="email_0" type="text" name="emreg[0][email_suggestion]" class="form-control form-control-sm {{ ($errors->has('emreg.*.email_suggestion')?'is-invalid':NULL) }}" placeholder="Email ID" aria-label="Email ID" aria-describedby="emailID_0">
									<span class="input-group-text" id="emailID_0">@unishams.edu.my</span>
								</div>
							</div>
						</div>

						<!-- remove button -->
						<div class="col-sm-1 m-0">
							<x-danger-button type="button" class="remove_emails">
								<i class="fa-regular fa-trash-can"></i>
							</x-danger-button>
						</div>

					</div>
				</div>
			</div>

			<!-- 2nd column -->
			<div class="col-sm-6 m-0 p-1">
				<h3>Group Email</h3>
				<small>Turn on the switch if you are applying for group email, then fill up inputs below.</small>
				<div class="form-check form-switch">
					<input name="group_email" value="1" class="form-check-input" type="checkbox" role="switch" id="gemail">
					<label class="form-check-label" for="gemail">Group Email</label>
				</div>

				<div class="col-sm-12 m-0 p-1" id="wrap_group_email">
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
		</div>


@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
// group email
$(`#gemail`).change(function(){
	if(this.checked) {
		// console.log($(this).val());
		$(`#wrap_group_email`).append(
				`<small>Please choose personnels associate with the suggested email.</small>` +

				`<div class="col-sm-12 text-right mt-3">` +
					`<button class="btn btn-primary btn-sm add_personnels" type="button">` +
						`<i class="fa-solid fa-screwdriver-wrench fa-beat"></i></i>&nbsp;Add Personnels` +
					`</button>` +
				`</div>` +

				`<div class="wrap_personnels">` +
					`<div class="col-sm-12 row mt-3">` +

						`<div class="col-sm-11 m-0 mt-2 row">` +
							`<label for="dept_0" class="col-sm-4">Department : </label>` +
							`<div class="col-sm-8">` +
									`<select name="emregmem[0][email_member_department]" id="dept_0" class="form-select form-select-sm {{ $errors->has('emregmem.*.email_member_department')?'is-invalid':NULL }}" placeholder="Department">` +
										`<option value="">Please choose department</option>` +
									`</select>` +
							`</div>` +
						`</div>` +

						`<div class="col-sm-11 m-0 mt-1 row">` +
							`<label for="staff_0" class="col-sm-4">Staff Email : </label>` +
							`<div class="col-sm-8">` +
									`<select name="emregmem[0][email_member]" id="staff_0" class="form-select form-select-sm {{ ($errors->has('emregmem.*.email_member')?'is-invalid':NULL) }}" placeholder="Staff Email">` +
										`<option value="">Please choose staff</option>` +
									`</select>` +
							`</div>` +
							`<small>if the person you are looking for is not in the list, that person maybe :`+
								`<ul>`+
									`<li>been deactivated</li>`+
									`<li>his/her email was not set in the system</li>`+
								`</ul>`+
							`</small>` +
						`</div>` +

						`<div class="col-sm-1 m-0">` +
							`<button class="btn btn-danger remove_personnels" type="button">` +
								`<i class="fa-regular fa-trash-can"></i>` +
							`</button>` +
						`</div>` +

					`</div>` +
				`</div>`
		);
		// create personnels email
		createPersonnels();
		// initialized select2
		initializeChainedSelectsForPersonnels(0);
	} else {
		// console.log($(this).val());
		$(`#wrap_group_email`).children().remove();
	}
});

/////////////////////////////////////////////////////////////////////////////////////////
// create personnels
function createPersonnels(){
	// Maximum input boxes allowed
	var personnels_max_fields = 20;

	// Buttons and wrapper
	var personnels_btn = $(".add_personnels");
	var personnels_wrapper = $(".wrap_personnels");

	// Counter to track added dropdowns
	var personnels_counter = 0;

	// Add equipment fields dynamically
	$(personnels_btn).click(function () {
		console.log('button click');
		if (personnels_counter < personnels_max_fields) {
			personnels_counter++;
			personnels_wrapper.append(createPersonnelRow(personnels_counter));
			initializeChainedSelectsForPersonnels(personnels_counter);
		}
	});

	// Remove equipment fields dynamically
	$(personnels_wrapper).on("click", ".remove_personnels", function (e) {
		e.preventDefault();
		$(this).closest('.row').remove();
		personnels_counter--;
	});

};

function createPersonnelRow(index) {
	return `
		<div class="col-sm-12 row mt-3">
			<div class="col-sm-11 m-0 mt-2 row">
				<label for="dept_${index}" class="col-sm-4">Department : </label>
				<div class="col-sm-8">
					<select name="emregmem[${index}][email_member_department]" id="dept_${index}" class="form-select form-select-sm">
						<option value="">Please choose department</option>
					</select>
				</div>
			</div>
			<div class="col-sm-11 m-0 mt-1 row">
				<label for="staff_${index}" class="col-sm-4">Staff : </label>
				<div class="col-sm-8">
					<select name="emregmem[${index}][email_member]" id="staff_${index}" class="form-select form-select-sm">
						<option value="">Please choose staff</option>
					</select>
				</div>
				<small>if the person you are looking for is not in the list, that person maybe :
					<ul>
						<li>been deactivated</li>
						<li>his/her email was not set in the system</li>
					</ul>
				</small>
			</div>
			<div class="col-sm-1 m-0">
				<button class="btn btn-danger remove_personnels" type="button">
					<i class="fa-regular fa-trash-can"></i>
				</button>
			</div>
		</div>`;
}

// Function to initialize Select2 and chain dropdowns with description update
function initializeChainedSelectsForPersonnels(personnels_counter) {
	const departmentSelector = `#dept_${personnels_counter}`;
	const personnelsSelector = `#staff_${personnels_counter}`;

	// Initialize Select2 for department dropdown
	$(departmentSelector).select2({
		placeholder: "Please choose department",
		width: '100%',
		allowClear: true,
		closeOnSelect: true,
		ajax: {
			url: '{{ route('listjabatan') }}',
			dataType: 'json',
			data: function (params) {
				var query = {
					_token: '{!! csrf_token() !!}',
					search: params.term,
				}
				return query;
			},
		}
	});

	// Initialize Select2 for equipment dropdown
	$(personnelsSelector).select2({
		placeholder: "Please choose staff",
		width: '100%',
		allowClear: true,
		closeOnSelect: true,
	});

	// Chain the category dropdown to the equipment dropdown
	$(departmentSelector).on('change', function () {
		const selectedDepartmentId = $(this).val();

		// Clear and reload the equipment dropdown
		$(personnelsSelector).empty().trigger('change').append('<option value="">Please choose staff</option>'); // Clear existing options

		if (selectedDepartmentId) {
			$.ajax({
				url: '{{ route('listemailjabatan') }}',
				dataType: 'json',
				data: {dept_id: selectedDepartmentId},
				success: function (data) {
					let options = ''; // Initialize an empty string to hold the options HTML

					// Loop through the data and generate <option> elements
					data.forEach(function (item) {
							// Extract the first key and value from the object
							const [name, email] = Object.entries(item)[0];
							options += `<option value="${email}">${name}</option>`;
					});

					console.log(options);

					// Append the options to the select element
					$(personnelsSelector).append(options);

					$(personnelsSelector).select2({
						placeholder: 'Please choose staff',
						width: '100%',
						allowClear: true,
						closeOnSelect: true,
					});
				},
				error: function (xhr, status, error) {
						console.error('AJAX Error:', status, error);
				}
			});
		}
	});
}




/////////////////////////////////////////////////////////////////////////////////////////
// add email

// Maximum input boxes allowed
var apprv_max_fields = 10;

// Buttons and wrapper
var appr_btn = $(".add_emails");
var apprv_wrapper = $(".wrap_emails");

// Counter to track added dropdowns
var counter = 0;

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
}

// Add equipment fields dynamically
$(appr_btn).click(function () {
	if (counter < apprv_max_fields) {
		counter++;
		apprv_wrapper.append(
			`<div class="col-sm-12 row mt-3">` +
				`<div class="col-sm-11 m-0 row">` +
					`<x-input-label for="email_${counter}" class="col-sm-3" :value="__('Email ID : ')" />` +
					`<div class="col-sm-9">` +
						`<div class="input-group">` +
							`<input id="email_${counter}" type="text" name="emreg[${counter}][email_suggestion]" class="form-control form-control-sm {{ ($errors->has('emreg.*.email_suggestion')?'is-invalid':NULL) }}" placeholder="Email ID" aria-label="Email ID" aria-describedby="emailID_${counter}">` +
							`<span class="input-group-text" id="emailID_${counter}">@unishams.edu.my</span>` +
						`</div>` +
					`</div>` +
				`</div>` +
				`<div class="col-sm-1 m-0">` +
					`<x-danger-button type="button" class="remove_emails">` +
						`<i class="fa-regular fa-trash-can"></i>` +
					`</x-danger-button>` +
				`</div>` +
			`</div>`
		);

	}
});

// Remove equipment fields dynamically
$(apprv_wrapper).on("click", ".remove_emails", function (e) {
	e.preventDefault();
	$(this).closest('.row').remove();
	counter--;
});

/////////////////////////////////////////////////////////////////////////////////////////
@endsection
	</form>
</x-app-layout>
