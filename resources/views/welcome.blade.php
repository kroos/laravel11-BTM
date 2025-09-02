<x-guest-layout>

	@section('content')
	<div class="container my-4">

		<!-- Header image -->
		<div class="col-sm-4 text-center mb-4 mx-auto">
			<img src="{{ asset('images/front4.jpg') }}" alt="BTM, UniSHAMS" class="img-fluid rounded shadow">
		</div>

		<!-- New Email Application Flow -->
		<div class="col-sm-4 mx-auto">
			<div class="card mb-5 shadow rounded-3">
				<div class="card-header bg-primary text-white">
					<i class="bi bi-envelope-paper"></i> (BTM01) New Email Application Flow
				</div>
				<div class="card-body">
					<ul class="list-group list-group-flush">
						<li class="list-group-item">
							<i class="bi bi-person"></i> Staff fills in <strong>Email Application Form</strong>.
						</li>
						<li class="list-group-item">
							<i class="bi bi-people"></i> Supervisor reviews and approves request.
						</li>
						<li class="list-group-item">
							<i class="bi bi-building"></i> IT Department processes new email creation.
						</li>
						<li class="list-group-item">
							<i class="bi bi-check2-circle"></i> Staff receives confirmation and login details.
						</li>
					</ul>
				</div>
			</div>
		</div>

		<!-- IT Equipment Loan Flow -->
		<div class="col-sm-4 mx-auto">
			<div class="card shadow rounded-3">
				<div class="card-header bg-success text-white">
					<i class="bi bi-laptop"></i> (BTM03) IT Equipment Loan Flow
				</div>
				<div class="card-body">
					<ul class="list-group list-group-flush">
						<li class="list-group-item">
							<i class="bi bi-person"></i> Staff submits <strong>Equipment Loan Request</strong>.
						</li>
						<li class="list-group-item">
							<i class="bi bi-people"></i> Supervisor checks and approves loan.
						</li>
						<li class="list-group-item">
							<i class="bi bi-gear"></i> IT Department issues equipment.
						</li>
						<li class="list-group-item">
							<i class="bi bi-arrow-repeat"></i> Staff uses equipment during loan period.
						</li>
						<li class="list-group-item">
							<i class="bi bi-box-arrow-in-left"></i> Staff returns equipment to IT Department.
						</li>
						<li class="list-group-item">
							<i class="bi bi-clipboard-check"></i> IT verifies equipment condition and closes record.
						</li>
					</ul>
				</div>
			</div>
		</div>

	</div>
	@endsection


	@section('js')
	@endsection
</x-guest-layout>
