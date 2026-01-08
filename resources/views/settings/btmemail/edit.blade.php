<x-app-layout>
<?php
\Auth::user()->setConnection('mysql3');
\Auth::user()->unreadNotifications->markAsRead();
?>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Email Registration Account Form') }}
		</h2>
	</x-slot>

	<form action="{{ route('btmemailapplications.update', $btmemailapplication->id) }}" method="POST">
		@method('PATCH')
		@csrf
		<x-text-input type="hidden" id="id" name="nostaf" value="{{ $btmemailapplication->nostaf }}" readonly />

		<div class="container row justify-content-evenly mx-auto mt-2 mb-2">
			<!-- 1st column -->
			<div class="col-sm-6 m-0">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Proposed Email ID
						</h3>
						<small>Please do not use nickname or number in your email ID</small>
					</div>
					<div class="card-body">
						<div class="col-sm-12 text-right mt-3">
							<x-primary-button type="button" class="add_emails" id="emails_add">
								<i class="fa-solid fa-screwdriver-wrench fa-beat"></i></i>&nbsp;Add Emails
							</x-primary-button>
						</div>

						<div class="wrap_emails" id="emails_wrap"></div>

					</div>
				</div>
			</div>

			<!-- 2nd column -->
			<div class="col-sm-6 m-0">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Group Email
						</h3>
						<small>Turn on the switch if you are applying for group email, then fill up inputs below.</small>
					</div>
					<div class="card-body">
						<div class="form-check form-switch">
							<label class="form-check-label" for="gemail">
								<input name="group_email" value="1" class="form-check-input" type="checkbox" role="switch" id="gemail">
							Group Email</label>
						</div>
						<div class="col-sm-12 m-0 p-1" id="wrap_group_email">
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row justify-content-center">
			<!-- 3rd column -->
			<div class="col-sm-6 m-0 p-1">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Department
						</h3>
						<p>Department :
						@php
						$r = \App\Models\Staff::find(Auth::user()->nostaf);
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
								<p>Date : </p>
							</div>
						</div>
					</div>
					<div class="card-footer">
						<p class="text-sm fs-6 fw-bolder">I hereby confirm that the new email registration is intended for official purposes.</p>
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
							<div class="btn-group {{ ($errors->has('status_email_id')?'is-invalid':NULL) }}" role="group" aria-label="New Email Registration Approval">
								<?php
									$p = 0;
								?>
								@foreach(\App\Models\StatusApplication::whereIn('id', [1,2])->get() as $v)
									<input type="radio" class="btn-check {{ ($errors->has('status_email_id')?'is-invalid':NULL) }}" name="status_email_id" id="status_loan{{ $p }}" value="{{ $v->id }}" {{ ($btmemailapplication->status_email_id == $v->id)?'checked="checked"':NULL }} autocomplete="off">
									<label class="btn btn-sm btn-outline-primary" for="status_loan{{ $p }}">{{ $v->status_loan }}</label>
									<?php
										$p++;
									?>
								@endforeach
							</div>
							<x-input-error :messages="$errors->get('status_email_id')" />
						</div>
						<div class="col-sm-12 mt-2 row">
							<x-input-label for="rem" class="col-sm-4" :value="__('BTM Remarks : ')" />
							<div class="col-sm-8">
								<textarea name="btm_remarks" class="form-control form-control-sm {{ ($errors->has('btm_remarks')?'is-invalid':NULL) }}" id="rem">{{ $btmemailapplication->btm_remarks }}</textarea>
								<x-input-error :messages="$errors->get('btm_remarks')" />
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-sm-12 text-center">
				<x-primary-button type="submit" class="m-2">
					<i class="fa-solid fa-floppy-disk fa-beat"></i>&nbsp;{{ __('Update') }}
				</x-primary-button>
			</div>
		</div>
	</form>
@section('js')
	@include('settings.btmemail._js')
@endsection
</x-app-layout>
