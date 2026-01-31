/////////////////////////////////////////////////////////////////////////////////////////
// ajax category
// URLs for API
const CATEGORY_API = "{{ route('listcategory') }}";
const EQUIPMENT_API = "{{ route('equipmentstatus') }}";
const DESCRIPTION_API = "{{ route('equipmentdescription') }}";

/////////////////////////////////////////////////////////////////////////////////////////
// datepicker
$('#dafrom').datepicker({
	dateFormat: 'yy-mm-dd',
	// minDate: 3,
	//disable friday and saturday
	beforeShowDay: function(d) {
		return [!(d.getDay()==5||d.getDay()==6)]
	},
}).on('change', function() {
	$('#dato').datepicker('option', 'minDate', this.value);
});

$('#dato').datepicker({
	dateFormat: 'yy-mm-dd',
	// minDate: 3,
	//disable friday and saturday
	beforeShowDay: function(d) {
		return [!(d.getDay()==5 || d.getDay()==6)]
	}
}).on('change', function() {
	$('#dafrom').datepicker('option', 'maxDate', this.value);
});

/////////////////////////////////////////////////////////////////////////////////////////
// add item

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

	$('#take_' + counter + '').datepicker({
		dateFormat: 'yy-mm-dd',
		//disable friday and saturday
		beforeShowDay: function(d) {
			return [!(d.getDay()==5||d.getDay()==6)]
		},
	});

	$('#return_' + counter + '').datepicker({
		dateFormat: 'yy-mm-dd',
		//disable friday and saturday
		beforeShowDay: function(d) {
			return [!(d.getDay()==5||d.getDay()==6)]
		},
	});

	$('#status_' + counter + '').select2({
		placeholder: 'Please Choose',
		width: '100%',
		allowClear: true,
		closeOnSelect: true,
		ajax: {
			url: '{{ route('status') }}',
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
	});

	// Update the description when equipment is changed
	updateDescription(equipmentSelector, descriptionSelector);
}

