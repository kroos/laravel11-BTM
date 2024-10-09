<x-app-layout>

	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Add Approver') }}
		</h2>
	</x-slot>

	<div class="table-responsive align-items-center">
		<table class="table table-sm table-hover table-border" id="approver">
			<thead>
				<tr>
					<th>ID</th>
					<th>Approver</th>
					<th>Department</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@if($apprs->count() > 0)
				@foreach($apprs as $appr)
				<tr>
					<td>{{ $appr->belongstoappr->nostaf }}</td>
					<td>{{ $appr->belongstoappr->nama }}</td>
					<td>{{ $appr->belongstodeptappr->namajabatan }}</td>
					<td>1</td>
				</tr>
				@endforeach
				@endif
			</tbody>
		</table>
	</div>


@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
$(document).on('click', '.rapprover_btn', function(e){
	var ackID = $(this).data('id');
	SwalDeleteR(ackID);
	e.preventDefault();
});

function SwalDeleteR(ackID){
	swal.fire({
		title: 'Approve Leave',
		text: 'Are you sure to approve this leave?',
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
					url: '{{ url('leaverapprove') }}' + '/' + ackID,
					type: 'PATCH',
					dataType: 'json',
					data: {
							id: ackID,
							cancel: 3,
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
				})
			});
		},
		allowOutsideClick: false
	})
	.then((result) => {
		if (result.dismiss === swal.DismissReason.cancel) {
			swal.fire('Cancel Action', 'Leave is still active.', 'info')
		}
	});
}
//auto refresh right after clicking OK button
$(document).on('click', '.swal2-confirm', function(e){
	window.location.reload(true);
});

/////////////////////////////////////////////////////////////////////////////////////////
// datatables
$.fn.dataTable.moment( 'D MMM YYYY' );
$.fn.dataTable.moment( 'D MMM YYYY h:mm a' );
$('#approver').DataTable({
	"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
	"columnDefs": [ { type: 'date', 'targets': [1] } ],
	"order": [[1, "desc" ]],	// sorting the 1th column descending
	responsive: true
})
.on( 'length.dt page.dt order.dt search.dt', function ( e, settings, len ) {
	$(document).ready(function(){
		$('[data-bs-toggle="tooltip"]').tooltip();
	});}
);



@endsection
</x-app-layout>
