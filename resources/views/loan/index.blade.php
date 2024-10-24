<x-app-layout>

	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Equipment Status') }}
		</h2>
	</x-slot>
	<div class="col-sm-12">
		<x-link class="btn btn-sm btn-primary m-3 active" href="{{ route('loanapps.create') }}">
			Loan Application
		</x-link>
	</div>
	<div class="col-sm-12 table-responsive">
		<table class="table table-hover table-sm" id="loanapp" style="font: 12px sans-serif;">
			<thead>
				<tr>
					<th>Loan No</th>
					<th>Name</th>
					<th>Apply On</th>
					<th>Loan From</th>
					<th>Loan To</th>
					<th>Equipments Pick Up On</th>
					<th>Equipments</th>
					<th>#</th>
				</tr>
			</thead>
			<tbody>
				@if($loans->count())
					@foreach($loans as $loan)
						<tr>
							<td>BTM-LE-{{ \Carbon\Carbon::parse($loan->created_at)->format('ym').str_pad( $loan->id, 3, "0", STR_PAD_LEFT) }}</td>
							<td>{{ $loan->belongstostaff->nama }}</td>
							<td>{{ \Carbon\Carbon::parse($loan->created_at)->format('j M Y') }}</td>
							<td>{{ \Carbon\Carbon::parse($loan->date_loan_from)->format('j M Y') }}</td>
							<td>{{ \Carbon\Carbon::parse($loan->date_loan_to)->format('j M Y') }}</td>
							<td>
								@if(!is_null($loan->equipment_pickup_date))
									{{ \Carbon\Carbon::parse($loan->equipment_pickup_date)->format('j M Y') }}
								@endif
							</td>
							<td>
								<table class="table table-sm table-hover">
									<thead>
										<tr>
											<th>Equipments</th>
											<th>Status</th>
										</tr>
									</thead>
									<tbody>
<?php
$loaneqs = $loan->hasmanyequipments()->get();
?>
										@if($loaneqs->count())
											@foreach($loaneqs as $loaneq)
												<tr>
													<td>{{ $loaneq->belongstoequipment->item }}</td>
													<td>{{ $loaneq->belongstoequipmentstatus->status_item }}</td>
												</tr>
											@endforeach
										@endif
									</tbody>
								</table>
							</td>
							<td>
								<x-link href="{{ route('loanapps.show', $loan->id) }}" class="btn btn-primary btn-sm" title="PDF">
									<i class="fa-regular fa-file-pdf"></i>
								</x-link>
								<x-link href="{{ route('loanapps.edit', $loan->id) }}" class="btn btn-primary btn-sm" title="Edit">
									<i class="fa-regular fa-pen-to-square"></i>
								</x-link>
								<x-danger-button type="button" class="delete_loan" data-id="{{ $loan->id }}" title="Delete">
									<i class="fa-regular fa-trash-can"></i>
								</x-danger-button>
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
@endsection
</x-app-layout>
