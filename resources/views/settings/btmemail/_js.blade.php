/////////////////////////////////////////////////////////////////////////////////////////
function createPersonnelRow(index, name) {
	return `
		<div class="col-sm-12 row mt-3 groupmember" id="groupmember_${index}">
			<div class="col-sm-11 m-0 mt-2 row @error('emregmem.*.department_id') has-error @enderror">
				<label for="dept_${index}" class="col-sm-4">Department : </label>
				<div class="col-sm-8">
					<input type="hidden" name="${name}[${index}][id]" value="">
					<select name="${name}[${index}][department_id]" id="dept_${index}" class="form-select form-select-sm @error('emregmem.*.department_id') is-invalid @enderror"></select>
					@error('emregmem.*.department_id')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
					@enderror
				</div>
			</div>
			<div class="col-sm-11 m-0 mt-1 row @error('emregmem.*.email_staff') has-error @enderror">
				<label for="staff_${index}" class="col-sm-4">Staff : </label>
				<div class="col-sm-8">
					<select name="${name}[${index}][email_staff]" id="staff_${index}" class="form-select form-select-sm @error('emregmem.*.email_staff') is-invalid @enderror"></select>
					@error('emregmem.*.email_staff')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
					@enderror

				</div>
				<small>if the person you are looking for is not in the list, that person maybe :
					<ul>
						<li>been deactivated</li>
						<li>his/her email was not set in the system</li>
					</ul>
				</small>
			</div>
			<div class="col-sm-1 m-0">
				<button class="btn btn-danger btn-sm remove_personnels personnel_remove" type="button" data-id="${index}">
					<i class="fa-regular fa-trash-can"></i>
				</button>
			</div>
		</div>`;
};

/////////////////////////////////////////////////////////////////////////////////////////
// create personnels
function createPersonnels(){

	$("#personnels_wrap").addRemRow({
		addBtn: "#personnels_add",
		maxFields: 20,
		removeClass: "personnel_remove",
		fieldName: "emregmem",
		rowSelector: "groupmember",
		rowTemplate: (i, name) => createPersonnelRow(i, name),
		onAdd: (i, event, $r , name) => {
			// console.log('Personnel added', i, $r)
			initializeChainedSelectsForPersonnels(i);
		},
		onRemove: async (i, event, $row, name) => {

			const idv = $row.find(`input[name="${name}[${i}][id]"]`).val();
			if (!idv) {
				return true;
			}

			let url = `{{ url('emailgroupmember') }}`;
			let dbId = idv;

			const result = await swal.fire({
				title: 'Are you sure?',
				text: "It will be deleted permanently!",
				type: 'warning',
				showCancelButton: true,
				allowOutsideClick: false,
				showLoaderOnConfirm: true,
				confirmButtonText: 'Yes, delete it!',
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
			});

			// ❌ Cancel clicked
			if (result.isDismissed) {
				await swal.fire('Cancelled', 'Your data is safe from delete', 'info' );
				return false;
			}
			// 2️⃣ Perform AJAX delete
			try {
				const response = await $.ajax({
					type: 'DELETE',
					url: `${url}/${dbId}`,
					data: {
						_token: `{{ csrf_token() }}`,
						id: dbId
					},
					dataType: 'json'
				});
				await swal.fire('Deleted!', response.message, response.status);
			} catch (e) {
				await swal.fire( 'Ajax Error', 'Something went wrong with ajax!', 'error' );
				return false; // ❌ BLOCK removal
			}


		}
	});
};

