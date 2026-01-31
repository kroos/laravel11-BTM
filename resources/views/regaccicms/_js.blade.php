/////////////////////////////////////////////////////////////////////////////////////////
	// usage plugin
	// Applicants (fieldName "skills")
$("#applicants_wrap").addRemRow({
	addBtn: "#applicants_add",
	maxFields: 5,
	removeClass: "applicant_remove",
	fieldName: "applicants",
	rowSelector: "applicant",
	rowTemplate: (i, name) => `
		<div class="col-sm-12 row m-3 applicant" id="applicant_${i}">
			<input type="hidden" name="${name}[${i}][id]" value="">
			<div class="col-sm-7 m-0 p-1">

				<div class="col-sm-12 m-1 row">
					<x-input-label for="nama_${i}" class="col-sm-3" :value="__('Nama : ')" />
					<div class="col-sm-9">
						<select id="nama_${i}" name="${name}[${i}][nama]" class="form-select form-select-sm @error('applicants.*.nama') is-invalid @enderror" placeholder="Please choose"></select>
						@error('applicants.*.nama')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
						@enderror
					</div>
				</div>

				<div class="col-sm-12 m-1 row">
					<x-input-label for="nostaf_${i}" class="col-sm-3" :value="__('No Staff : ')" />
					<div class="col-sm-9">
						<input id="nostaf_${i}" type="text" name="${name}[${i}][nostaf]" value="" class="form-control form-control-sm @error('applicants.*.nostaf') is-invalid @enderror" placeholder="No Staff" readonly>
					</div>
				</div>

				<div class="col-sm-12 m-1 row">
					<x-input-label for="email_${i}" class="col-sm-3" :value="__('Email : ')" />
					<div class="col-sm-9">
						<input id="email_${i}" type="text" name="${name}[${i}][email]" value="" class="form-control form-control-sm @error('applicants.*.email') is-invalid @enderror" placeholder="Email" readonly>
					</div>
				</div>

				<div class="col-sm-12 m-1 row">
					<x-input-label for="jawatan_${i}" class="col-sm-3" :value="__('Jawatan : ')" />
					<div class="col-sm-9">
						<input id="jawatan_${i}" type="text" name="${name}[${i}][position]" value="" class="form-control form-control-sm @error('applicants.*.position') is-invalid @enderror" placeholder="Jawatan">
						@error('applicants.*.proposed_id')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
						@enderror
					</div>
				</div>

				<div class="col-sm-12 m-1 row">
					<x-input-label for="cadid_${i}" class="col-sm-3" :value="__('Cadangan ID : ')" />
					<div class="col-sm-9">
						<input id="cadid_${i}" type="text" name="${name}[${i}][username]" class="form-control form-control-sm @error('applicants.*.username') is-invalid @enderror" placeholder="Cadangan ID" aria-describedby="CadanganIDHelpBlock_${i}">
						<div id="CadanganIDHelpBlock_${i}" class="form-text fs-6 fw-lighter">
							Hanya untuk pemohon baru.
						</div>
						@error('applicants.*.username')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
						@enderror
					</div>
				</div>

			</div>

			<div class="col-sm-5 m-0 p-1">
				<h6>PENETAPAN TAHAP CAPAIAN ICMS</h6>
				<div id="checkbox_${i}">
				</div>
			</div>
			<div class="col-sm-12 m-2">
				<button type="button" class=" btn btn-sm btn-danger applicant_remove" data-id="${i}"><i class="fa-regular fa-trash-can fa-beat"></i>&nbsp;Padam Pemohon</button>
			</div>
		</div>
	`,
	onAdd: (i, e, $r, name) => {
		// console.log('Skill added', i, $r)
		selectname(i);
		addingicmsmodule(i);
	},
	onRemove: async (i, event, $row, name) => {

		const idv = $row.find(`input[name="${name}[${i}][id]"]`).val();
		if (!idv) {
			return true;
		}

		let url = `{{ url('regaccicmsapplicant') }}`;
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
	function selectname(r = 0){
		$('#nama_'+r).select2({
			placeholder: 'Please Choose',
			width: '100%',
			allowClear: true,
			closeOnSelect: true,
			ajax: {
				url: '{{ route('liststaff') }}',
				type: 'GET',
				dataType: 'json',
				data: function (params) {
					return {
						_token: '{!! csrf_token() !!}',
						search: params.term,
						type: 'public'
					};
				},
				processResults: function (data) {
					// console.log(data);
					let selectedValues = $('select.form-select').map(function () {
						return $(this).val();
					}).get();
					// console.log(selectedValues);
					data.results[0].children = $.grep(data.results[0].children, function(obj) {
						return $.inArray(obj.id, selectedValues) === -1;
					});
					// console.log(data);
					return {
						results: $.map(data.results[0].children, function (item) {
							return {
								id: item.id,       // staff no
								text: item.text,   // display in dropdown
								email: item.element // email from JSON
							};
						})
					};
				},
			},
		});

		// ✅ When staff selected, populate NoStaf + Email
		$('#nama_'+r).on('select2:select', function (e) {
			var data = e.params.data;

			$('#nostaf_'+r).val(data.id);      // staff number
			$('#email_'+r).val(data.email);    // staff email
		});

		// ✅ Optional: clear inputs if selection cleared
		$('#nama_'+r).on('select2:clear', function () {
			$('#nostaf_'+r).val('');
			$('#email_'+r).val('');
		});

		// also check on page load (for F5 refresh case)
		if (!$('#nama_'+r).val()) {
			$('#nostaf_'+r).val('');
			$('#email_'+r).val('');
		}
	};

	/////////////////////////////////////////////////////////////////////////////////////////
	// checkbox
	function addingicmsmodule(y=0, icmsMod = []){
		$.ajax({
			dataType: 'json',
			url: "{{ route('listicmsmodule') }}",
			type: "GET",
			data: {
				_token: '{{csrf_token()}}'
			},
			success: (function(response) {
				const $checkicmsmodule = $("#checkbox_"+y);
				if($checkicmsmodule.length > 0) $checkicmsmodule.empty();
				// Pivot data from backend
				// Normalize icmsMod to: [{ icms_module_id: X, remarks: Y }]
				const obj = Array.isArray(icmsMod) ? icmsMod : Object.entries(icmsMod);
				// const obj = Array.isArray(icmsMod) ? icmsMod : Object.value(icmsMod);

				const cicms = obj.map(item =>  item[1]);
				console.log(cicms);


				response.forEach(function(value, i) {
					const checkboxId = `icms_${y}_${i}`;

					// Check if this module_id exists in cicms
					let found = cicms.find(m => m.icms_module_id == value.id);

					// If found, mark checked
					let isChecked = found ? 'checked' : '';

					const row = `
					<div id="cb_${y}_${i}" class="m-1">
						<div class="form-check">
							<input class="form-check-input icms-checkbox @error('applicants.*.icms.*.icms_module_id') is-invalid @enderror"
							type="checkbox"
							id="${checkboxId}"
							name="applicants[${y}][icms][${i}][icms_module_id]"
							value="${value.id}"
							data-dll="#dll_container_${y}_${i}"
							data-y="${y}" data-i="${i}" ${isChecked}>
							<label class="form-check-label" for="${checkboxId}">&nbsp;${value.text}</label>
							@error('applicants.*.icms.*.icms_module_id')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					`;
					$checkicmsmodule.append(row);

					if (value.id == 9) {
						const dll = `
						<div id="dll_container_${y}_${i}" class="m-1 dll-container"></div>
						`;
						$checkicmsmodule.append(dll);

						// If remarks exist, auto-insert input
						if (found && found.remarks) {
							const checkbicms = `
							<div class="form-check dll-input">
								<label class="form-check-label" for="icms_dll_${y}_${i}">Sila Nyatakan</label>
								<input class="form-control form-control-sm"
								type="text"
								name="applicants[${y}][icms][${i}][remarks]"
								id="icms_dll_${y}_${i}"
								value="${found.remarks}">
							</div>
							`;
							$("#dll_container_"+y+"_"+i).append(checkbicms);
						}
					}
				});
			}),
			error: (function(jqXHR, textStatus, errorThrown) {
				alert( "error" );
				// console.log(textStatus, errorThrown);
			}),
			complete: (function() {
				// alert( "complete" );
			})
		});

		// delegated handler
		$(document).on('change', '.icms-checkbox', function() {
			const $cb = $(this);
			const dllSelector = $cb.data('dll');
			const y = $cb.data('y');
			const i = $cb.data('i');

			if (!dllSelector) return;

			let checkbicms = `
				<div class="form-check dll-input">
					<label class="form-check-label" for="icms_dll_${y}_${i}">Sila Nyatakan</label>
					<input class="form-control form-control-sm" type="text" name="applicants[${y}][icms][${i}][remarks]" id="icms_dll_${y}_${i}">
					@error('applicants.*.icms.*.icms_module_id.remarks')
					<div class="invalid-feedback">
						{{ $message }}
					</div>
					@enderror
				</div>
			`;

			const $dll = $(dllSelector);

			if ($cb.is(':checked')) {
				if ($dll.find('.dll-input').length === 0) {
					$dll.append(checkbicms);
				}
			} else {
				$dll.find('.dll-input').remove(); // remove only input part, keep container
			}
		});
	};

/////////////////////////////////////////////////////////////////////////////////////////
// restore old data
<?php
$items = @$regaccicm?->hasmanyapplicant()?->get()
										->map(function ($applicant) {
											$modules = $applicant->belongstomanyicmsmodule()
											->withPivot('remarks')
											->get()
											->map(function ($module) {
												return [
													$module->pivot->id, [
														'icms_module_id' => $module->id,
														'remarks'        => $module->pivot->remarks,
													]
												];
											})
											->toArray();

											return [
												'id'       => $applicant->id,
												'nostaf'   => $applicant->nostaf,
												'email'    => $applicant->email,
												'position' => $applicant->position,
												'username' => $applicant->username,
												'icms'     => $modules,
											];
										})
										->toArray() ?? [];
$oldItemsValue = old('applicants', $items);
// dd($items, $oldItemsValue);
?>
const oldICMSGroup = @json($oldItemsValue);
if (oldICMSGroup.length > 0) {
	oldICMSGroup.forEach(function (icmsGroup, i) {
		$("#applicants_add").trigger('click');
		const $row = $("#applicants_wrap").children().eq(i);
		const $account_id = $row.find(`select[name="applicants[${i}][nama]"]`);

		if (icmsGroup.nama) {
			$.ajax({
				url: `{{ route('liststaff') }}`,
				data: {
					_token: '{!! csrf_token() !!}',
					nostaf: icmsGroup.nama,
				},
				dataType: 'json'
			}).then(data => {
				const itema = Array.isArray(data) ? data[0] : data;	// change object to array
				if (!itema) return;
				// console.log(itema, itema.results[0].children[0].id);
				const option1 = new Option(itema.results[0].children[0].text, itema.results[0].children[0].id, true, true);
				$account_id.append(option1).trigger('change');
			});
		}

		$row.find(`[name="applicants[${i}][id]"]`).val(icmsGroup.id || '');
		$row.find(`[name="applicants[${i}][nostaf]"]`).val(icmsGroup.nostaf || '');
		$row.find(`[name="applicants[${i}][email]"]`).val(icmsGroup.email || '');
		$row.find(`[name="applicants[${i}][position]"]`).val(icmsGroup.position || '');
		$row.find(`[name="applicants[${i}][username]"]`).val(icmsGroup.username || '');
		addingicmsmodule(i, icmsGroup.icms);
	});
}

/////////////////////////////////////////////////////////////////////////////////////////
