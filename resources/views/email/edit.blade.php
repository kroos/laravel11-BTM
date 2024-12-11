<x-app-layout>

	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Email Registration Account Form') }}
		</h2>
	</x-slot>

	<form action="{{ route('emailaccapp.update', $emailaccapp->id) }}" method="POST">
		@method('PATCH')
		@csrf
		<x-text-input type="hidden" id="id" name="nostaf" value="{{ $emailaccapp->nostaf }}" readonly />
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
					@if($emailaccapp->hasmanyemailsuggestion()->count())
						<?php $i = 0; ?>
						@foreach($emailaccapp->hasmanyemailsuggestion()->get() as $emailsugg)
							<div class="col-sm-12 row mt-3">
								<div class="col-sm-11 m-0 row">
									<x-input-label for="email_{{ $i }}" class="col-sm-3" :value="__('Email ID : ')" />
									<div class="col-sm-9">
										<div class="input-group">
											<input type="hidden" name="emreg[{{ $i }}][id]" value="{{ $emailsugg->id }}">
											<input id="email_{{ $i }}" type="text" name="emreg[{{ $i }}][email_suggestion]" class="form-control form-control-sm {{ ($errors->has('emreg.*.email_suggestion')?'is-invalid':NULL) }}" placeholder="Email ID" aria-label="Email ID" aria-describedby="emailID_{{ $i }}" value="{{ $emailsugg->email_suggestion }}">
											<span class="input-group-text" id="emailID_{{ $i }}">@unishams.edu.my</span>
										</div>
									</div>
								</div>

								<!-- remove button -->
								<div class="col-sm-1 m-0">
									<x-danger-button type="button" class="delete_emails" data-id="{{ $emailsugg->id }}">
										<i class="fa-regular fa-trash-can"></i>
									</x-danger-button>
								</div>
							</div>
							<?php $i++; ?>
						@endforeach
					@endif
				</div>
			</div>

			<!-- 2nd column -->
			<div class="col-sm-6 m-0 p-1">
				<h3>Group Email</h3>
				<small>Turn on the switch if you are applying for group email, then fill up inputs below.</small>
				<div class="form-check form-switch">
					<input name="group_email" value="1" class="form-check-input" type="checkbox" role="switch" id="gemail" {{ ($emailaccapp->group_email)?'checked':NULL }}>
					<label class="form-check-label" for="gemail">Group Email</label>
				</div>

				<div class="col-sm-12 m-0 p-1" id="wrap_group_email">
					@if($emailaccapp->hasmanyemailgroupmember()->count())
						<?php $o = 0; ?>
						<small>Please choose personnels associate with the suggested email.</small>

						<div class="col-sm-12 text-right mt-3">
							<button class="btn btn-primary btn-sm add_personnels" type="button">
								<i class="fa-solid fa-screwdriver-wrench fa-beat"></i></i>&nbsp;Add Personnels
							</button>
						</div>

						<div class="wrap_personnels">
						@foreach($emailaccapp->hasmanyemailgroupmember()->get() as $emailmem)
							<div class="col-sm-12 row mt-3">
								<div class="col-sm-11 m-0 mt-2 row">
									<label for="dept_{{ $o }}" class="col-sm-4">Department : </label>
									<div class="col-sm-8">
										<input type="hidden" name="emregmem[{{ $o }}][id]" value="{{ $emailmem->id }}">
										<select name="emregmem[{{ $o }}][email_member_department]" id="dept_{{ $o }}" class="form-select form-select-sm {{ $errors->has('emregmem.*.email_member_department')?'is-invalid':NULL }}" placeholder="Department">
											<option value="">Please choose department</option>
										</select>
									</div>
								</div>
								<div class="col-sm-11 m-0 mt-1 row">
									<label for="staff_{{ $o }}" class="col-sm-4">Staff Email : </label>
									<div class="col-sm-8">
										<select name="emregmem[{{ $o }}][email_member]" id="staff_{{ $o }}" class="form-select form-select-sm {{ ($errors->has('emregmem.*.email_member')?'is-invalid':NULL) }}" placeholder="Staff Email">
											<option value="">Please choose staff</option>
										</select>
									</div>
									<small>if the person you are looking for is not in the list, that person maybe
										<ul>
											<li>been deactivated</li>
											<li>his/her email was not set in the system</li>
										</ul>
									</small>
								</div>
								<div class="col-sm-1 m-0">
									<button class="btn btn-danger btn-sm delete_personnels" type="button" data-id="{{ $emailmem->id }}">
										<i class="fa-regular fa-trash-can"></i>
									</button>
								</div>
							</div>
							<?php $o++; ?>
						@endforeach
						</div>
					@endif
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
					<i class="fa-solid fa-floppy-disk fa-beat"></i>&nbsp;{{ __('Update') }}
				</x-primary-button>
			</div>
		</div>


