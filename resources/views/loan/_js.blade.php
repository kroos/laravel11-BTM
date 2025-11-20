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

function preventDuplicateSelection() {
	// Gather all selected equipment IDs
	let selected = [];
	$("select[id^='equip_']").each(function() {
		let val = $(this).val();
		if (val) selected.push(val);
	});

	// Loop through each dropdown and strip out already-selected options
	$("select[id^='equip_']").each(function() {
		let currentVal = $(this).val();
		let $select = $(this);

		$select.find("option").each(function() {
			let optVal = $(this).val();

			// always keep placeholder and current value
			if (optVal === "" || optVal === currentVal) return;

			if (selected.includes(optVal)) {
				$(this).remove();
			}
		});
	});
}

/////////////////////////////////////////////////////////////////////////////////////////
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

/////////////////////////////////////////////////////////////////////////////////////////
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
					// 🔥 Remove already-selected equipment from this dropdown
					preventDuplicateSelection();
				}
			});
		}
	});

	// Update the description when equipment is changed
	updateDescription(equipmentSelector, descriptionSelector);

	// Prevent duplicates when equipment changes
	$(equipmentSelector).on("change", function () {
		preventDuplicateSelection();
	});
}

/////////////////////////////////////////////////////////////////////////////////////////
// add remove row
$("#equipments_wraps").remAddRow({
	addBtn: "#equipments_add",
	maxFields: 10,
	removeSelector: ".equipment_remove",
	fieldName: "equipments",
	rowIdPrefix: "equipment",
	// rowTemplate must use the same removeSelector class so delegated handler fires:
	rowTemplate: (i, name) => `
		<div class="col-sm-12 row mt-3" id="equipment_${i}">
			<input type="hidden" name="${name}[${i}][id]" value="">
			<div class="col-sm-11 m-0 row">
				<label for="catequip_${i}" class="form-label form-label-sm col-sm-4">Category : </label>
				<div class="col-sm-8">
					<select id="catequip_${i}" name="${name}[${i}][category_id]" class="form-control"></select>
				</div>
			</div>
			<div class="col-sm-11 m-0 row @error('equipments.*.equipment_id') has-error @enderror">
				<label class="form-label form-label-sm col-sm-4" for="equip_${i}">Equipment :</label>
				<div class="col-sm-8 @error('equipments.*.equipment_id') is-invalid @enderror">
					<select id="equip_${i}" name="${name}[${i}][equipment_id]" class="form-select form-select-sm @error('equipments.*.equipment_id') is-invalid @enderror"></select>
				</div>
					@error('equipments.*.equipment_id')
					<div class="invalid-feedback">{{ $message }}</div>
					@enderror
			</div>
			<div class="col-sm-1 m-0">
				<button type="button" class="btn btn-sm btn-danger equipment_remove" data-id="${i}">
					<i class="fa-regular fa-trash-can"></i>
				</button>
			</div>
			<div class="col-sm-12 m-0" id="desc_${i}">
				<div id="desc_wrap_${i}">
					<p>Brand :<br/>
					Model :<br/>
					Serial Number :<br/>
					Description :</p>
				</div>
			</div>
		</div>
	`,
	onAdd: (i, $r) => {
		// console.log('Equipment added', i, $r);
		initializeChainedSelects(i);
	},
	onRemove: (i, event, $row, name) => {
		// console.log('Equipment removed', i, event, $row)
		event.preventDefault();
		// console.log('Personnel removed', i, event, $row)
		const idv = $row.find(`select[name="${name}[${i}][id]"]`).val();
		if (!idv) {
			$row.remove();
			return;
		}
		swal.fire({
			title: 'Delete email suggestion?',
			text: 'This action cannot be undone.',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#d33',
			confirmButtonText: 'Yes, delete it!'
		}).then(result => {
			if (result.isConfirmed) {
				$.ajax({
					url: `{{ url('emailsuggestion') }}/${idv}`,
					type: 'DELETE',
					data: { _token: $('meta[name="csrf-token"]').attr('content') },
					success: response => {
						swal.fire('Deleted!', response.message, 'success');
						$row.remove();  // remove only after DB deletion
					},
					error: xhr => {
						swal.fire('Error', 'Failed to delete email suggestion', 'error');
					}
				});
			}
		});
	}
});

/////////////////////////////////////////////////////////////////////////////////////////
// restore old data
@php
	$itemsa = @$loanapp?->hasmanyequipments()?->get(['id', 'category_id', 'equipment_id']);
	$itemsArrayb = $itemsa?->toArray()??[];
	$oldItemsValuec = old('equipments', $itemsArrayb);
	//  dd($oldItemsValuec);
@endphp
const oldEquipments = @json($oldItemsValuec);
if (oldEquipments.length > 0) {
	oldEquipments.forEach(function (gema, i) {
		$("#equipments_add").trigger('click');

		const $row = $("#equipments_wraps").children().eq(i);

		const $account_id = $row.find(`select[name="equipments[${i}][category_id]"]`);
		const $ledger_id = $row.find(`select[name="equipments[${i}][equipment_id]"]`);

		if (gema.category_id) {
			$.ajax({
				url: CATEGORY_API,
				data: {
					_token: $('meta[name="csrf-token"]').attr('content'),
					id: gema.category_id,
				},
				dataType: 'json'
			}).then(data => {
				const itema = Array.isArray(data) ? data[0] : data;	// change object to array
				if (!itema) return;
				const option1 = new Option(itema.cat, itema.id, true, true);
				$account_id.append(option1).trigger('change');
			});
		}

		if (gema.equipment_id) {
			$.ajax({
				url: EQUIPMENT_API,
				data: {
					_token: $('meta[name="csrf-token"]').attr('content'),
					id: gema.equipment_id,
				},
				dataType: 'json'
			}).then(data => {
				// const [name, email] = Object.entries(data[0])[0];
				const obj = Object.entries(data);
				// console.log(obj[0][1][0].children[0].id, obj[0][1][0].children[0].text);

				const option2 = new Option(obj[0][1][0].children[0].text, obj[0][1][0].children[0].id, true, true);
				$ledger_id.append(option2).trigger('change');
			});
		}

		$row.find(`input[name="equipments[${i}][id]"]`).val(gema.id || '');
	});
}

/////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////