$("#equipments_wrap").addRemRow({
	addBtn: "#equipments_add",
	maxFields: 20,
	removeClass: "equipments_remove",
	fieldName: "lequ",
	rowSelector: "loans",
	rowTemplate: (i, name) => `
		<div class="col-sm-12 row mt-3 loans" id="loans_${i}">
			<!-- equipment -->
			<div class="form-group col-sm-11 m-0 row @error('lequ.*.category_id') has-error @enderror">
				<input type="hidden" name="${name}[${i}][id]" value="">
				<input type="hidden" name="${name}[${i}][application_id]" value="">
				<label for="catequip_${i}" class="col-form-label col-sm-4">Equipment Category : </label>
				<div class="col-sm-8 my-auto">
					<select id="catequip_${i}" name="${name}[${i}][category_id]" class="form-select form-select-sm @error('lequ.*.category_id') is-invalid @enderror" palceholder="Please Choose"></select>
					@error('lequ.*.category_id')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
					@enderror
				</div>
			</div>
			<div class="form-group col-sm-11 m-0 row @error('lequ.*.equipment_id') has-error @enderror">
				<label class="form-label form-label-sm col-sm-4" for="equip_${i}">Equipment :</label>
				<div class="col-sm-8 my-auto">
					<select id="equip_${i}" name="${name}[${i}][equipment_id]" class="form-select form-select-sm @error('lequ.*.equipment_id') is-invalid @enderror" palceholder="Please Choose"></select>
					@error('lequ.*.equipment_id')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
					@enderror
				</div>
			</div>
			<!-- remove button -->
			<div class="col-sm-1 m-0">
				<button type="button" class="btn btn-sm btn-danger equipments_remove" data-id="${i}">
					<i class="fa-regular fa-trash-can"></i>
				</button>
			</div>
			<!-- equipment description -->
			<div class="col-sm-12 m-0" id="desc_${i}">
				<div id="desc_wrap_${i}">
					<p>Brand :</br>
					Model :</br>
					Serial Number :</br>
					Description :</p>
				</div>
			</div>

			<div class="form-group col-sm-12 mt-2 row @error('lequ.*.taken_on') has-error @enderror">
				<label for="take_${i}" class="col-form-label col-sm-4">Taken On : </label>
				<div class="col-sm-8">
					<input type="text" id="take_${i}" name="${name}\[${i}\][taken_on]" value="" class="form-control form-control-sm @error('lequ.*.taken_on') is-invalid @enderror"/>
					@error('lequ.*.equipment_id')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
					@enderror
				</div>
			</div>
			<div class="form-group col-sm-12 mt-2 row @error('lequ.*.return_on') has-error @enderror">
				<label for="return_${i}" class="col-form-label col-sm-4">Return On : </label>
				<div class="col-sm-8">
					<input type="type" id="return_${i}" name="${name}[${i}][return_on]" value="" class="form-control form-control-sm @error('lequ.*.return_on') is-invalid @enderror "/>
					@error('lequ.*.return_on')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
					@enderror
				</div>
			</div>
			<div class="form -group col-sm-12 mt-2 row @error('lequ.*.status_item_id') has-error @enderror">
				<label for="status_${i}" class="col-sm-4">Status Item After Return : </label>
				<div class="col-sm-8 my-auto">
					<select name="${name}[${i}][status_item_id]" id="status_${i}" class="form-select form-select-sm @error('lequ.*.status_item_id') is-invalid @enderror"></select>
					@error('lequ.*.status_item_id')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
					@enderror
				</div>
			</div>
			<div class="form -group
		@error('lequ.*.status_condition_remarks') has-error @enderror col-sm-12 mt-2 row">
				<label for="remarks_${i}" class="col-form-label col-sm-4">Remarks : </label>
				<div class="col-sm-8">
					<textarea id="remarks_${i}" name="${name}[${i}][status_condition_remarks]" value="" class="form-control form-control-sm @error('lequ.*.status_condition_remarks') is-invalid @enderror"></textarea>
					@error('lequ.*.status_condition_remarks')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
					@enderror
				</div>
			</div>
		</div>
	`,
	onAdd: (i, event, $r , name) => {
		// console.log('Equipmwnts added', i, $r)

		// Initialize the chained selects and description updater for the new set
		initializeChainedSelects(i);
	},
	onRemove: async (i, event, $row, name) => {
		const idv = $row.find(`input[name="${name}[${i}][id]"]`).val();
		if (!idv) {
			return true;
		}

		let url = `{{ url('loanequipments') }}`;
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
<?php
$items = @$loanapp->hasmanyequipments()?->get()
										->toArray() ?? [];

$oldItemsValue = old('lequ', $items);
// dd($items, $oldItemsValue);
?>
const oldICMSGroup = @json($oldItemsValue);
if (oldICMSGroup.length > 0) {
	oldICMSGroup.forEach(function (loaneq, i) {
		$("#equipments_add").trigger('click');
		const $row = $("#equipments_wrap").children().eq(i);

		const $category_id = $row.find(`[name="lequ[${i}][category_id]"]`);
		if (loaneq.category_id) {
			$.ajax({
				url: CATEGORY_API,
				data: {
					_token: '{!! csrf_token() !!}',
					id: loaneq.category_id,
				},
				dataType: 'json'
			}).then(data => {
				const itema = Array.isArray(data) ? data[0] : data;	// change object to array
				if (!itema) return;
				// console.log(itema, itema.id, itema.cat);
				const option1 = new Option(itema.cat, itema.id, true, true);
				$category_id.append(option1).trigger('change');
			});
		}

		const $equipment_id = $row.find(`[name="lequ[${i}][equipment_id]"]`);
		if (loaneq.equipment_id) {
			$.ajax({
				url: EQUIPMENT_API,
				data: {
					_token: '{!! csrf_token() !!}',
					id: loaneq.equipment_id,
				},
				dataType: 'json'
			}).then(data => {
				const itema = Array.isArray(data) ? data[0] : data;	// change object to array
				if (!itema) return;
				// console.log(itema.results[0].children[0].text);
				const option2 = new Option(itema.results[0].children[0].text, itema.results[0].children[0].id, true, true);
				$equipment_id.append(option2).trigger('change');
			});
		}

		const $status_item_id = $row.find(`[name="lequ[${i}][status_item_id]"]`);
		// $status_item_id.parent().css({"color": "red", "border": "2px solid red"});
		if (loaneq.status_item_id) {
			$.ajax({
				url: '{{ route('status') }}',
				data: {
					_token: '{!! csrf_token() !!}',
					id: loaneq.status_item_id,
				},
				dataType: 'json'
			}).then(data => {
				const itemc = Array.isArray(data) ? data[0] : data;	// change object to array
				if (!itemc) return;
				console.log(itemc);
				const option3 = new Option(itemc.results[0].children[0].text, itemc.results[0].children[0].id, true, true);
				$status_item_id.append(option3).trigger('change');
			});
		}

		$row.find(`[name="lequ[${i}][id]"]`).val(loaneq.id || '');
		$row.find(`[name="lequ[${i}][application_id]"]`).val(loaneq.application_id || '');
		$row.find(`[name="lequ[${i}][taken_on]"]`).val(loaneq.taken_on || '');
		$row.find(`[name="lequ[${i}][return_on]"]`).val(loaneq.return_on || '');
		$row.find(`[name="lequ[${i}][status_condition_remarks]"]`).val(loaneq.status_condition_remarks || '');
	});
}

/////////////////////////////////////////////////////////////////////////////////////////
