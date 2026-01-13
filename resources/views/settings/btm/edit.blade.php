<x-app-layout>

	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Equipment Loan Application Form') }}
		</h2>
	</x-slot>

	<form action="{{ route('btmloanapplications.update', $loanapp->id) }}" method="POST" class="">
			@csrf
			@method('PATCH')
		<div class="container row mx-auto mt-2 mb-2">
			<!-- 1st column -->
			<div class="col-sm-6 m-0 p-1">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Applicant</h3>
					</div>
					<div class="card-body">
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
				</div>
			</div>

			<!-- 2nd column -->
			<div class="col-sm-6 m-0 p-1">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Equipments
						</h3>
					</div>
					<div class="card-body">
						<div class="col-sm-12 text-right mt-3">
							<x-primary-button type="button" id="equipments_add" class="add_equipments">
								<i class="fa-solid fa-screwdriver-wrench fa-beat"></i></i>&nbsp;Add Equipments
							</x-primary-button>
						</div>
						<div class="@error('lequ') is-invalid @enderror" id="equipments_wrap"></div>
						@error('lequ')
							<div class="invalid-feedback">
								{{ $message }}
							</div>
						@enderror
					</div>
				</div>
			</div>
		</div>

		<div class="col-sm-12 row justify-content-center">
			<!-- 3rd column -->
			<div class="col-sm-6 m-0 p-1">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Department
						</h3>
						<p>Department :
						@php
						$r = \App\Models\Staff::find($loanapp->nostaf);
						echo $r->belongstomanydepartment()->first()->namajabatan;
						$idj = $r->belongstomanydepartment()->first()->kodjabatan;
						@endphp
						</p>
					</div>
					<div class="card-body">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title">Approval From Director/Dean/Head of Department
								</h3>
							</div>
							<div class="card-body">
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
								<p>Date : {{ (!is_null($loanapp->approver_date))?\Carbon\Carbon::parse($loanapp->approver_date)->format('D, j F Y'):NULL }}</p>
							</div>
							<div class="card-footer">
								<p class="text-sm fs-6 fw-bolder">I hereby confirm that the loaned equipment is intended for official purposes.</p>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- 4th column -->
			<div class="col-sm-6 m-0 p-1">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">BTM Used
						</h3>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="btn-group {{ ($errors->has('status_loan_id')?'is-invalid':NULL) }}" role="group" aria-label="Loan Equipment Approval">
								<?php
									$p = 0;
								?>
								@foreach(\App\Models\StatusApplication::whereIn('id', [1,2])->get() as $v)
									<input type="radio" class="btn-check {{ ($errors->has('status_loan_id')?'is-invalid':NULL) }}" name="status_loan_id" id="status_loan{{ $p }}" value="{{ $v->id }}" {{ ($loanapp->status_loan_id == $v->id)?'checked="checked"':NULL }} autocomplete="off">
									<label class="btn btn-sm btn-outline-primary" for="status_loan{{ $p }}">{{ $v->status_loan }}</label>
									<?php
										$p++;
									?>
								@endforeach
							</div>
							<x-input-error :messages="$errors->get('status_loan_id')" />
						</div>
						<div class="col-sm-12 mt-2 row">
							<x-input-label for="rem" class="col-sm-4" :value="__('BTM Remarks : ')" />
							<div class="col-sm-8">
								<textarea name="btm_remarks" class="form-control form-control-sm {{ ($errors->has('btm_remarks')?'is-invalid':NULL) }}" id="rem">{{ $loanapp->btm_remarks }}</textarea>
								<x-input-error :messages="$errors->get('btm_remarks')" />
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-sm-12 m-0 p-1 text-center">
				<x-primary-button type="submit" class="m-2">
					<i class="fa-solid fa-floppy-disk fa-beat"></i>&nbsp;{{ __('Update') }}
				</x-primary-button>
			</div>
		</div>
	</form>

@section('js')
	@include('settings.btm._js')
@endsection
</x-app-layout>
