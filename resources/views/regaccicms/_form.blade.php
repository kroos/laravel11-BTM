		<div class="col-sm-12 d-flex flex-column align-items-center">

			<div class="col-sm-8 mt-2 p-1">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Maklumat Pemohon</h3>
					</div>
					<div class="card-body @error('applicants') has-error is-invalid @enderror">

						<div id="applicants_wrap">
						</div>

						<x-primary-button type="button" id="applicants_add">
							<i class="fa-solid fa-screwdriver-wrench fa-beat"></i> </i>&nbsp;Tambah Pemohon
						</x-primary-button>
					</div>
					@error('applicants')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
					@enderror
				</div>
			</div>

			<div class="col-sm-8">
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
								<p>
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
			<div class="col-sm-4 text-center">
				<x-primary-button type="submit" class="m-2">
					<i class="fa-solid fa-floppy-disk fa-beat"></i>&nbsp;{{ __('Hantar') }}
				</x-primary-button>
			</div>

		</div>
