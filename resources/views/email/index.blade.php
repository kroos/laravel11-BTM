<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Email Registration List') }}
		</h2>
	</x-slot>
	<div class="col-sm-12">
		<x-link class="btn btn-sm btn-primary m-3 active" href="{{ route('emailaccapp.create') }}">
			Email Registration Application
		</x-link>
	</div>
	<div class="col-sm-12 table-responsive">
		<table class="table table-hover table-sm" id="loanapp" style="font: 12px sans-serif;">
			<thead>
				<tr>
					<th>Reg No</th>
					<th>Name</th>
					<th>Apply On</th>
					<th>Loan From</th>
					<th>Loan To</th>
					<th>Equipments Pick Up On</th>
					<th>Equipments</th>
					<th>HOD Approval</th>
					<th>Loan Status</th>
					<th>#</th>
				</tr>
			</thead>
			<tbody>
				@if($emails->count())
					@foreach($emails as $email)

					@endforeach
				@endif
			</tbody>
		</table>
	</div>

@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
// datatables
$.fn.dataTable.moment( 'D MMM YYYY' );
$.fn.dataTable.moment( 'YYYY' );
$.fn.dataTable.moment( 'h:mm a' );
$('#loanapp').DataTable({
	"lengthMenu": [ [30, 60, 100, -1], [30, 60, 100, "All"] ],
	"columnDefs": [
		{ type: 'date', 'targets': [2,3] },
	],
	"order": [[ 2, 'desc' ]],
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
		url: '{{ url('api/loanappapprv') }}' + '/' + ids,
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
$(document).on('click', '.delete_loan', function(e){
	var ackID = $(this).data('id');
	SwalDeleteR(ackID);
	e.preventDefault();
});

function SwalDeleteR(ackID){
	swal.fire({
		title: 'Delete Loan Application',
		text: 'Are you sure to delete Loan Application?',
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
					url: '{{ url('loanapp') }}' + '/' + ackID,
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
			swal.fire('Cancel Action', 'Loan Application is still active.', 'info')
		}
	});
}
//auto refresh right after clicking OK button
$(document).on('click', '.swal2-confirm', function(e){
	window.location.reload(true);
});

/////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////
@endsection
</x-app-layout>
