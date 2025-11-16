<x-text-input type="hidden" id="id" name="nostaf" value="{{ Auth::user()->nostaf }}" readonly />
<div class="col-sm-12 d-flex flex-column align-items-center">
	<div class="col-12-sm row">

		<div class="col-sm-6 m-0 p-1">
			<div class="card ">
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
			<div class="card mt-2">
				<div class="card-header">
					<h3 class="card-title">Cadangan Alamat Emel</h3>
					<small>1) Tidak dibenarkan meletak nombor atau nama timangan selain nama asal</small> <br />
					<small>2) Masukkan sekurang-kurangnya dua (2) cadangan alamat emel</small>
				</div>
				<div id="card-body">
					<div class="col-sm-auto m-1">
						<x-primary-button type="button" id="emails_add">
							<i class="fa-solid fa-screwdriver-wrench fa-beat"></i> </i>&nbsp;Tambah Emel
						</x-primary-button>
					</div>
					<div class="col-auto m-1" id="emails_wrap">
					</div>
				</div>
			</div>
		</div>

		<div class="col-sm-6 m-0 p-1">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Emel Berkumpulan</h3>
					<small>Tekan butang di bawah, kemudian masukkan senarai emel ahli kumpulan</small>
				</div>
				<div class="card-body">
					<div class="form-check form-switch">
						<label class="form-check-label" for="gemail">
							<input name="group_email" value="1" class="form-check-input" type="checkbox" role="switch" id="gemail" {{ old('group_email', @$emailaccapp->group_email)?'checked':NULL }}>&nbsp;&nbsp;
							Cipta Emel Berkumpulan
						</label>
					</div>
					<div class="col-sm-12 m-0 p-1" id="group_email_wrap">
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-12-sm ">
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
								<input class="form-check-input mx-2 @error('acknowledge') is-invalid @enderror" type="checkbox" name="acknowledge" value="1" id="checkDefault" {{ old('acknowledge')==1?'checked':NULL }}>
								Saya mengaku bahawa semakan telah dibuat dan emel ini adalah untuk kegunaan urusan rasmi.
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

	<div class="col-sm-4 text-center">
		<x-primary-button type="submit" class="m-2">
			<i class="fa-solid fa-floppy-disk fa-beat"></i>&nbsp;{{ __('Hantar') }}
		</x-primary-button>
	</div>

</div>
