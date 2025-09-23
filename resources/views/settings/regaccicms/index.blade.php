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
					<th>Sokongan</th>
					<th>Status</th>
					<th>#</th>
				</tr>
			</thead>
			<tbody>
				@if($regaccicms->count())
					@foreach($regaccicms as $regaccicm)

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
								<td>
									<table>
										<thead>
											<tr>
												<th>KPB</th>
												<th>Sokongan</th>
												<th>Tarikh</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>{{ $regaccicm?->belongstoappr->nama }}</td>
												<td>{{ $regaccicm->belongstoapproverstatus?->status_approval }}</td>
												<td>{{ ($regaccicm->approver_date)?\Carbon\Carbon::parse($regaccicm->approver_date)->format('j M Y'):NULL }}</td>
											</tr>
										</tbody>
									</table>
								</td>
								<td>{{ $regaccicm->belongstostatusapp?->status_loan }}</td>
								<td>
									<x-link href="{{ route('btmicmsrequester.show', $regaccicm->id) }}" class="btn btn-primary btn-sm" title="PDF" target="_blank">
										<i class="fa-regular fa-file-pdf"></i>
									</x-link>
									@if((is_null($regaccicm->btm_approver) && is_null($regaccicm->btm_date)))
										<x-link href="{{ route('btmicmsrequester.edit', $regaccicm->id) }}" class="btn btn-primary btn-sm" title="Edit">
											<i class="fa-regular fa-pen-to-square"></i>
										</x-link>
										<x-danger-button type="button" class="delete_email" data-id="{{ $regaccicm->id }}" title="Delete">
											<i class="fa-regular fa-trash-can"></i>
										</x-danger-button>
									@endif
								</td>
							</tr>
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
		url: '{{ url('api/regaccappsapprv') }}' + '/' + ids,
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
		title: 'Delete Registeration Account ICMS Application',
		text: 'Are you sure to delete Registeration Account ICMS Application?',
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
					url: '{{ url('btmicmsrequester') }}' + '/' + ackID,
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
			swal.fire('Cancel Action', 'Registeration Account ICMS Application is still active.', 'info')
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
