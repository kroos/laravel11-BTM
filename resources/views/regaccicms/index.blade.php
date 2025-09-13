<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('BTM02 - PENDAFTARAN AKAUN & MODUL ICMS') }}
		</h2>
	</x-slot>
	<div class="col-sm-12">
		<x-link class="btn btn-sm btn-primary m-3 active" href="{{ route('regaccicms.create') }}">
			MOHON
		</x-link>
	</div>
	<div class="col-sm-12 table-responsive">
		<table class="table table-hover table-sm" id="regaccicms" style="font: 12px montserrat;">
			<thead>
				<tr>
					<th>No. Ruj</th>
					<th>Tarikh Pohon</th>
					<th>Pemohon</th>
					<th>Status</th>
					<th>#</th>
				</tr>
			</thead>
			<tbody>
				@if($regaccicms->count())
					@foreach($regaccicms as $regaccicm)

						@if((\Auth::user()->nostaf == $regaccicm->nostaf) && ($regaccicm->status_request_id == 3))
							<tr>
								<td>
									BTM-RAICMS-{{ \Carbon\Carbon::parse($regaccicm->created_at)->format('ym').str_pad( $regaccicm->id, 3, "0", STR_PAD_LEFT) }}
								</td>
								<td>{{ \Carbon\Carbon::parse($regaccicm->created_at)->format('j M Y') }}</td>
								<td>
									<table class="table table-hover table-sm" id="regaccicms" style="font: 12px montserrat;">
										<thead>
											<tr>
												<th>Nama</th>
												<th>No Staff</th>
												<th>Jawatan</th>
											</tr>
										</thead>
										<tbody>
											@foreach($regaccicm->hasmanyapplicant()->get() as $v1)
											<tr>
												<td>{{ $v1->belongstoicmsapplicant->nama }}</td>
												<td>{{ $v1->nostaf }}</td>
												<td>{{ $v1->position }}</td>
											</tr>
											@endforeach
										</tbody>
									</table>
								</td>
								<td>{{ $regaccicm->belongstostatusrequest->status_loan }}</td>
								<td>
									<x-link href="{{ route('regaccicms.show', $regaccicm->id) }}" class="btn btn-primary btn-sm" title="PDF" target="_blank">
										<i class="fa-regular fa-file-pdf"></i>
									</x-link>
									@if((is_null($regaccicm->approver_staff) && is_null($regaccicm->approver_date)) && (is_null($regaccicm->btm_approver) && is_null($regaccicm->btm_date)))
										<x-link href="{{ route('regaccicms.edit', $regaccicm->id) }}" class="btn btn-primary btn-sm" title="Edit">
											<i class="fa-regular fa-pen-to-square"></i>
										</x-link>
										<x-danger-button type="button" class="delete_email" data-id="{{ $regaccicm->id }}" title="Delete">
											<i class="fa-regular fa-trash-can"></i>
										</x-danger-button>
									@endif
								</td>
							</tr>
						@elseif(request()->user()->isDeptApprover())
							<?php
								$deptapprvs = \Auth::user()->belongstostaff->belongstomanydeptappr()->get();
								$m = [];
								foreach ($deptapprvs as $deptapprv) {
									$m[] = $deptapprv->kodjabatan;
								}
								$stafs = \App\Models\Staff::find($regaccicm->nostaf);
								$stafdepts = $stafs->belongstomanydepartment()->first()->kodjabatan;

								// find the same between session and url
								$stafdeptapprv = in_array($stafdepts, $m);
							?>
							@if($stafdeptapprv)
								<tr>
									<td>BTM-RAICMS-{{ \Carbon\Carbon::parse($regaccicm->created_at)->format('ym').str_pad( $regaccicm->id, 3, "0", STR_PAD_LEFT) }}</td>
									<td>{{ \Carbon\Carbon::parse($regaccicm->created_at)->format('j M Y') }}</td>
									<td>
										<table class="table table-hover table-sm" id="regaccicms" style="font: 12px montserrat;">
											<thead>
												<tr>
													<th>Nama</th>
													<th>No Staff</th>
													<th>Jawatan</th>
												</tr>
											</thead>
											<tbody>
												@foreach($regaccicm->hasmanyapplicant()->get() as $v1)
												<tr>
													<td>{{ $v1->belongstoicmsapplicant->nama }}</td>
													<td>{{ $v1->nostaf }}</td>
													<td>{{ $v1->position }}</td>
												</tr>
												@endforeach
											</tbody>
										</table>
									</td>
									<td>{{ $regaccicm->belongstostatusrequest->status_loan }}</td>
									<td>
										<x-link href="{{ route('regaccicms.show', $regaccicm->id) }}" class="btn btn-primary btn-sm" title="PDF" target="_blank">
											<i class="fa-regular fa-file-pdf"></i>
										</x-link>
										@if((is_null($regaccicm->approver_staff) && is_null($regaccicm->approver_date)) && (is_null($regaccicm->btm_approver) && is_null($regaccicm->btm_date)))
											<x-link href="{{ route('regaccicms.edit', $regaccicm->id) }}" class="btn btn-primary btn-sm" title="Edit">
												<i class="fa-regular fa-pen-to-square"></i>
											</x-link>
											<x-primary-button type="button" class="approval" title="Approval" data-bs-toggle="modal" data-bs-target="#apprv{{ $regaccicm->id }}">
												<i class="fa-solid fa-person-circle-check"></i>
											</x-primary-button>
											<!-- Modal -->
											<div class="modal fade" id="apprv{{ $regaccicm->id }}" tabindex="-1" aria-labelledby="label_{{ $regaccicm->id }}" aria-hidden="true">
												<div class="modal-dialog modal-lg">
													<form action="{{ route('emailappsapprv', $regaccicm->id) }}" method="PATCH" class="form" data-id="{{ $regaccicm->id }}">
														@csrf
													<div class="modal-content">
														<div class="modal-header">
															<h1 class="modal-title fs-5" id="label_{{ $regaccicm->id }}">HOD/Director/Dean Approval</h1>
															<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
														</div>
														<div class="modal-body">
															<div class="col-sm-12 m-0 p-1">
																<fieldset>
																	@foreach(\App\Models\StatusApproval::get() as $v)
																		<div class="form-check">
																			<input name="status" class="form-check-input" type="radio" id="rd_{{ $regaccicm->id }}_{{ $v->id }}" value="{{ $v->id }}">
																			<label class="form-check-label" for="rd_{{ $regaccicm->id }}_{{ $v->id }}">
																				{{ $v->status_approval }}
																			</label>
																		</div>
																	@endforeach
																</fieldset>
																<div class="col-sm-12 m-2 row">
																	<x-input-label for="txtareaid{{ $regaccicm->id }}" class="col-sm-4" :value="__('Remarks : ')" />
																	<div class="col-sm-8">
																		<x-textarea-input id="txtareaid{{ $regaccicm->id }}" name="remarks_approver" class="{{ ($errors->has('nostaf')?'is-invalid':NULL) }}" />
																		<x-input-error :messages="$errors->get('nostaf')" />
																	</div>
																</div>
																<div class="form-check">
																	<input name="acknowledge" class="form-check-input {{ ($errors->has('acknowledge')?'is-invalid':NULL) }}" type="checkbox" value="true" id="cb_{{ $regaccicm->id }}">
																	<label class="form-check-label text-sm fs-6 fw-bolder" for="cb_{{ $regaccicm->id }}">
																		I hereby confirm that the loaned equipment is intended for official purposes.
																	</label>
																	<x-input-error :messages="$errors->get('acknowledge')" />
																</div>
															</div>
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
															<button type="submit" class="btn btn-sm btn-primary">Save changes</button>
														</div>
													</div>
												</form>
												</div>
											</div>
											<x-danger-button type="button" class="delete_email" data-id="{{ $regaccicm->id }}" title="Delete">
												<i class="fa-regular fa-trash-can"></i>
											</x-danger-button>
										@endif
									</td>
								</tr>
							@endif
						@endif
					@endforeach
				@endif
			</tbody>
		</table>
	</div>

