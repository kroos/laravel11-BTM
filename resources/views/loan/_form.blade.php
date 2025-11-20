		<div class="col-sm-12 d-flex flex-column align-items-center">

			<div class="col-12-sm row">
				<!-- 1st column -->
				<div class="col-sm-6 m-0 p-1">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Peminjam</h3>
						</div>
						<div class="card-body">
							<!-- staff id -->
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

							<!-- date loan -->
							<div class="col-sm-12 mt-2 row">
								<x-input-label for="dafrom" class="col-sm-4" :value="__('Pinjam DARI : ')" />
								<div class="col-sm-8">
									<x-text-input id="dafrom" name="date_loan_from" value="{{ old('date_loan_from') }}" class="{{ ($errors->has('date_loan_from')?'is-invalid':NULL) }}"  />
									<x-input-error :messages="$errors->get('date_loan_from')" />
								</div>
							</div>

							<!-- date loan -->
							<div class="col-sm-12 mt-2 row">
								<x-input-label for="dato" class="col-sm-4" :value="__('Pinjam HINGGA : ')" />
								<div class="col-sm-8">
									<x-text-input id="dato" name="date_loan_to" value="{{ old('date_loan_to') }}" class="{{ ($errors->has('date_loan_from')?'is-invalid':NULL) }}"  />
									<x-input-error :messages="$errors->get('date_loan_to')" />
								</div>
							</div>

							<!-- purpose -->
							<div class="col-sm-12 mt-2 row">
								<x-input-label for="purp" class="col-sm-4" :value="__('Tujuan Pinjaman : ')" />
								<div class="col-sm-8">
									<x-textarea-input id="purp" name="loan_purpose" value="{{ old('loan_purpose') }}" class="{{ ($errors->has('date_loan_from')?'is-invalid':NULL) }}"  />
									<x-input-error :messages="$errors->get('loan_purpose')" />
								</div>
							</div>

							<!-- tempat pinjaman -->
							<div class="col-sm-12 mt-2 row">
								<x-input-label for="loc" class="col-sm-4" :value="__('Lokasi / Tempat : ')" />
								<div class="col-sm-8">
									<x-text-input id="loc" name="location" value="{{ old('location') }}" class="{{ ($errors->has('location')?'is-invalid':NULL) }}"  />
									<x-input-error :messages="$errors->get('location')" />
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- 2nd column side kanan -->
				<div class="col-sm-6 m-0 p-1">

					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Butiran Peralatan</h3>
						</div>
						<div class="card-body">

							<div id="equipments_wraps"></div>
							<!-- add item -->
							<div class="col-sm-12 text-right mt-3">
								<x-primary-button type="button" id="equipments_add">
									<i class="fa-solid fa-screwdriver-wrench fa-beat"></i></i>&nbsp;Tambah Peralatan
								</x-primary-button>
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
										<input class="form-check-input mx-2 @error('acknowledge') is-invalid @enderror" type="checkbox" name="acknowledge" value="1" id="checkDefault">
										Saya akan bertanggungjawab ke atas barang pinjaman dan mengaku bahawa pinjaman ini dibuat untuk kegunaan urusan rasmi.
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
