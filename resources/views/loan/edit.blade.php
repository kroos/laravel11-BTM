<x-app-layout>

	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Equipment Loan Application Form') }}
		</h2>
	</x-slot>

	<form action="{{ route('loanapps.update', $loanapp->id) }}" method="POST">
			@csrf
			@method('PATCH')
		<div class="container row justify-content-between">
			<!-- 1st column -->
			<div class="col-sm-6 m-0 p-1">
				<h3>Applicant</h3>
				<!-- staff id -->
				<div class="col-sm-12 mt-2 row">
					<x-input-label for="id" class="col-sm-4" :value="__('Staff ID : ')" />
					<div class="col-sm-8">
						<x-text-input id="id" name="nostaf" value="{{ $loanapp->nostaf }}" class="{{ ($errors->has('nostaf')?'is-invalid':NULL) }}" readonly />
						<x-input-error :messages="$errors->get('nostaf')" />
					</div>
				</div>

				<!-- staff name -->
				<div class="col-sm-12 mt-2 row">
					<x-input-label for="staf" class="col-sm-4" :value="__('Staff : ')" />
					<div class="col-sm-8">
						<x-text-input id="staf" name="nama" value="{{ $loanapp->belongstostaff->nama }}" class="{{ ($errors->has('nama')?'is-invalid':NULL) }}" readonly />
						<x-input-error :messages="$errors->get('nama')" />
					</div>
				</div>

				<!-- date loan -->
				<div class="col-sm-12 mt-2 row">
					<x-input-label for="dafrom" class="col-sm-4" :value="__('Date From : ')" />
					<div class="col-sm-8">
						<x-text-input id="dafrom" name="date_loan_from" value="{{ \Carbon\Carbon::parse($loanapp->date_loan_from)->format('Y-m-d') }}" class="{{ ($errors->has('date_loan_from')?'is-invalid':NULL) }}"  />
						<x-input-error :messages="$errors->get('date_loan_from')" />
					</div>
				</div>

				<!-- date loan -->
				<div class="col-sm-12 mt-2 row">
					<x-input-label for="dato" class="col-sm-4" :value="__('Date To : ')" />
					<div class="col-sm-8">
						<x-text-input id="dato" name="date_loan_to" value="{{ \Carbon\Carbon::parse($loanapp->date_loan_to)->format('Y-m-d') }}" class="{{ ($errors->has('date_loan_from')?'is-invalid':NULL) }}"  />
						<x-input-error :messages="$errors->get('date_loan_to')" />
					</div>
				</div>

				<!-- purpose -->
				<div class="col-sm-12 mt-2 row">
					<x-input-label for="purp" class="col-sm-4" :value="__('Purpose of Loan : ')" />
					<div class="col-sm-8">
						<textarea name="loan_purpose" class="form-control form-control-sm {{ ($errors->has('date_loan_from')?'is-invalid':NULL) }}" id="purp">{{ $loanapp->loan_purpose }}</textarea>
						<x-input-error :messages="$errors->get('loan_purpose')" />
					</div>
				</div>
			</div>

			<!-- 2nd column -->
			<div class="col-sm-6 m-0 p-1">
				<h3>Equipments</h3>

				@if($loanapp->count())
				<?php
					$i = 0;
				?>
					@foreach($loanapp->hasmanyequipments()->get() as $k)
					<div class="col-sm-12 row mt-3">
						<!-- equipment -->
						<div class="col-sm-11 m-0 row">
							<input type="hidden" name="lequ[{{ $i }}][id]" value="{{ $k->id }}">
							<x-input-label for="equip_{{ $i }}" class="col-sm-4" :value="__('Equipment : ')" />
							<div class="col-sm-8">
								<select id="equip_{{ $i }}" name="lequ[{{ $i }}][equipment_id]" class="{{ ($errors->has('lequ.*.equipment_id')?'is-invalid':NULL) }}" palceholder="Please Choose Equipment"/>
									<!-- must have this to make sure $request catch the data -->
									<option value="">Please Choose Equipment</option>
								</select>
							</div>
						</div>
						<!-- remove button -->
						<div class="col-sm-1 m-0">
							<x-danger-button type="button" class="delete_equipments" data-id="{{ $k->id }}">
								<i class="fa-regular fa-trash-can"></i>
							</x-danger-button>
						</div>

						<!-- equipment description -->
						<div class="col-sm-12 m-0" id="desc_{{ $i }}">
							<div id="desc_wrap_{{ $i }}">
								<p>Brand : {{ $k->belongstoequipment->brand }}</p>
								<p>Model : {{ $k->belongstoequipment->model }}</p>
								<p>Serial Number : {{ $k->belongstoequipment->serial_number }}</p>
								<p>Description : {{ $k->belongstoequipment->description }}</p>
							</div>
						</div>
					</div>
					<?php
						$i++;
					?>
					@endforeach
				@endif

				<div class="wrap_equipments">
				</div>

				<div class="col-sm-12 text-right mt-3">
					<x-primary-button type="button" class="add_equipments">
						<i class="fa-solid fa-screwdriver-wrench fa-beat"></i></i>&nbsp;Add Equipments
					</x-primary-button>
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

			<div class="col-sm-12 m-0 p-1 text-center">
				<x-primary-button type="submit" class="m-2">
					<i class="fa-solid fa-floppy-disk fa-beat"></i>&nbsp;{{ __('Update') }}
				</x-primary-button>
			</div>
		</div>