/////////////////////////////////////////////////////////////////////////////////////////
// group email
// $('#gemail').change(function(){
 $(document).on('change', '#gemail', function(e){
	if(this.checked) {
		$(`#wrap_group_email`).append(
				`<small>Please choose personnels associate with the suggested email.</small>` +
				`<div class="col-sm-12 text-right mt-3">` +
					`<button id="personnels_add" class="btn btn-primary btn-sm add_personnels" type="button">` +
						`<i class="fa-solid fa-screwdriver-wrench fa-beat"></i></i>&nbsp;Add Personnels` +
					`</button>` +
				`</div>` +

				`<div class="wrap_personnels" id="personnels_wrap">` +
				`</div>`
		);
		createPersonnels();
		restorePersonnelRow();
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
// Add equipment fields dynamically
function createEmailRow(i, name){
	return `
		<div class="col-sm-12 row mt-3 email_staff" id="email_staff_${i}">
			<input type="hidden" name="${name}[${i}][id]" value="">
			<div class="col-sm-11 m-0 row @error('emreg.*.email_suggestion') has-error @enderror">
				<x-input-label for="email_${i}" class="col-sm-3" :value="__('Email ID : ')" />
				<div class="col-sm-9 my-auto">
					<div class="input-group input-group-sm">
						<input id="email_${i}" type="text" name="${name}[${i}][email_suggestion]" class="form-control form-control-sm @error('emreg.*.email_suggestion') is-invalid @enderror" placeholder="Email ID" aria-label="Email ID" aria-describedby="emailID_${i}">
						<span class="input-group-text" id="emailID_${i}">@unishams.edu.my</span>
						@error('emreg.*.email_suggestion')
							<div class="invalid-feedback">
								{{ $message }}
							</div>
						@enderror
					</div>
				</div>
			</div>
			<div class="col-sm-1 m-0 my-auto">
				<x-danger-button type="button" class="btn btn-sm remove_email" data-index="${i}">
					<i class="fa-regular fa-trash-can"></i>
				</x-danger-button>
			</div>
			<div class="col-sm-12 row mt-3">
				<div class="col-sm-9 m-0 row @error('emreg.*.temp_password') has-error @enderror">
					<x-input-label for="tpass_${i}" class="col-sm-4 my-auto" :value="__('Temp Pass : ')" />
					<div class="col-sm-8 my-auto">
						<div class="input-group">
							<input id="tpass_${i}" type="text" name="${name}[${i}][temp_password]" class="form-control form-control-sm @error('emreg.*.temp_password') is-invalid @enderror" placeholder="Temporary Password" value="">
						</div>
					</div>
				</div>
				<div class="col-sm-3 m-0 row @error('emreg.*.approved_email') has-error @enderror">
					<div class="form-check form-switch my-auto">
						<label class="form-check-label" for="aemail_${i}">
							<input type="hidden" name="${name}[${i}][approved_email]" value="0">
							<input type="checkbox" name="${name}[${i}][approved_email]" value="1" class="form-check-input  @error('emreg.*.approved_email') is-invalid @enderror" role="switch" id="aemail_${i}" >
						Approved Email</label>
					</div>
				</div>
			</div>
		</div>
	`;
};

$("#emails_wrap").addRemRow({
	addBtn: "#emails_add",
	maxFields: 20,
	removeClass: "remove_email",
	fieldName: "emreg",
	rowSelector: "email_staff",
	rowTemplate: (i, name) => createEmailRow(i, name),
	onAdd: (i, event, $r , name) => {
		// console.log('Email added', i, $r)
		initializeChainedSelectsForPersonnels(i);
	},
	onRemove: async (i, event, $row, name) => {

		const idv = $row.find(`[name="${name}[${i}][id]"]`).val();
		console.log(idv, i, event, $row, name);
		if (!idv) {
			return true;
		}

		let url = `{{ url('emailsuggestion') }}`;
		let dbId = idv;

		const result = await swal.fire({
			title: 'Are you sure?',
			text: "It will be deleted permanently!",
			type: 'warning',
			showCancelButton: true,
			allowOutsideClick: false,
			showLoaderOnConfirm: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, delete it!'
		});

		// ❌ Cancel clicked
		if (result.isDismissed) {
			await swal.fire('Cancelled', 'Your data is safe from delete', 'info' );
			return false;
		}
		// 2️⃣ Perform AJAX delete
		try {
			const response = await $.ajax({
				type: 'DELETE',
				url: `${url}/${dbId}`,
				data: {
					_token: `{{ csrf_token() }}`,
					id: dbId
				},
				dataType: 'json'
			});
			await swal.fire('Deleted!', response.message, response.status);
		} catch (e) {
			await swal.fire( 'Ajax Error', 'Something went wrong with ajax!', 'error' );
			return false; // ❌ BLOCK removal
		}


	}
});

/////////////////////////////////////////////////////////////////////////////////////////
// restore old email data
<?php
$items = @$btmemailapplication?->hasmanyemailsuggestion()?->get()
										->toArray() ?? [];

$oldItemsValue = old('emreg', $items);
// dd($oldItemsValue);
?>
const oldICMSGroup = @json($oldItemsValue);
if (oldICMSGroup.length > 0) {
	oldICMSGroup.forEach(function (loaneq, i) {
		$("#emails_add").trigger('click');
		const $row = $("#emails_wrap").children().eq(i);

		$row.find(`[name="emreg[${i}][id]"]`).val(loaneq.id || '');
		$row.find(`[name="emreg[${i}][email_application_id]"]`).val(loaneq.email_application_id || '');
		$row.find(`[name="emreg[${i}][email_suggestion]"]`).val(loaneq.email_suggestion || '');
		$row.find(`[name="emreg[${i}][temp_password]"]`).val(loaneq.temp_password || '');
		$row.find(`#aemail_${i}`).prop('checked', loaneq.approved_email == 1);
	});
}

/////////////////////////////////////////////////////////////////////////////////////////
// restore old personnel data
function restorePersonnelRow(){
	<?php
	$items = @$btmemailapplication?->hasmanyemailgroupmember()?->get()
											->toArray() ?? [];

	$oldItemsValue = old('emregmem', $items);
	// dd($oldItemsValue);
	?>
	const oldICMSGroup = @json($oldItemsValue);
	if (oldICMSGroup.length > 0) {
		oldICMSGroup.forEach(function (loaneq, i) {
			$("#personnels_add").trigger('click');
			const $row = $("#personnels_wrap").children().eq(i);

	console.log(loaneq.department_id, loaneq.email_staff);

			const $department_id = $row.find(`[name="emregmem[${i}][department_id]"]`);
			if (loaneq.department_id) {
				$.ajax({
					url: `{{ route('listjabatan') }}`,
					data: {
						_token: '{!! csrf_token() !!}',
						kodjabatan: loaneq.department_id,
					},
					dataType: 'json'
				}).then(data => {
					const itema = Array.isArray(data) ? data[0] : data;	// change object to array
					if (!itema) return;
					// console.log(itema, itema.results[0].children[0].id, itema.results[0].children[0].text);
					const option1 = new Option(itema.results[0].children[0].text, itema.results[0].children[0].id, true, true);
					$department_id.append(option1).trigger('change');
				});
			}

			const $email_staff = $row.find(`[name="emregmem[${i}][email_staff]"]`);
			if (loaneq.email_staff) {
				$.ajax({
					url: `{{ route('listemailjabatan') }}`,
					data: {
						_token: '{!! csrf_token() !!}',
						dept_id: loaneq.department_id,
						email: loaneq.email_staff,
					},
					dataType: 'json'
				}).then(data => {
					const itema = Array.isArray(data) ? data[0] : data;	// change object to array
					if (!itema) return;
					console.log(itema);
					const [name, email] = Object.entries(itema)[0];
					const option2 = new Option(name, email, true, true);
					$email_staff.append(option2).trigger('change');
				});
			}
			$row.find(`[name="emregmem[${i}][id]"]`).val(loaneq.id || '');
		});
	}

};

/////////////////////////////////////////////////////////////////////////////////////////
// restore old data for personnel
 @if( old('group_email', $btmemailapplication?->group_email) )
	$(document).ready(function () {
	    $('#gemail').prop('checked', true).trigger('change');
	});
 @endif
/////////////////////////////////////////////////////////////////////////////////////////
