<x-app-layout>

	<x-slot name="header">
		<h2 class="font-montserrat font-semibold text-xl text-gray-800 leading-tight text-center">
			{{ __('BTM02 - BORANG PENDAFTARAN AKAUN DAN MODUL ICMS') }}
		</h2>
	</x-slot>

	<form action="{{ route('btmicmsrequester.update', $regaccicm) }}" method="PATCH" class="needs-validation" novalidate>
		@csrf
		<div class="container d-flex justify-content-between">

			<div class="col-sm-12 mt-2 p-1">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Maklumat Pemohon</h3>
					</div>
					<div class="card-body">

						<div id="applicants_wrap">
							<?php
								$i = 0;
							?>
							@if($regaccicm->hasmanyapplicant()->count())
								@foreach($regaccicm->hasmanyapplicant()->get() as $k1 => $v1)
								<div class="col-sm-12 row m-3" id="applicant_{{ $i }}">
									<input type="hidden" name="emreg[{{ $i }}][id]" value="{{ $v1->id }}">
									<div class="col-sm-7 m-0 p-1">

										<div class="col-sm-12 m-1 row">
											<x-input-label for="nama_{{ $i }}" class="col-sm-3" :value="__('Nama Staff : ')" />
											<div class="col-sm-9">
												<select id="nama_{{ $i }}" name="emreg[{{ $i }}][nama]" class="form-select form-select-sm @error('emreg.*.nama') is-invalid @enderror" placeholder="Please choose"></select>
												@error('emreg.*.nama')
												<div class="invalid-feedback">
													{{ $message }}
												</div>
												@enderror
											</div>
										</div>

										<div class="col-sm-12 m-1 row">
											<x-input-label for="nostaf_{{ $i }}" class="col-sm-3" :value="__('No Staff : ')" />
											<div class="col-sm-9">
												<input id="nostaf_{{ $i }}" type="text" name="emreg[{{ $i }}][nostaf]" value="{{ old('emreg.*.nostaf', $v1->nostaf) }}" class="form-control form-control-sm @error('emreg.*.nostaf') is-invalid @enderror" placeholder="No Staff" readonly>
											</div>
										</div>

										<div class="col-sm-12 m-1 row">
											<x-input-label for="email_{{ $i }}" class="col-sm-3" :value="__('Email : ')" />
											<div class="col-sm-9">
												<input id="email_{{ $i }}" type="text" name="emreg[{{ $i }}][email]" value="{{ old('emreg.*.email', $v1->belongstoicmsapplicant?->hasmanylogin()?->first()?->email) }}" class="form-control form-control-sm @error('emreg.*.email') is-invalid @enderror" placeholder="Email" readonly>
											</div>
										</div>

										<div class="col-sm-12 m-1 row">
											<x-input-label for="jawatan_{{ $i }}" class="col-sm-3" :value="__('Jawatan : ')" />
											<div class="col-sm-9">
												<input id="jawatan_{{ $i }}" type="text" name="emreg[{{ $i }}][position]" value="{{ old('emreg.*.position', $v1['position']) }}" class="form-control form-control-sm @error('emreg.*.position') is-invalid @enderror" placeholder="Jawatan">
												@error('emreg.*.position')
												<div class="invalid-feedback">
													{{ $message }}
												</div>
												@enderror
											</div>
										</div>

										<div class="col-sm-12 m-1 row">
											<x-input-label for="cadid_{{ $i }}" class="col-sm-3" :value="__('Cadangan ID : ')" />
											<div class="col-sm-9">
												<input id="cadid_{{ $i }}" type="text" name="emreg[{{ $i }}][proposed_id]" class="form-control form-control-sm @error('emreg.*.proposed_id') is-invalid @enderror" value="{{ old('emreg.*.proposed_id', $v1['username']) }}" placeholder="Cadangan ID" aria-describedby="CadanganIDHelpBlock_{{ $i }}">
												<div id="CadanganIDHelpBlock_{{ $i }}" class="form-text fs-6 fw-lighter">
													Hanya untuk pemohon baru.
												</div>
												@error('emreg.*.proposed_id')
												<div class="invalid-feedback">
													{{ $message }}
												</div>
												@enderror
											</div>
										</div>

										<div class="col-sm-12 m-1 row">
											<x-input-label for="passid_{{ $i }}" class="col-sm-3" :value="__('Kata Laluan : ')" />
											<div class="col-sm-9">
												<input id="passid_{{ $i }}" type="text" name="emreg[{{ $i }}][password]" class="form-control form-control-sm @error('emreg.*.password') is-invalid @enderror" value="{{ old('emreg.*.password', $v1['password']) }}" placeholder="Kata Laluan">
												@error('emreg.*.password')
												<div class="invalid-feedback">
													{{ $message }}
												</div>
												@enderror
											</div>
										</div>

										<div class="col-sm-12 m-1 row">
											<div class="form-check">
												<label class="form-check-label" for="menu_{{ $i }}">
													Penetapan Menu Sahaja
												</label>
												<input name="emreg[{{ $i }}][menu_setting_only]" class="form-check-input @error('emreg.*.menu_setting_only') is-invalid @enderror" type="checkbox" value="1" id="menu_{{ $i }}" {{ old('emreg.*.menu_setting_only', $v1['menu_setting_only'])?'checked':NULL }}>
												@error('emreg.*.menu_setting_only')
												<div class="invalid-feedback">
													{{ $message }}
												</div>
												@enderror
											</div>
										</div>

									</div>

									<div class="col-sm-5 m-0 p-1" id="checkbox_{{ $i }}">
										<h6>PENETAPAN TAHAP CAPAIAN ICMS</h6>
									</div>
									<div class="col-sm-12 m-2">
										<button type="button" class="btn btn-sm btn-danger applicant_delete" data-id="{{ $v1->id }}"><i class="fa-regular fa-trash-can fa-beat"></i>&nbsp;Padam Pemohon</button>
									</div>
								</div>
								<?php
									$i++;
								?>
								@endforeach
							@endif
						</div>

						<x-primary-button type="button" id="applicants_add">
							<i class="fa-solid fa-screwdriver-wrench fa-beat"></i> </i>&nbsp;Tambah Pemohon
						</x-primary-button>


					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-10 m-2 mx-auto">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Sokongan Pengarah/Dekan/Ketua Jabatan</h3>
					<p>
						@php
						$r = \App\Models\Staff::find($regaccicm->nostaf);
						echo $r->belongstomanydepartment()->first()->namajabatan;

						$idj = $r->belongstomanydepartment()->first()->kodjabatan;
						@endphp
					</p>
				</div>
				<div class="card-body">
					<p>Nama :
						@php
						$j = \App\Models\Jabatan::find($idj);
						if($j->belongstomanyappr->count()){
							echo $j->belongstomanyappr->first()->nama;
						}
						@endphp
					</p>
					<p>Tarikh : {{ ($regaccicm->approver_date)?\Carbon\Carbon::parse($regaccicm->approver_date)->format('j M Y'):NULL }}</p>
					<p>Sokongan : {{ $regaccicm->belongstoapproverstatus?->status_approval }}</p>
					<p>Catatan : {{ $regaccicm->approver_remarks }}</p>
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Bahagian Teknologi Maklumat</h3>
						</div>
						<div class="card-body">

						<div class="row">
							<div class="btn-group {{ ($errors->has('status_request_id')?'is-invalid':NULL) }}" role="group" aria-label="Loan Equipment Approval">
								<?php
									$p = 0;
								?>
								@foreach(\App\Models\StatusApplication::whereIn('id', [1,2])->get() as $v)
									<input type="radio" class="btn-check {{ ($errors->has('status_request_id')?'is-invalid':NULL) }}" name="status_request_id" id="status_loan{{ $p }}" value="{{ $v->id }}" {{ ($regaccicm->status_request_id == $v->id)?'checked="checked"':NULL }} autocomplete="off">
									<label class="btn btn-sm btn-outline-primary" for="status_loan{{ $p }}">{{ $v->status_loan }}</label>
									<?php
										$p++;
									?>
								@endforeach
							</div>
							<x-input-error :messages="$errors->get('status_request_id')" />
						</div>
						<div class="col-sm-12 mt-2 row">
							<x-input-label for="rem" class="col-sm-4" :value="__('BTM Remarks : ')" />
							<div class="col-sm-8">
								<textarea name="btm_remarks" class="form-control form-control-sm {{ ($errors->has('btm_remarks')?'is-invalid':NULL) }}" id="rem">{{ $regaccicm->btm_remarks }}</textarea>
								<x-input-error :messages="$errors->get('btm_remarks')" />
							</div>
						</div>


						</div>
						<div class="card-footer bg-warning-subtle @error('acknowledge') has-error @enderror">
							<div class="form-check text-center @error('acknowledge') is-invalid @enderror">
								<label class="form-check-label text-sm fs-6 fw-bolder" for="checkDefault">
									<input class="form-check-input mx-2 @error('acknowledge') is-invalid @enderror" type="checkbox" name="acknowledge" value="1" id="checkDefault">
									Saya mengaku bahawa semakan telah dibuat dan maklumat ini adalah benar untuk kegunaan urusan rasmi.
								</label>
							</div>
							@error('acknowledge')
							<div class="invalid-feedback text-center fs-6 fw-bolder">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-12 text-center">
			<x-primary-button type="submit" class="m-2">
				<i class="fa-solid fa-floppy-disk fa-beat"></i>&nbsp;{{ __('Hantar') }}
			</x-primary-button>
		</div>
	</form>

	@section('js')
	/////////////////////////////////////////////////////////////////////////////////////////
	// jquery plugin (addRemoveRow)
	(function ($) {
		$.fn.remAddRow = function (options) {
			const settings = $.extend({
				addBtn: null,                 // selector for add button (required)
				maxFields: 10,                // maximum visible rows
				removeSelector: ".row_remove",// selector used inside the rowTemplate for the remove button
				fieldName: "rows",            // used to reindex input names like fieldName[index]
				rowIdPrefix: "row",           // prefix used for each row id (row_0, row_1 ...)
				reindexOnRemove: true,        // whether to reindex names/data-id after remove
				// default template: uses removeSelector (converted to class) and fieldName
				rowTemplate: (i, name) => {
					const removeClass = (".row_remove".replace(/^\./, "")); // default removeSelector class
					return `
					<div class="row-box" id="row_${i}">
						<span data-row-index>Row #${i+1}</span>
						<input type="text" name="${name}[${i}]" />
						<button type="button" class="${removeClass}" data-id="${i}">Remove</button>
					</div>
					`;
				},
				startCounter: 0,
				onAdd: (i, $row) => {},
				onRemove: (i) => {}
			}, options);

			const $wrapper = this;
			const $addBtn = $(settings.addBtn);

			// escape a string for safe use in a RegExp
			function escapeRegex(s) {
				return s.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
			}

			// regex to detect names beginning with `fieldName[<number>]`
				const namePrefixRegex = new RegExp('^' + escapeRegex(settings.fieldName) + '\\[\\d+\\]');

				// reindex rows so indexes in names and data-id become 0..n-1
				function reindexRows() {
					$wrapper.children().each(function (i) {
						const $row = $(this);

						// set new id like prefix_i
						$row.attr('id', `${settings.rowIdPrefix}_${i}`);

						// update any visible "index" elements if present
						$row.find('[data-row-index]').each(function () {
							$(this).text($(this).data('row-index-offset') ? $(this).data('row-index-offset') + i : i + 1);
						});

						// rename inputs/selects/textareas that start with fieldName[...] => fieldName[i]...
						$row.find('input[name], select[name], textarea[name]').each(function () {
							const name = $(this).attr('name');
							if (!name) return;
							const newName = name.replace(namePrefixRegex, `${settings.fieldName}[${i}]`);
							$(this).attr('name', newName);
						});

						// update remove button data-id(s)
						$row.find(settings.removeSelector).attr('data-id', i);
					});
				}

				// update add button enabled state using actual current count
				function updateAddBtnState() {
					if (!$addBtn.length) return;
					const currentCount = $wrapper.children().length;
					$addBtn.prop('disabled', currentCount >= settings.maxFields);
				}

				// initialize: ensure pre-existing rows are reindexed (if any)
				if (settings.reindexOnRemove) reindexRows();
				updateAddBtnState();

				// ADD handler: base next index on current number of children (keeps indices contiguous)
				$addBtn.on('click', function () {
					const currentCount = $wrapper.children().length;
					if (currentCount >= settings.maxFields) return;
					const index = currentCount; // next index
					const $row = $(settings.rowTemplate(index, settings.fieldName));
					$wrapper.append($row);
					// If rowTemplate didn't embed the correct data-id or names, we reindex to be safe
					if (settings.reindexOnRemove) reindexRows();
					settings.onAdd(index, $row);
					updateAddBtnState();
				});

				// REMOVE (delegated). We find the nearest child-of-wrapper ancestor to remove.
				$wrapper.on('click', settings.removeSelector, function (e) {
					e.preventDefault();
					const clicked = $(this);
					const id = clicked.data('id');

					// prefer closest ancestor whose id ends with _<id>
						let $target = clicked.closest(`[id$="_${id}"]`);

						// fallback: find first ancestor whose parent is wrapper (i.e., direct child of wrapper)
						if (!$target.length) {
							$target = clicked.parents().filter(function () {
								return $(this).parent().is($wrapper);
							}).first();
						}

						// final fallback: closest .row-box
						if (!$target.length) $target = clicked.closest('.row-box');

						if ($target.length) {
							$target.remove();
							if (settings.reindexOnRemove) reindexRows();
							settings.onRemove(id);
							updateAddBtnState();
						} else {
							console.warn('remAddRow: could not locate row to remove for id=', id);
						}
					});

					return this;
				};
			})(jQuery);

	/////////////////////////////////////////////////////////////////////////////////////////
	<?php
		$p = 0;
	?>
	@if($regaccicm->hasmanyapplicant()->count())
		@foreach($regaccicm->hasmanyapplicant()->get() as $k1 => $v1)
			console.log({!! $v1->belongstomanyicmsmodule()->get()->map(function ($item) { return collect($item->pivot->toArray())->only(['icms_module_id', 'remarks'])->toArray(); }) !!});
			selectname({{ $p }});
			addingicmsmodule({{ $p }}, {!! $v1->belongstomanyicmsmodule()->get()->map(fn($item) => ['icms_module_id' => $item->pivot->icms_module_id,'remarks' => $item->pivot->remarks,]) !!});
			var newOption{{ $p }} = new Option({!! json_encode($v1->nostaf . ' => ' . $v1->belongstoicmsapplicant?->nama) !!}, '{{ $v1->nostaf }}', true, true);
			$('#nama_{{ $p }}').append(newOption{{ $p }}).trigger('change');
			<?php
				$p++;
			?>
		@endforeach
	@endif

	/////////////////////////////////////////////////////////////////////////////////////////
	// usage plugin
	// Applicants (fieldName "skills")
	$("#applicants_wrap").remAddRow({
		addBtn: "#applicants_add",
		maxFields: 5,
		startCounter: {{ $regaccicm->hasmanyapplicant()->count() }},
		removeSelector: ".applicant_remove",
		fieldName: "applicants",
		rowIdPrefix: "applicant",
		// rowTemplate must use the same removeSelector class so delegated handler fires:
		rowTemplate: (i, name) => `
			<div class="col-sm-12 row m-3" id="applicant_${i}">
				<input type="hidden" name="emreg[${i}][id]" value="">
				<div class="col-sm-7 m-0 p-1">

					<div class="col-sm-12 m-1 row">
						<x-input-label for="nama_${i}" class="col-sm-3" :value="__('Nama : ')" />
						<div class="col-sm-9">
							<select id="nama_${i}" name="emreg[${i}][nama]" class="form-select form-select-sm @error('emreg.*.nama') is-invalid @enderror" placeholder="Please choose"></select>
							@error('emreg.*.nama')
							<div class="invalid-feedback">
								{{ $message }}
							</div>
							@enderror
						</div>
					</div>

					<div class="col-sm-12 m-1 row">
						<x-input-label for="nostaf_${i}" class="col-sm-3" :value="__('No Staff : ')" />
						<div class="col-sm-9">
							<input id="nostaf_${i}" type="text" name="emreg[${i}][nostaf]" value="{{ old('emreg.*.nostaf') }}" class="form-control form-control-sm @error('emreg.*.nostaf') is-invalid @enderror" placeholder="No Staff" readonly>
						</div>
					</div>

					<div class="col-sm-12 m-1 row">
						<x-input-label for="email_${i}" class="col-sm-3" :value="__('Email : ')" />
						<div class="col-sm-9">
							<input id="email_${i}" type="text" name="emreg[${i}][email]" value="{{ old('emreg.*.email') }}" class="form-control form-control-sm @error('emreg.*.email') is-invalid @enderror" placeholder="Email" readonly>
						</div>
					</div>

					<div class="col-sm-12 m-1 row">
						<x-input-label for="jawatan_${i}" class="col-sm-3" :value="__('Jawatan : ')" />
						<div class="col-sm-9">
							<input id="jawatan_${i}" type="text" name="emreg[${i}][position]" value="{{ old('emreg.*.position') }}" class="form-control form-control-sm @error('emreg.*.position') is-invalid @enderror" placeholder="Jawatan">
							@error('emreg.*.proposed_id')
							<div class="invalid-feedback">
								{{ $message }}
							</div>
							@enderror
						</div>
					</div>

					<div class="col-sm-12 m-1 row">
						<x-input-label for="cadid_${i}" class="col-sm-3" :value="__('Cadangan ID : ')" />
						<div class="col-sm-9">
							<input id="cadid_${i}" type="text" name="emreg[${i}][proposed_id]" class="form-control form-control-sm @error('emreg.*.proposed_id') is-invalid @enderror" placeholder="Cadangan ID" aria-describedby="CadanganIDHelpBlock_${i}">
							<div id="CadanganIDHelpBlock_${i}" class="form-text fs-6 fw-lighter">
								Hanya untuk pemohon baru.
							</div>
							@error('emreg.*.proposed_id')
							<div class="invalid-feedback">
								{{ $message }}
							</div>
							@enderror
						</div>
					</div>

					<div class="col-sm-12 m-1 row">
						<x-input-label for="passid_${i}" class="col-sm-3" :value="__('Kata Laluan : ')" />
						<div class="col-sm-9">
							<input id="passid_${i}" type="text" name="emreg[${i}][password]" class="form-control form-control-sm @error('emreg.*.password') is-invalid @enderror" value="{{ old('emreg.*.password', $v1['password']) }}" placeholder="Kata Laluan">
							@error('emreg.*.password')
							<div class="invalid-feedback">
								{{ $message }}
							</div>
							@enderror
						</div>
					</div>

					<div class="col-sm-12 m-1 row">
						<div class="form-check">
							<label class="form-check-label" for="menu_${i}">
								Penetapan Menu Sahaja
							</label>
							<input name="emreg[${i}][menu_setting_only]" class="form-check-input @error('emreg.*.menu_setting_only') is-invalid @enderror" type="checkbox" value="1" id="menu_${i}" {{ old('emreg.*.menu_setting_only', $v1['menu_setting_only'])?'checked':NULL }}>
							@error('emreg.*.menu_setting_only')
							<div class="invalid-feedback">
								{{ $message }}
							</div>
							@enderror
						</div>
					</div>




				</div>

				<div class="col-sm-5 m-0 p-1" id="checkbox_${i}">
					<h6>PENETAPAN TAHAP CAPAIAN ICMS</h6>
				</div>
				<div class="col-sm-12 m-2">
					<button type="button" class=" btn btn-sm btn-danger applicant_remove" data-id="${i}"><i class="fa-regular fa-trash-can fa-beat"></i>&nbsp;Padam Pemohon</button>
				</div>
			</div>
		`,
		onAdd: (i, $r) => {
			// console.log('Skill added', i, $r)
			selectname(i);
			addingicmsmodule(i);
		},
		onRemove: (i) => console.log('Skill removed', i)
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
					console.log(data);
					let selectedValues = $('select.form-select').map(function () {
						return $(this).val();
					}).get();
					console.log(selectedValues);
					data.results[0].children = $.grep(data.results[0].children, function(obj) {
						return $.inArray(obj.id, selectedValues) === -1;
					});
					console.log(data);
					return {
						results: $.map(data.results[0].children, function (item) {
							return {
								id: item.id,       // staff no
								text: item.text,   // display in dropdown
								email: item.element // email from JSON
							};
						})
					};
				}
			},
			templateResult: function (data) {
				return data.text;
			},
			templateSelection: function (data) {
				return data.text;
			}
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
	// this will populate 1st select2
	@if(!$regaccicm->hasmanyapplicant()->count())
		selectname();
	@endif

	/////////////////////////////////////////////////////////////////////////////////////////
	// checkbox
	function addingicmsmodule(y=0, icmsmodule = []){
		$.ajax({
			dataType: 'json',
			url: "{{ route('listicmsmodule') }}",
			type: "GET",
			data: {
				_token: '{{csrf_token()}}'
			},
			// success: (function(response) {
			// 	const $checkicmsmodule = $("#checkbox_"+y);

			// 	// i need to find the array of icms_module and paste it overhere so that i can di ifelse logic
			// 	let cicms = icmsmodule;

			// 	response.forEach(function(value, i) {
			// 		const checkboxId = `icms_${y}_${i}`;

			// 		const row = `
			// 			<div id="cb_${y}_${i}" class="m-1">
			// 				<div class="form-check">
			// 					<input class="form-check-input icms-checkbox @error('emreg.*.icms_module_id') is-invalid @enderror" type="checkbox" id="${checkboxId}" name="emreg[${y}][icms_module_id][${i}]" value="${value.id}" data-dll="#dll_container_${y}_${i}" data-y="${y}" data-i="${i}" >
			// 					<label class="form-check-label " for="${checkboxId}">&nbsp;${value.text}</label>
			// 					@error('emreg.*.icms_module_id')
			// 					<div class="invalid-feedback">
			// 						{{ $message }}
			// 					</div>
			// 					@enderror
			// 				</div>
			// 			</div>
			// 		`;
			// 		// if(value.id == ) {

			// 		// };
			// 		$checkicmsmodule.append(row);

			// 		if (value.id == 9) {
			// 			const dll = `
			// 				<div id="dll_container_${y}_${i}" class="m-1 dll-container">
			// 				</div>
			// 			`;
			// 			$checkicmsmodule.append(dll);
			// 		}
			// 	});
			// }),
success: (function(response) {
    const $checkicmsmodule = $("#checkbox_"+y);

    // Pivot data from backend
    let cicms = icmsmodule;

    response.forEach(function(value, i) {
        const checkboxId = `icms_${y}_${i}`;

        // Check if this module_id exists in cicms
        let found = cicms.find(m => m.icms_module_id == value.id);

        // If found, mark checked
        let isChecked = found ? 'checked' : '';

        const row = `
            <div id="cb_${y}_${i}" class="m-1">
                <div class="form-check">
                    <input class="form-check-input icms-checkbox @error('emreg.*.icms_module_id') is-invalid @enderror"
                           type="checkbox"
                           id="${checkboxId}"
                           name="emreg[${y}][icms_module_id][${i}]"
                           value="${value.id}"
                           data-dll="#dll_container_${y}_${i}"
                           data-y="${y}" data-i="${i}" ${isChecked}>
                    <label class="form-check-label" for="${checkboxId}">&nbsp;${value.text}</label>
                    @error('emreg.*.icms_module_id')
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
                               name="emreg[${y}][icms_module_id][remarks]"
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
				console.log(textStatus, errorThrown);
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
					<input class="form-control form-control-sm" type="text" name="emreg[${y}][icms_module_id][remarks]" id="icms_dll_${y}_${i}" value="{{ old('emreg.*.icms_module_id.remarks') }}">
					@error('emreg.*.icms_module_id.dll')
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
	@if(!$regaccicm->hasmanyapplicant()->count())
	addingicmsmodule();
	@endif

	/////////////////////////////////////////////////////////////////////////////////////////
$(document).on('click', '.applicant_delete', function(e){
	var ackID = $(this).data('id');
	SwalDeleteR(ackID);
	e.preventDefault();
});

function SwalDeleteR(ackID){
	swal.fire({
		title: 'Delete Registeration Account ICMS Applicant',
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
					url: '{{ url('regaccicmsapplicant') }}' + '/' + ackID,
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
			swal.fire('Cancel Action', 'Registeration Account ICMS Applicant is still active.', 'info')
		}
	});
}
//auto refresh right after clicking OK button
$(document).on('click', '.swal2-confirm', function(e){
	window.location.reload(true);
});


	/////////////////////////////////////////////////////////////////////////////////////////
	@endsection
</x-app-layout>