@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
function createPersonnelRow(index) {
	return `
		<div class="col-sm-12 row mt-3">
			<div class="col-sm-11 m-0 mt-2 row">
				<label for="dept_${index}" class="col-sm-4">Department : </label>
				<div class="col-sm-8">
					<input type="hidden" name="emregmem[${index}][id]" value="">
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
				<button class="btn btn-danger btn-sm remove_personnels" type="button">
					<i class="fa-regular fa-trash-can"></i>
				</button>
			</div>
		</div>`;
};

/////////////////////////////////////////////////////////////////////////////////////////
// create personnels
function createPersonnels(){
	// Maximum input boxes allowed
	var personnels_max_fields = 20;

	// Buttons and wrapper
	var personnels_btn = $(".add_personnels");
	var personnels_wrapper = $(".wrap_personnels");

	// Counter to track added dropdowns
	var personnels_counter = {{ ($emailaccapp->hasmanyemailgroupmember()->count())?($emailaccapp->hasmanyemailgroupmember()->count() - 1):0 }};

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

/////////////////////////////////////////////////////////////////////////////////////////
@if($emailaccapp->hasmanyemailgroupmember()->count())
	createPersonnels();
	<?php $ke = 0; ?>
	@foreach($emailaccapp->hasmanyemailgroupmember()->get() as $emailmem2)
		initializeChainedSelectsForPersonnels({{ $ke }});

		var newOption{{ $ke }} = new Option('{{ $emailmem2->belongstoemailpersondept->namajabatan }}', '{{ $emailmem2->department_id }}', true, true);
		$('#dept_{{ $ke }}').append(newOption{{ $ke }}).trigger('change');
		var newOption{{ $ke }}{{ $ke }} = new Option('{{ \App\Models\Login::where('email', $emailmem2->email_staff)->first()->name }}', '{{ $emailmem2->email_staff }}', true, true);
		$('#staff_{{ $ke }}').append(newOption{{ $ke }}{{ $ke }}).trigger('change');
		<?php $ke++; ?>
	@endforeach
@endif
/////////////////////////////////////////////////////////////////////////////////////////
// group email
$(`#gemail`).change(function(){
	if(this.checked) {
		$(`#wrap_group_email`).append(
				`<small>Please choose personnels associate with the suggested email.</small>` +
				`<div class="col-sm-12 text-right mt-3">` +
					`<button class="btn btn-primary btn-sm add_personnels" type="button">` +
						`<i class="fa-solid fa-screwdriver-wrench fa-beat"></i></i>&nbsp;Add Personnels` +
					`</button>` +
				`</div>` +

				`<div class="wrap_personnels">` +
				@if($emailaccapp->hasmanyemailgroupmember()->count())
					<?php $k = 0; ?>
					@foreach($emailaccapp->hasmanyemailgroupmember()->get() as $emailmem1)
						`<div class="col-sm-12 row mt-3">
							<div class="col-sm-11 m-0 mt-2 row">
								<label for="dept_{{ $k }}" class="col-sm-4">Department : </label>
								<div class="col-sm-8">
									<input type="hidden" name="emregmem[{{ $k }}][id]" value="{{ $emailmem1->id }}">
									<select name="emregmem[{{ $k }}][email_member_department]" id="dept_{{ $k }}" class="form-select form-select-sm">
										<option value="">Please choose department</option>
									</select>
								</div>
							</div>
							<div class="col-sm-11 m-0 mt-1 row">
								<label for="staff_{{ $k }}" class="col-sm-4">Staff : </label>
								<div class="col-sm-8">
									<select name="emregmem[{{ $k }}][email_member]" id="staff_{{ $k }}" class="form-select form-select-sm">
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
								<button class="btn btn-danger btn-sm delete_personnels" type="button" data-id="{{ $emailmem1->id }}">
									<i class="fa-regular fa-trash-can"></i>
								</button>
							</div>
						</div>` +
						<?php $k++; ?>
					@endforeach
				@else
					createPersonnelRow(0) +
				@endif
				`</div>`
		);

		@if($emailaccapp->hasmanyemailgroupmember()->count())
			createPersonnels();
			<?php $kr = 0; ?>
			@foreach($emailaccapp->hasmanyemailgroupmember()->get() as $emailmem2)
				initializeChainedSelectsForPersonnels({{ $kr }});
				var newOption{{ $kr }} = new Option('{{ $emailmem2->belongstoemailpersondept->namajabatan }}', '{{ $emailmem2->department_id }}', true, true);
				$('#dept_{{ $kr }}').append(newOption{{ $kr }}).trigger('change');
				var newOption{{ $kr }}{{ $kr }} = new Option('{{ \App\Models\Login::where('email', $emailmem2->email_staff)->first()->name }}', '{{ $emailmem2->email_staff }}', true, true);
				$('#staff_{{ $kr }}').append(newOption{{ $kr }}{{ $kr }}).trigger('change');
				<?php $kr++; ?>
			@endforeach
		@else
			createPersonnels();
			initializeChainedSelectsForPersonnels(0);
		@endif

	} else {
		$(`#wrap_group_email`).children().remove();
	}
});

/////////////////////////////////////////////////////////////////////////////////////////
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

					// console.log(options);

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
};

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
							`<input type="hidden" name="emreg[${counter}][id]" value="">` +
							`<input id="email_${counter}" type="text" name="emreg[${counter}][email_suggestion]" class="form-control form-control-sm {{ ($errors->has('emreg.*.email_suggestion')?'is-invalid':NULL) }}" placeholder="Email ID" aria-label="Email ID" aria-describedby="emailID_${counter}">` +
							`<span class="input-group-text" id="emailID_${counter}">@unishams.edu.my</span>` +
						`</div>` +
					`</div>` +
				`</div>` +
				`<div class="col-sm-1 m-0">` +
					`<x-danger-button type="button" class="btn btn-sm remove_emails">` +
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
// delete emails suggestions
$(document).on('click', '.delete_emails', function(e){
	var ackID = $(this).data('id');
	SwalDeleteR(ackID);
	e.preventDefault();
});

function SwalDeleteR(ackID){
	swal.fire({
		title: 'Delete Email Suggestion',
		text: 'Are you sure to delete Email Suggestion?',
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
					url: '{{ url('emailsuggestion') }}' + '/' + ackID,
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
			swal.fire('Cancel Action', 'Email Suggestion is still active.', 'info')
		}
	});
}
//auto refresh right after clicking OK button
$(document).on('click', '.swal2-confirm', function(e){
	window.location.reload(true);
});

/////////////////////////////////////////////////////////////////////////////////////////
// delete group member emails
$(document).on('click', '.delete_personnels', function(e){
	var ackID = $(this).data('id');
	DeletePersonnels(ackID);
	e.preventDefault();
});

function DeletePersonnels(ackID){
	swal.fire({
		title: 'Delete Group Member Email',
		text: 'Are you sure to delete Group Member Email?',
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
					url: '{{ url('emailgroupmember') }}' + '/' + ackID,
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
			swal.fire('Cancel Action', 'Group Member Email is still active.', 'info')
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
