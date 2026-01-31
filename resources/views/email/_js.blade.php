/////////////////////////////////////////////////////////////////////////////////////////
// group email
$(document).ready(function() {
	toggleGroupEmail(); // run once on load
});

$('input[name="group_email"]').on('change', function(){
	toggleGroupEmail(); // run on change
});

function toggleGroupEmail() {
	const isChecked = $('input[name="group_email"]').prop('checked');
	if (isChecked) {
		$(`#group_email_wrap`).append(`
				<small> Sila masukkan senarai emel ahli kumpulan anda.</small>
				<small> Sekiranya ahli yang ingin ditambah tiada dalam pilihan senarai, mungkin :</small>
				<small>
					<ul>
						<li>Alamat emel telah dibekukan, atau;</li>
						<li>Alamat emel tiada di dalam sistem, atau;</li>
						<li>Alamat emel belum didaftarkan.</li>
					</ul>
				</small>
				<div class="col-sm-12 text-right mt-3">
					<button id="personnels_add" class="btn btn-primary btn-sm" type="button">
						<i class="fa-solid fa-screwdriver-wrench fa-beat"></i></i>&nbsp;Tambah Ahli
					</button>
				</div>
				<div id="personnels_wrap">
				</div>
		`);
		createPersonnels();
		initializeChainedSelectsForPersonnels(0);
		oldgroupemail();
	} else {
		$(`#group_email_wrap`).children().remove();
	}
}

/////////////////////////////////////////////////////////////////////////////////////////
// create personnels
function createPersonnels(){

	$("#personnels_wrap").addRemRow({
		addBtn: "#personnels_add",
		maxFields: 20,
		removeClass: "personnel_remove",
		fieldName: "emregmem",
		rowSelector: "emailgrp",
		reindexKnownAttributes: [],
		// rowTemplate must use the same removeClass class so delegated handler fires:
		rowTemplate: (i, name) => createPersonnelRow(i, name),
		onAdd: (i, $r) => {
			// console.log('Personnel added', i, $r)
			initializeChainedSelectsForPersonnels(i);
		},
		onRemove: async (i, event, $row, name) => {
			event.preventDefault();
			// console.log('Personnel removed', i, event, $row)
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

};

function createPersonnelRow(index, emregmem) {
	return `
		<div class="col-sm-12 row mt-3 emailgrp" id="emailgrp_${index}">
			<input type="hidden" name="${emregmem}[${index}][id]">
			<div class="col-sm-11 m-0 mt-2 row">
				<label for="dept_${index}" class="col-sm-4">K/P/B : </label>
				<div class="col-sm-8">
					<select name="${emregmem}[${index}][department_id]" id="dept_${index}" class="form-select form-select-sm">
						<option value="">Please choose department</option>
					</select>
				</div>
			</div>
			<div class="col-sm-11 m-0 mt-1 row">
				<label for="staff_${index}" class="col-sm-4">Staf : </label>
				<div class="col-sm-8">
					<select name="${emregmem}[${index}][email_staff]" id="staff_${index}" class="form-select form-select-sm">
						<option value="">Please choose staff</option>
					</select>
				</div>
				<small> Sila masukkan senarai emel ahli kumpulan anda.</small>
				<small> Sekiranya ahli yang ingin ditambah tiada dalam pilihan senarai, mungkin :</small>
				<small>
					<ul>
						<li>Alamat emel telah dibekukan, atau;</li>
						<li>Alamat emel tiada di dalam sistem, atau;</li>
						<li>Alamat emel belum didaftarkan.</li>
					</ul>
				</small>
			</div>
			<div class="col-sm-1 m-0">
				<button class="btn btn-sm btn-danger personnel_remove" type="button" data-id="${index}">
					<i class="fa-regular fa-trash-can"></i>
				</button>
			</div>
		</div>`;
}

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

	// Initialize Select2 for staff
	$(personnelsSelector).select2({
		placeholder: "Please choose staff",
		width: '100%',
		allowClear: true,
		closeOnSelect: true,
	});

	// Chain the dept dropdown to the staff dropdown
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
					error('AJAX Error:', status, error);
				}
			});
		}
	});
}

