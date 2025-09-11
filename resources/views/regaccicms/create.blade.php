<x-app-layout>

	<x-slot name="header">
		<h2 class="font-montserrat font-semibold text-xl text-gray-800 leading-tight text-center">
			{{ __('BTM02 - BORANG PENDAFTARAN AKAUN DAN MODUL ICMS') }}
		</h2>
	</x-slot>

	<form action="{{ route('regaccicms.store') }}" method="POST" class="needs-validation" novalidate>
		@csrf
		<div class="container d-flex justify-content-between">
<!--
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
 -->
			<div class="col-sm-12 mt-2 p-1">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Maklumat Pemohon</h3>
					</div>
					<div class="card-body">

						<div class="wrap_emails">
							<div class="col-sm-12 row m-3">
								<div class="col-sm-7 m-0 p-1 border border-primary">

									<div class="col-sm-12 m-1 row">
										<x-input-label for="nama_0" class="col-sm-3" :value="__('Nama : ')" />
										<div class="col-sm-9">
											<select id="nama_0" name="emreg[0][nama]" class="form-select form-select-sm @error('emreg.*.nama') is-invalid @enderror" placeholder="Please choose"></select>
											@error('emreg.*.nama')
												<div class="invalid-feedback">
													Please provide Staff Name.
												</div>
											@enderror
										</div>
									</div>

									<div class="col-sm-12 m-1 row">
										<x-input-label for="nostaf_0" class="col-sm-3" :value="__('No Staff : ')" />
										<div class="col-sm-9">
											<input id="nostaf_0" type="text" name="emreg[0][nostaf]" value="{{ old('emreg.*.nostaf') }}" class="form-control form-control-sm @error('emreg.*.nostaf') is-invalid @enderror" placeholder="No Staff" readonly>
										</div>
									</div>

									<div class="col-sm-12 m-1 row">
										<x-input-label for="email_0" class="col-sm-3" :value="__('Email : ')" />
										<div class="col-sm-9">
											<input id="email_0" type="text" name="emreg[0][email]" value="{{ old('emreg.*.email') }}" class="form-control form-control-sm @error('emreg.*.email') is-invalid @enderror" placeholder="Email" readonly>
										</div>
									</div>

									<div class="col-sm-12 m-1 row">
										<x-input-label for="jawatan_0" class="col-sm-3" :value="__('Jawatan : ')" />
										<div class="col-sm-9">
											<input id="jawatan_0" type="text" name="emreg[0][position]" value="{{ old('emreg.*.position') }}" class="form-control form-control-sm @error('emreg.*.position') is-invalid @enderror" placeholder="Jawatan" readonly>
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

								<div class="col-sm-5 m-0 p-1 border border-warning">
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
		<div class="col-sm-10 m-2 mx-auto">
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
$('#nama_0').select2({
	placeholder: 'Please Choose',
	width: '100%',
	allowClear: true,
	closeOnSelect: true,
	ajax: {
		url: '{{ route('liststaff') }}',
		type: 'GET',
		dataType: 'json',
		data: function (params) {
			return {
				_token: '{!! csrf_token() !!}',
				search: params.term,
				type: 'public'
			};
		},
		processResults: function (data) {
			return {
				results: $.map(data.results[0].children, function (item) {
					return {
						id: item.id,       // staff no
						text: item.text,   // display in dropdown
						email: item.element // email from JSON
					};
				})
			};
		}
	},
	templateResult: function (data) {
		return data.text;
	},
	templateSelection: function (data) {
		return data.text;
	}
});

// ✅ When staff selected, populate NoStaf + Email
$('#nama_0').on('select2:select', function (e) {
	var data = e.params.data;

	$('#nostaf_0').val(data.id);      // staff number
	$('#email_0').val(data.email);    // staff email
});

// ✅ Optional: clear inputs if selection cleared
$('#nama_0').on('select2:clear', function () {
	$('#nostaf_0').val('');
	$('#email_0').val('');
});

// also check on page load (for F5 refresh case)
if (!$('#nama_0').val()) {
    $('#nostaf_0').val('');
    $('#email_0').val('');
}

/////////////////////////////////////////////////////////////////////////////////////////
@endsection
</x-app-layout>
