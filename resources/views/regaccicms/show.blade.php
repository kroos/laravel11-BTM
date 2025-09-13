@extends('layouts.pdf-layout')

@section('title', '(BTM02) Borang Pendaftaran Akaun Dan Modul ICMS')
@section('header-title', '(BTM02) Borang Pendaftaran Akaun Dan Modul ICMS')

@section('content')
<table>
	<thead>
		<tr>
			<th colspan="2"><span class="center">Bahagian Teknologi Maklumat</span></th>
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
			<th colspan="2"><span class="center">Pemohon</span></th>
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

</table>
@endsection