/////////////////////////////////////////////////////////////////////////////////////////
// add email
$("#emails_wrap").addRemRow({
	addBtn: "#emails_add",
	maxFields: 5,
	removeClass: "email_remove",
	fieldName: "emreg",
	rowSelector: "email",
	rowTemplate: (i, name) => `
			<div class="col-sm-12 row mt-3 email" id="email_${i}">
			<div class="col-sm-11 m-0 row">
				<label for="email_${i}" class="col-form-label col-sm-3">Alamat Emel : </label>
				<div class="col-sm-9">
					<input type="hidden" name="${name}[${i}][id]" value="">
					<div class="input-group">
						<input id="email_${i}" type="text" name="${name}[${i}][email_suggestion]" class="form-control form-control-sm {{ ($errors->has('emreg.*.email_suggestion')?'is-invalid':NULL) }}" placeholder="Email ID" aria-label="Email ID" aria-describedby="emailID_${i}">
						<span class="input-group-text" id="emailID_${i}">@unishams.edu.my</span>
					</div>
				</div>
			</div>
			<div class="col-sm-1 m-0">
				<button type="button" class="btn btn-sm btn-danger email_remove" data-index="${i}">
					<i class="fa-regular fa-trash-can"></i>
				</button>
			</div>
		</div>
		`,
	// User callbacks (run before plugin features)
	onAdd: (i, e, $row, name) => {
		console.log('User: Row added at index', i);
	},
	onRemove: async (i, e, $row, name) => {
		console.log('User: About to remove row', i);

		const idv = $row.find(`input[name="${name}[${i}][id]"]`).val();
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
// restore old data
@php
	$items = @$emailaccapp?->hasmanyemailsuggestion()?->get(['id', 'email_application_id', 'email_suggestion']);
	$itemsArray = $items?->toArray()??[];
	$oldItemsValue = old('emreg', $itemsArray);
@endphp

const oldemails = @json($oldItemsValue);
if (oldemails.length > 0) {
	oldemails.forEach(function (jrnl, i) {
		$("#emails_add").trigger('click');

		const $row = $("#emails_wrap").children().eq(i);

		$row.find(`input[name="emreg[${i}][id]"]`).val(jrnl.id || '');
		$row.find(`input[name="emreg[${i}][email_application_id]"]`).val(moment(jrnl.email_application_id).format('YYYY-MM-DD') || '');
		$row.find(`input[name="emreg[${i}][email_suggestion]"]`).val(jrnl.email_suggestion || '');
	});
}

function oldgroupemail() {
	@php
		$itemsa = @$emailaccapp?->hasmanyemailgroupmember()?->get(['id', 'email_application_id', 'department_id', 'email_staff']);
		$itemsArrayb = $itemsa?->toArray()??[];
		$oldItemsValuec = old('emregmem', $itemsArrayb);
		// dd($oldItemsValuec);
	@endphp
	const oldGroupEmail = @json($oldItemsValuec);
	if (oldGroupEmail.length > 0) {
		oldGroupEmail.forEach(function (gema, i) {
			$("#personnels_add").trigger('click');

			const $row = $("#personnels_wrap").children().eq(i);

			const $account_id = $row.find(`select[name="emregmem[${i}][department_id]"]`);
			const $ledger_id = $row.find(`select[name="emregmem[${i}][email_staff]"]`);

			if (gema.department_id) {
				$.ajax({
					url: `{{ route('listjabatan') }}`,
					data: {
						kodjabatan: gema.department_id,
					},
					dataType: 'json'
				}).then(data => {
					const itema = Array.isArray(data) ? data[0] : data;	// change object to array
					if (!itema) return;
					//console.log(itema, itema.results[0].children[0].id);
					const option1 = new Option(itema.results[0].children[0].text, itema.results[0].children[0].id, true, true);
					$account_id.append(option1).trigger('change');
				});
			}

			if (gema.email_staff) {
				$.ajax({
					url: `{{ route('listemailjabatan') }}`,
					data: {
						email: gema.email_staff,
						dept_id: gema.department_id
					},
					dataType: 'json'
				}).then(data => {
					const [name, email] = Object.entries(data[0])[0];
					// console.log(Object.entries(data[0])[0]);
					// name = "Rahimah Binti Hj Jamaluddin"
					// email = "rahimah@unishams.edu.my"

					const option2 = new Option(name, email, true, true);
					$ledger_id.append(option2).trigger('change');
				});
			}

			$row.find(`input[name="emregmem[${i}][id]"]`).val(gema.id || '');
			$row.find(`input[name="emregmem[${i}][email_application_id]"]`).val(gema.email_application_id || '');
		});
	}
}
/////////////////////////////////////////////////////////////////////////////////////////