@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
// datatables
DataTable.datetime( 'D MMM YYYY' );
DataTable.datetime( 'YYYY' );
DataTable.datetime( 'h:mm a' );
$('#regaccicms').DataTable({
	"lengthMenu": [ [30, 60, 100, -1], [30, 60, 100, "All"] ],
	"columnDefs": [
		{ type: 'date', 'targets': [1] },
	],
	"order": [[ 1, 'desc' ]],
	"responsive": true,
	"autoWidth": false,
	"fixedHeader": true,
	"dom": 'Bfrtip',
})
.on( 'length.dt page.dt order.dt search.dt', function ( e, settings, len ) {
	$(document).ready(function(){
		$('[data-bs-toggle="tooltip"]').tooltip();
	});
});

/////////////////////////////////////////////////////////////////////////////////////////
// form submit via ajax
$(".form").on('submit', function(e){
	var ids = $(this).data('id');
	e.preventDefault();
	$.ajax({
		url: '{{ url('api/emailappapprv') }}' + '/' + ids,
		type: 'PATCH',
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
		data: {
				_token: '{!! csrf_token() !!}',
				id: ids,
				approver_staff: '{{ \Auth::user()->nostaf }}',
				// acknowledge: $(':input[name="leave_status_id"]:checked').val(),
				acknowledge: $(':input[name="acknowledge"]:checked').val(),
				status: $(':input[name="status"]:checked').val(),
				remarks_approver: $(':input[name="remarks_approver"]').val()
		},
		dataType: 'json',
		global: false,
		async:false,
		success: function (response) {
			$('#apprv' + ids).modal('hide');
			var row = $('#apprv' + ids).parent().parent();
			// row.css('border', '5px solid red');
			row.remove();
			swal.fire('Success!', response.message, response.status);
		},
		error: function(resp) {
			const res = resp.responseJSON;
			$('#apprv' + ids).modal('hide');
			// swal.fire('Info', res.message,'info');

			// Extract the errors and concatenate them into a string
			const errorMessages = Object.values(res.errors)
					.flat() // Flatten the arrays
					.join('<br>'); // Join them with line breaks for better formatting

			// Display the errors using SweetAlert2
			swal.fire({
					title: 'Info',
					html: errorMessages, // Use `html` to render the line breaks
					icon: 'info'
			});
		}
	});
});

/////////////////////////////////////////////////////////////////////////////////////////
$(document).on('click', '.delete_email', function(e){
	var ackID = $(this).data('id');
	SwalDeleteR(ackID);
	e.preventDefault();
});

function SwalDeleteR(ackID){
	swal.fire({
		title: 'Delete Loan Application',
		text: 'Are you sure to delete Email Registration Application?',
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
					url: '{{ url('regaccicms') }}' + '/' + ackID,
					type: 'DELETE',
					dataType: 'json',
					data: {
							id: ackID,
							_token : $('meta[name=csrf-token]').attr('content'),
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
					// swal.fire('Oops...', 'Something went wrong with ajax !', 'error');
					swal.fire('Unauthorised', 'Error 401 : Unauthorised Action!', 'error');
				})
			});
		},
		allowOutsideClick: false
	})
	.then((result) => {
		if (result.dismiss === swal.DismissReason.cancel) {
			swal.fire('Cancel Action', 'Email Registration Application is still active.', 'info')
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
