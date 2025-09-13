<x-app-layout>

	<x-slot name="header">
		<h2 class="font-montserrat font-semibold text-xl text-gray-800 leading-tight text-center">
			{{ __('BTM02 - BORANG PENDAFTARAN AKAUN DAN MODUL ICMS') }}
		</h2>
	</x-slot>

	<form action="{{ route('regaccicms.store') }}" method="POST" class="needs-validation" novalidate>
		@csrf
		<div class="container d-flex justify-content-between">
<!--
			<div class="col-4-sm m-2 p-1">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Pemohon</h3>
					</div>
					<div class="card-body">
						<div class="col-sm-12 mt-2 row">
							<x-input-label for="id" class="col-sm-4" :value="__('No. Staf : ')" />
							<div class="col-sm-8">
								<x-text-input id="id" name="nostaf" value="{{ Auth::user()->nostaf }}" class="{{ ($errors->has('nostaf')?'is-invalid':NULL) }}" readonly />
								<x-input-error :messages="$errors->get('nostaf')" />
							</div>
						</div>

						<div class="col-sm-12 mt-2 row">
							<x-input-label for="staf" class="col-sm-4" :value="__('Nama Staf : ')" />
							<div class="col-sm-8">
								<x-text-input id="staf" name="nama" value="{{ Auth::user()->name }}" class="{{ ($errors->has('nama')?'is-invalid':NULL) }}" readonly />
								<x-input-error :messages="$errors->get('nama')" />
							</div>
						</div>

					</div>
				</div>
			</div>
			-->
			<div class="col-sm-12 mt-2 p-1">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Maklumat Pemohon</h3>
					</div>
					<div class="card-body">

						<div id="applicants_wrap">
							<div class="col-sm-12 row m-3" id="applicant_0">
								<div class="col-sm-7 m-0 p-1">

									<div class="col-sm-12 m-1 row">
										<x-input-label for="nama_0" class="col-sm-3" :value="__('Nama Staff : ')" />
										<div class="col-sm-9">
											<select id="nama_0" name="emreg[0][nama]" class="form-select form-select-sm @error('emreg.*.nama') is-invalid @enderror" placeholder="Please choose"></select>
											@error('emreg.*.nama')
											<div class="invalid-feedback">
												{{ $message }}
											</div>
											@enderror
										</div>
									</div>

									<div class="col-sm-12 m-1 row">
										<x-input-label for="nostaf_0" class="col-sm-3" :value="__('No Staff : ')" />
										<div class="col-sm-9">
											<input id="nostaf_0" type="text" name="emreg[0][nostaf]" value="{{ old('emreg.*.nostaf') }}" class="form-control form-control-sm @error('emreg.*.nostaf') is-invalid @enderror" placeholder="No Staff" readonly>
										</div>
									</div>

									<div class="col-sm-12 m-1 row">
										<x-input-label for="email_0" class="col-sm-3" :value="__('Email : ')" />
										<div class="col-sm-9">
											<input id="email_0" type="text" name="emreg[0][email]" value="{{ old('emreg.*.email') }}" class="form-control form-control-sm @error('emreg.*.email') is-invalid @enderror" placeholder="Email" readonly>
										</div>
									</div>

									<div class="col-sm-12 m-1 row">
										<x-input-label for="jawatan_0" class="col-sm-3" :value="__('Jawatan : ')" />
										<div class="col-sm-9">
											<input id="jawatan_0" type="text" name="emreg[0][position]" value="{{ old('emreg.*.position') }}" class="form-control form-control-sm @error('emreg.*.position') is-invalid @enderror" placeholder="Jawatan">
											@error('emreg.*.position')
											<div class="invalid-feedback">
												{{ $message }}
											</div>
											@enderror
										</div>
									</div>

									<div class="col-sm-12 m-1 row">
										<x-input-label for="cadid_0" class="col-sm-3" :value="__('Cadangan ID : ')" />
										<div class="col-sm-9">
											<input id="cadid_0" type="text" name="emreg[0][proposed_id]" class="form-control form-control-sm @error('emreg.*.proposed_id') is-invalid @enderror" placeholder="Cadangan ID" aria-describedby="CadanganIDHelpBlock_0">
											<div id="CadanganIDHelpBlock_0" class="form-text fs-6 fw-lighter">
												Hanya untuk pemohon baru.
											</div>
											@error('emreg.*.proposed_id')
											<div class="invalid-feedback">
												{{ $message }}
											</div>
											@enderror
										</div>
									</div>

								</div>

								<div class="col-sm-5 m-0 p-1" id="checkbox_0">
									<h6>PENETAPAN TAHAP CAPAIAN ICMS</h6>
								</div>
								<div class="col-sm-12 m-2">
									<button type="button" class="btn btn-sm btn-danger applicant_remove" data-id="1"><i class="fa-regular fa-trash-can fa-beat"></i>&nbsp;Padam Pemohon</button>
								</div>
							</div>
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
					<h3 class="card-title">Kulliyyah/Pusat/Bahagian</h3>
					<p>
						@php
						$r = \App\Models\Staff::find(Auth::user()->nostaf);
						echo $r->belongstomanydepartment()->first()->namajabatan;
						$idj = $r->belongstomanydepartment()->first()->kodjabatan;
						@endphp
					</p>
				</div>
				<div class="card-body">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Sokongan Pengarah/Dekan/Ketua Jabatan</h3>
						</div>
						<div class="card-body">
							<p>Status :
								@php
								$j = \App\Models\Jabatan::find($idj);
								if($j->belongstomanyappr->count()){
									echo $j->belongstomanyappr->first()->nama;
								} else {
									echo '<span class="text-danger fw-bold">Dalam Proses/Disokong/Tidak Disokong</span>';
								}
								@endphp
							</p>
							<p>Tarikh : </p>
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
	// usage plugin
	// Applicants (fieldName "skills")
	$("#applicants_wrap").remAddRow({
		addBtn: "#applicants_add",
		maxFields: 5,
		removeSelector: ".applicant_remove",
		fieldName: "applicants",
		rowIdPrefix: "applicant",
		// rowTemplate must use the same removeSelector class so delegated handler fires:
		rowTemplate: (i, name) => `
			<div class="col-sm-12 row m-3" id="applicant_${i}">
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
	selectname()
	/////////////////////////////////////////////////////////////////////////////////////////
	// checkbox
	function addingicmsmodule(y=0){
		$.ajax({
			dataType: 'json',
			url: "{{ route('listicmsmodule') }}",
			type: "GET",
			data: {
				_token: '{{csrf_token()}}'
			},
			success: (function(response) {
				const $checkicmsmodule = $("#checkbox_"+y);

				response.forEach(function(value, i) {
					const checkboxId = `icms_${y}_${i}`;

					const row = `
						<div id="cb_${y}_${i}" class="m-1">
							<div class="form-check">
								<input class="form-check-input icms-checkbox @error('emreg.*.icms_module_id') is-invalid @enderror" type="checkbox" id="${checkboxId}" name="emreg[${y}][icms_module_id][${i}]" value="${value.id}" data-dll="#dll_container_${y}_${i}" data-y="${y}" data-i="${i}">
								<label class="form-check-label " for="${checkboxId}">&nbsp;${value.text}</label>
								@error('emreg.*.icms_module_id')
								<div class="invalid-feedback">
									{{ $message }}
								</div>
								@enderror
							</div>
						</div>
					`;
					$checkicmsmodule.append(row);

					if (value.id == 9) {
						const dll = `
							<div id="dll_container_${y}_${i}" class="m-1 dll-container">
							</div>
						`;
						$checkicmsmodule.append(dll);
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
					<input class="form-control form-control-sm" type="text" name="emreg[${y}][icms_module_id][dll]" id="icms_dll_${y}_${i}" value="{{ old('emreg.*.icms_module_id.dll') }}">
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
	addingicmsmodule()

	/////////////////////////////////////////////////////////////////////////////////////////
	@endsection
</x-app-layout>
