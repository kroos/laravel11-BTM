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
			<td colspan="2" style="padding: 0px;">
				<table style="margin: 0px;">
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
	</tbody>

</table>
@endsection
