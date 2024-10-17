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
		<table class="table table-hover table-sm">
			<thead>
				<tr>
					<th>Loan No</th>
					<th>Name</th>
					<th>Loan From</th>
					<th>Loan To</th>
					<th>Location</th>
					<th>Equipments Pick Up On</th>
					<th>Equipments</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>BTM-LO-{{ date('Ym').str_pad( 34, 3, "0", STR_PAD_LEFT) }}</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>
						<table class="table table-sm table-hover">
							<thead>
								<tr>
									<th>Equipments</th>
									<th>Taken On</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td></td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
	</div>

@section('js')
/////////////////////////////////////////////////////////////////////////////////////////

@endsection
</x-app-layout>
