@extends('layouts.pdf-layout')

@section('title', '(BTM02) Borang Pendaftaran Akaun Dan Modul ICMS')
@section('header-title', '(BTM02) Borang Pendaftaran Akaun Dan Modul ICMS')

@section('content')
<table>
	<thead>
		<tr>
			<th colspan="2" class="center"><span>Bahagian Teknologi Maklumat</span></th>
		</tr>
	</thead>
	<tbody>
<!-- 		<tr>
			<td>No Rujukan : <span class="bold red">
				BTM-RAICMS-{{ \Carbon\Carbon::parse($regaccicm->created_at)->format('ym').str_pad( $regaccicm->id, 3, "0", STR_PAD_LEFT) }}
			</span>
		</td>
		<td>
			Tarikh Permohonan : <span class="bold">{{ \Carbon\Carbon::parse($regaccicm->created_at)->format('D, j F Y') }}</span>
		</td>
	</tr>
 -->	</tbody>
	<thead>
		<tr>
			<th colspan="2" class="center"><span class="center">Pemohon</span></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td style="width: 50%;">
				Nama : <span class="bold">{{ $regaccicm->belongstostaff->nama }}</span>
			</td>
			<td style="width: 50%;">
				KPB : <span class="bold">{{ $regaccicm->belongstostaff->belongstomanydepartment?->first()?->namajabatan }}</span>
			</td>
		</tr>
	</tbody>
	<tbody>
		<tr>
			<td colspan="2" class="p-0">
				<table class="m-0">
					<thead>
						<tr>
							<th>Pemohon</th>
							<th>No Staff</th>
							<th>Email</th>
							<th>Jawatan</th>
							<th>Cadangan ID Pengguna</th>
							<th>Capaian ICMS</th>
						</tr>
					</thead>
					<tbody>
						@foreach($regaccicm->hasmanyapplicant()->get() as $k)
						<tr>
							<td>{{ $k->belongstoicmsapplicant->nama }}</td>
							<td>{{ $k->nostaf }}</td>
							<td>{{ $k->belongstoicmsapplicant?->hasmanylogin()?->first()?->email }}</td>
							<td>{{ $k->position }}</td>
							<td>{{ $k->username }}</td>
							<td style="padding: 0px;">
								<table style="margin: 0px;">
									<tbody>
										@foreach($k->belongstomanyicmsmodule()->get() as $k1)
										<tr>
											<td>
												{{ $k1->icms_module }}<br />
												@if($k1->pivot->remarks)
													{{ $k1->pivot->remarks }}
												@endif
											</td>
										</tr>
									@endforeach
									</tbody>
								</table>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<th colspan="2" class="center"><span>Sokongan Pengarah/Dekan/Ketua Jabatan</span></th>
		</tr>
			<tr>
			</tr>
			<tr>
				<td colspan="2"><span class="red bold">* Saya mengesahkan bahawa maklumat diatas adalah benar dan adalah untuk urusan rasmi.</span></td>
			</tr>
			<tr>
				<td>Nama : <span class="bold">{{ ($regaccicm->belongstoappr?->nama) }}</span></td>
				<td>Tarikh : <span class="bold">{{ (!is_null($regaccicm->approver_date))?\Carbon\Carbon::parse($regaccicm->approver_date)->format('D, j F Y'):NULL }}</span></td>
			</tr>
			<tr>
				<td>Catatan : {{ $regaccicm->approver_remarks }}</td>
				<td>Status : <span class="bold">{{ $regaccicm->belongstoapproverstatusloan?->status_approval }}</span></td>
			</tr>
			<tr>
				<th colspan="2" class="center"><span>UNTUK KEGUNAAN PEJABAT</span></th>
			</tr>
			<tr>
				<td colspan="2">
					Status Permohonan : <span class="bold">{{ $regaccicm->belongstostatusapp?->status_loan }}</span>
				</td>
			</tr>
			<tr>
				<td>Nama : <span class="bold">{{ $regaccicm->belongstobtmappr?->nama }}</span></td>
				<td>Tarikh : <span class="bold">{{ (!is_null($regaccicm->btm_date))?\Carbon\Carbon::parse($regaccicm->btm_date)->format('D, j M Y'):NULL }}</span></td>
			</tr>
			<tr>
				<td colspan="2">Catatan : {{ $regaccicm->btm_remarks }}</td>
			</tr>
	</tbody>

</table>
@endsection
