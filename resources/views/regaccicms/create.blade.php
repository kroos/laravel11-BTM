<x-app-layout>

	<x-slot name="header">
		<h2 class="font-montserrat font-semibold text-xl text-gray-800 leading-tight text-center">
			{{ __('BTM02 - BORANG PENDAFTARAN AKAUN DAN MODUL ICMS') }}
		</h2>
	</x-slot>

	<form action="{{ route('regaccicms.store') }}" method="POST" class="needs-validation" novalidate>
		@csrf
		<div class="container d-flex justify-content-between">
			<div class="col-4-sm m-2 p-1">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Pemohon</h3>
					</div>
					<div class="card-body">
						<div class="col-sm-12 mt-2 row">
							<x-input-label for="id" class="col-sm-4" :value="__('No. Staf : ')" />
							<div class="col-sm-8">
								<x-text-input id="id" name="nostaf" value="{{ Auth::user()->nostaf }}" class="{{ ($errors->has('nostaf')?'is-invalid':NULL) }}" readonly />
								<x-input-error :messages="$errors->get('nostaf')" />
							</div>
						</div>

						<!-- staff name -->
						<div class="col-sm-12 mt-2 row">
							<x-input-label for="staf" class="col-sm-4" :value="__('Nama Staf : ')" />
							<div class="col-sm-8">
								<x-text-input id="staf" name="nama" value="{{ Auth::user()->name }}" class="{{ ($errors->has('nama')?'is-invalid':NULL) }}" readonly />
								<x-input-error :messages="$errors->get('nama')" />
							</div>
						</div>

					</div>
				</div>
			</div>
			<div class="col-sm-8 mt-2 p-1">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Maklumat Pemohon</h3>
					</div>
					<div class="card-body">

						<div class="wrap_emails">
							<div class="col-sm-12 row m-3  border border-primary rounded">
								<div class="col-sm-8 m-0 p-1">

									<div class="col-sm-12 m-1 row">
										<x-input-label for="nostaf_0" class="col-sm-3" :value="__('No Staff : ')" />
										<div class="col-sm-9">
											<input id="nostaf_0" type="text" name="emreg[0][nostaf]" class="form-control form-control-sm @error('emreg.*.nostaf') is-invalid @enderror" placeholder="No Staff">
											@error('emreg.*.nostaf')
												<div class="invalid-feedback">
													Please provide ID Staff.
												</div>
											@enderror
										</div>
									</div>

									<div class="col-sm-12 m-1 row">
										<x-input-label for="nama_0" class="col-sm-3" :value="__('Nama : ')" />
										<div class="col-sm-9">
											<input id="nama_0" type="text" name="emreg[0][nama]" class="form-control form-control-sm @error('emreg.*.nama') is-invalid @enderror" placeholder="Nama">
											@error('emreg.*.nama')
												<div class="invalid-feedback">
													Please provide Staff Name.
												</div>
											@enderror
										</div>
									</div>

									<div class="col-sm-12 m-1 row">
										<x-input-label for="jawatan_0" class="col-sm-3" :value="__('Jawatan : ')" />
										<div class="col-sm-9">
											<input id="jawatan_0" type="text" name="emreg[0][position]" class="form-control form-control-sm @error('emreg.*.position') is-invalid @enderror" placeholder="Jawatan">
											@error('emreg.*.position')
												<div class="invalid-feedback">
													Please provide Staff Position.
												</div>
											@enderror
										</div>
									</div>

									<div class="col-sm-12 m-1 row">
										<x-input-label for="email_0" class="col-sm-3" :value="__('Email : ')" />
										<div class="col-sm-9">
											<input id="email_0" type="text" name="emreg[0][email]" class="form-control form-control-sm @error('emreg.*.email') is-invalid @enderror" placeholder="Email">
											@error('emreg.*.email')
												<div class="invalid-feedback">
													Please provide Staff Email.
												</div>
											@enderror
										</div>
									</div>

									<div class="col-sm-12 m-1 row">
										<x-input-label for="cadid_0" class="col-sm-3" :value="__('Cadangan ID : ')" />
										<div class="col-sm-9">
											<input id="cadid_0" type="text" name="emreg[0][proposed_id]" class="form-control form-control-sm @error('emreg.*.proposed_id') is-invalid @enderror" placeholder="Cadangan ID" aria-describedby="CadanganIDHelpBlock_0">
											<div id="CadanganIDHelpBlock_0" class="form-text fs-6 fw-lighter">
												Hanya untuk pemohon baru.
											</div>
											@error('emreg.*.proposed_id')
												<div class="invalid-feedback">
													Please provide Staff Email.
												</div>
											@enderror
										</div>
									</div>

								</div>
								<div class="col-sm-4 m-0 p-1">
									this 1 is for the module list
								</div>

							</div>
						</div>


						<!-- add email button -->
						<x-primary-button type="button" class="add_user">
							<i class="fa-solid fa-screwdriver-wrench fa-beat"></i> </i>&nbsp;Tambah Pemohon
						</x-primary-button>


					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-12 m-2">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Kulliyyah/Pusat/Bahagian</h3>
					<p>
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
							<h3 class="card-title">Sokongan Pengarah/Dekan/Ketua Jabatan</h3>
						</div>
						<div class="card-body">
							<p>Status :
							@php
							$j = \App\Models\Jabatan::find($idj);
							if($j->belongstomanyappr->count()){
								echo $j->belongstomanyappr->first()->nama;
							} else {
								echo '<span class="text-danger fw-bold">Dalam Proses/Disokong/Tidak Disokong</span>';
							}
							@endphp
							</p>
							<p>Tarikh : </p>
						</div>
						<div class="card-footer bg-warning-subtle @error('acknowledge') has-error @enderror">
							<div class="form-check text-center @error('acknowledge') is-invalid @enderror">
								<label class="form-check-label text-sm fs-6 fw-bolder" for="checkDefault">
									<input class="form-check-input mx-2 @error('acknowledge') is-invalid @enderror" type="checkbox" name="acknowledge" value="1" id="checkDefault">
									Saya mengaku bahawa semakan telah dibuat dan maklumat ini adalah benar untuk kegunaan urusan rasmi.
								</label>
							</div>
							@error('acknowledge')
							<div class="invalid-feedback text-center fs-6 fw-bolder">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-12 text-center">
			<x-primary-button type="submit" class="m-2">
				<i class="fa-solid fa-floppy-disk fa-beat"></i>&nbsp;{{ __('Hantar') }}
			</x-primary-button>
		</div>
	</form>

@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
// datepicker
$('#date').datepicker({
	dateFormat: 'yy-mm-dd',
	minDate: 0,
});

/////////////////////////////////////////////////////////////////////////////////////////


/////////////////////////////////////////////////////////////////////////////////////////
@endsection
</x-app-layout>
