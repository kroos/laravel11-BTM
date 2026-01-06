<x-app-layout>

	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Add Approver') }}
		</h2>
	</x-slot>

	<div class="colontainer d-flex justify-content-center">
		<form action="{{ route('addapprover.store') }}" method="POST">
			@csrf
<!--
<div class="card">
	<div class="card-header">
		<h3 class="card-title"></h3>
	</div>
	<div class="card-body">
	</div>
	<div class="card-footer"></div>
</div>
 -->
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Add Approver</h3>
					<div class="col-sm-12 text-right mt-3">
						<x-primary-button type="button" class="add_approver" id="approver_add">
							<i class="fa-solid fa-user-plus"></i>&nbsp;Add Approver
						</x-primary-button>
					</div>
				</div>
				<div class="card-body">
					<div class="wrap_approver @error('approver') is-invalid @enderror" id="approvers_wrap"></div>
					@error('approver')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
					@enderror
				</div>
				<div class="card-footer">
					<x-primary-button type="submit" class="m-3">
						{{ __('Save') }}
					</x-primary-button>
				</div>
			</div>

		</form>
	</div>


@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
//enable select 2 for backup
function populatestaffdept(){
	$('.nostaf').select2({
		placeholder: "Please choose",
		width: '100%',
		allowClear: true,
		closeOnSelect: true,
		ajax: {
			url: '{{ route('liststaff') }}',
			// data: { '_token': '{!! csrf_token() !!}' },
			// theme: 'bootstrap5',
			type: 'GET',
			dataType: 'json',
			data: function (params) {
				return {
				// var query = {
					_token: '{!! csrf_token() !!}',
					search: params.term,
					type: 'public'
				}
				// return query;
			},
			processResults: function (data) {
				console.log("Raw response:", data);
				// ✅ map children properly
				var processed = $.map(data.results[0].children, function (item) {
					return {
						id: item.id,
						text: item.text,
						email: item.element // 👈 keep email
					};
				});
				console.log("Processed items:", processed);
				return {
					results: processed
				};
			}
		},
		templateResult: function (data) {
			return data.text; // only show the staff name/id
		},
		templateSelection: function (data) {
			return data.text;
		}
	});

	$('.kod_jabatan').select2({
		placeholder: "Please choose",
		width: '100%',
		allowClear: true,
		closeOnSelect: true,
		ajax: {
			url: '{{ route('listjabatan') }}',
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
	});
}

/////////////////////////////////////////////////////////////////////////////////////////
// add approver staff dept
$("#approvers_wrap").remAddRow({
	addBtn: "#approver_add",
	maxFields: 10,
	removeSelector: ".approver_remove",
	fieldName: "approver",
	rowIdPrefix: "approver",
	// rowTemplate must use the same removeSelector class so delegated handler fires:
	rowTemplate: (i, name) => `
		<div class="col-sm-12 row mt-3 approver" id="approver_${i}">
			<input type="hidden" name="${name}[${i}][id]">
			<div class="form-group col-sm-8 my-1 m-0 row @error('approver.*.nostaf') has-error @enderror">
				<label class="form-label form-label-sm col-sm-4" for="staf_${i}">Staff : </label>
				<div class="col-sm-8">
					<select id="staf_${i}" name="${name}[${i}][nostaf]" class="form-select form-select-sm nostaf {{ ($errors->has('approver.*.nostaf')?'is-invalid':NULL) }}" ></select>
					@error('approver.*.nostaf')
						<div class="invalid-feedback text-sm" id="staf_${i}">{{ $message }}</div>
					@enderror
				</div>
			</div>
			<div class="form-group col-sm-8 my-1 m-0 row @error('approver.*.kod_jabatan') has-error @enderror">
				<label class="form-label form-label-sm col-sm-4" for="dep_${i}">Department : </label>
				<div class="col-sm-8">
					<select id="dep_${i}" name="${name}[${i}][kod_jabatan]" class="form-select form-select-sm kod_jabatan @error('approver.*.kod_jabatan') is-invalid @enderror" ></select>
					@error('approver.*.kod_jabatan')
						<div class="invalid-feedback text-sm" id="dep_${i}">{{ $message }}</div>
					@enderror
				</div>
			</div>
			<div class="col-sm-2 m-2 ">
				<button type="button" class="btn btn-sm btn-danger remove_approver approver_remove">
					<i class="fa-regular fa-trash-can"></i>
				</button>
			</div>
		</div>
	`,
	onAdd: (i, $r) => {
		// console.log('Approver added', i, $r);
		populatestaffdept();
	},
	onRemove: (i, event, $row, name) => {
		console.log('Approver removed', i, event, $row)
		event.preventDefault();
		// console.log('Personnel removed', i, event, $row)
		const idv = $row.find(`input[name="${name}[${i}][id]"]`).val();
		if (!idv) {
			$row.remove();
			return;
		}
	}
});

/////////////////////////////////////////////////////////////////////////////////////////
// restore old value
const oldnostafdept = @json(old('approver', @$itemsArray))??[];
if (oldnostafdept.length > 0) {
	oldnostafdept.forEach(function (jrnl, i) {
		$("#approver_add").trigger('click');

		const $row = $("#approvers_wrap").children().eq(i);

		const $nostaf = $row.find(`[name="approver[${i}][nostaf]"]`);
		const $kod_jabatan = $row.find(`[name="approver[${i}][kod_jabatan]"]`);

		if (jrnl.nostaf) {
			$.ajax({
				url: `{{ route('liststaff') }}`,
				data: {
					_token: '{!! csrf_token() !!}',
					nostaf: jrnl.nostaf,
				},
				dataType: 'json'
			}).then(data => {
				const itema = Array.isArray(data) ? data[0] : data;	// change object to array
				if (!itema) return;
				console.log(itema, itema.results[0].children[0].id);
				const option1 = new Option(itema.results[0].children[0].text, itema.results[0].children[0].id, true, true);
				$nostaf.append(option1).trigger('change');
			});
		}

		if (jrnl.kod_jabatan) {
			$.ajax({
				url: `{{ route('listjabatan') }}`,
				data: {
					_token: '{!! csrf_token() !!}',
					kodjabatan: jrnl.kod_jabatan,
				},
				dataType: 'json'
			}).then(data => {
				const itema = Array.isArray(data) ? data[0] : data;	// change object to array
				if (!itema) return;
				console.log(itema, itema.results[0].children[0].id);
				const option1 = new Option(itema.results[0].children[0].text, itema.results[0].children[0].id, true, true);
				$kod_jabatan.append(option1).trigger('change');
			});
		}

		$row.find(`[name="approver[${i}][id]"]`).val(jrnl.id || '');
	});
}

/////////////////////////////////////////////////////////////////////////////////////////
@endsection
</x-app-layout>