@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
// ajax category
/////////////////////////////////////////////////////////////////////////////////////////
//enable select 2
@if($loanapp->hasmanyequipments()->count())
	<?php
		$i = 0;
	?>
	@foreach($loanapp->hasmanyequipments()->get() as $t)
			$('#equip_{{ $i }}').select2({
				placeholder: 'Please Choose Equipment',
				width: '100%',
				ajax: {
					url: '{{ route('equipmentstatus') }}',
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
			}).on('change', function(e) {
				$('#desc_wrap_{{ $i }}').remove();
				var id = $("#equip_{{ $i }} option:selected").val();

				var dat1 = $.ajax({
					url: "{{ route('equipmentdescription') }}",
					type: "GET",
					data : { 'id': id },
					dataType: 'json',
					global: false,
					async:false,
					success: function (response) {
						return response;
					},
					error: function(jqXHR, textStatus, errorThrown) {
						console.log(textStatus, errorThrown);
					}
				}).responseText;

				// this is how u cange from json to array type data
				var dat2 = $.parseJSON( dat1 );

					$('#desc_{{ $i }}').append(
									'<div id="desc_wrap_{{ $i }}">' +
										'<p>Brand : '+ dat2.brand +'</p>' +
										'<p>Model : '+ dat2.model +'</p>' +
										'<p>Serial Number : '+ dat2.serial_number +'</p>' +
										'<p>Description : '+ dat2.description +'</p>' +
									'</div>'
					);
			});
			var newOption = new Option('{{ $t->belongstoequipment->item }}', {{ $t->equipment_id }}, true, true);
			$('#equip_{{ $i }}').append(newOption).trigger('change');
		<?php
		$i=1+$i;
		?>
	@endforeach
@endif

/////////////////////////////////////////////////////////////////////////////////////////
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
var apprv_max_fields = 10;						//maximum input boxes allowed
var appr_btn = $(".add_equipments");
var apprv_wrapper = $(".wrap_equipments");

var counter = {{ ($loanapp->hasmanyequipments()->count())?($loanapp->hasmanyequipments()->count() - 1):0 }};
$(appr_btn).click(function(){
	// e.preventDefault();

	//max input box allowed
	if(counter < apprv_max_fields){
		counter++;
		apprv_wrapper.append(
			'<div class="col-sm-12 row mt-3">' +
				'<!-- equipment -->' +
				'<div class="col-sm-11 m-0 row">' +
					'<input type="hidden" name="lequ[' + counter + '][id]" value="">' +
					'<label class="form-label form-label-sm col-sm-4" for="equip_' + counter + '">Equipment :</label>' +
					'<div class="col-sm-8">' +
						'<select id="equip_' + counter + '" name="lequ[' + counter + '][equipment_id]" class="{{ ($errors->has('lequ.*.equipment_id')?'is-invalid':NULL) }}" palceholder="Please Choose Equipment"/>' +
							'<option value="">Please Choose Equipment</option>' +
						'</select>' +
					'</div>' +
				'</div>' +
				'<!-- remove button -->' +
				'<div class="col-sm-1 m-0">' +
					'<button type="button" class="btn btn-sm btn-danger remove_equipments">' +
						'<i class="fa-regular fa-trash-can"></i>' +
					'</button>' +
				'</div>' +
				'<!-- equipment description -->' +
				'<div class="col-sm-12 m-0" id="desc_' + counter + '">' +
					'<div id="desc_wrap_' + counter + '">' +
						'<p>Brand :</p>' +
						'<p>Model :</p>' +
						'<p>Serial Number :</p>' +
						'<p>Description :</p>' +
					'</div>' +
				'</div>' +
			'</div>'
		);

		$('#equip_' + counter + '').select2({
			placeholder: 'Please Choose Equipment',
			width: '100%',
			ajax: {
				url: '{{ route('equipmentstatus') }}',
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
		}).on('change', function(e) {
			$('#desc_wrap_' + counter + '').remove();
			var id = $('#equip_' + counter + ' option:selected').val();

			var dat1 = $.ajax({
				url: "{{ route('equipmentdescription') }}",
				type: "GET",
				data : { 'id': id },
				dataType: 'json',
				global: false,
				async:false,
				success: function (response) {
					return response;
				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(textStatus, errorThrown);
				}
			}).responseText;

			// this is how u cange from json to array type data
			var dat2 = $.parseJSON( dat1 );

				$('#desc_' + counter + '').append(
								'<div id="desc_wrap_' + counter + '">' +
									'<p>Brand : '+ dat2.brand +'</p>' +
									'<p>Model : '+ dat2.model +'</p>' +
									'<p>Serial Number : '+ dat2.serial_number +'</p>' +
									'<p>Description : '+ dat2.description +'</p>' +
								'</div>'
				);
		});

	}
})

$(apprv_wrapper).on("click",".remove_equipments", function(e){
	//user click on remove text
	e.preventDefault();
	var $row = $(this).parent().parent();
	$row.remove();
	counter--;
})

/////////////////////////////////////////////////////////////////////////////////////////
$(document).on('click', '.delete_equipments', function(e){
	var ackID = $(this).data('id');
	SwalDeleteR(ackID);
	e.preventDefault();
});

function SwalDeleteR(ackID){
	swal.fire({
		title: 'Delete Loan Equipment',
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
					url: '{{ url('loanequipments') }}' + '/' + ackID,
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
			swal.fire('Cancel Action', 'Loan Equipment is still active.', 'info')
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
