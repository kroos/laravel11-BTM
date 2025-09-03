@extends('layouts.pdf-layout')

@section('title', '(BTM03) Borang Pinjaman Peralatan')
@section('header-title', '(BTM03) Borang Pinjaman Peralatan')

@section('content')
<table>
	<thead>
		<tr>
			<th colspan="2"><span class="center">Bahagian Teknologi Maklumat</span></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>No Rujukan : <span class="bold red">
				{{ 'BTM-LE-'.\Carbon\Carbon::parse($btmloanapplication->created_at)->format('ym').str_pad( $btmloanapplication->id, 3, "0", STR_PAD_LEFT) }}
			</span>
		</td>
		<td>
			Tarikh Permohonan : <span class="bold">{{ \Carbon\Carbon::parse($btmloanapplication->created_at)->format('D, j M Y') }}</span>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<p class="bold underline">Terma & Syarat :</p>
			<ul>
				<li>Permohonan hendaklah diterima oleh BTM dalam tempoh <span class="bold underline">TIGA (3) hari</span> bekerja sebelum program berlangsung. <span class="bold underline">Permohonan lewat tidak akan dilayan.</span></li>
				<li>Permohonan yang tidak lengkap tidak akan diproses</li>
				<li class="bold">Sila ambil perhatian dan pulangkan semula ke pejabat BTM sperti yang telah ditetapkan</li>
			</ul>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<span>Peralatan yang disediakan :</span>
			<ol>
				<li>Peralatan Komputer</li>
				<li>Peralatan Jaringan (Network Appliances)</li>
				<li>Peranti Audio Visual</li>
			</ol>
			<p class="bold red">*Untuk makluman, pihak BTM <span class="underline">tidak menyediakan Wire Extension</span>.</p>
		</td>
	</tr>
</tbody>
<thead>
	<tr>
		<th colspan="2"><span class="center">Pemohon</span></th>
	</tr>
</thead>
<tbody>
	<tr>
		<td style="width: 50%;">
			Nama : <span class="bold">{{ $btmloanapplication->belongstostaff->nama }}</span>
		</td>
		<td style="width: 50%;">
			Kuliyyah : <span class="bold">{{ $btmloanapplication->belongstostaff->belongstomanydepartment->first()->namajabatan }}</span>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			Tujuan Pinjaman : <span class="bold">{{ $btmloanapplication->loan_purpose }}</span>
		</td>
	</tr>
	<tr>
		<td>
			Tarikh Mula Pinjam : <span class="bold">{{ \Carbon\Carbon::parse($btmloanapplication->date_loan_from)->format('D, j M Y') }}</span>
		</td>
		<td>
			Tarikh Tamat Pinjam : <span class="bold">{{ \Carbon\Carbon::parse($btmloanapplication->date_loan_to)->format('D, j M Y') }}</span>
		</td>
	</tr>
	<tr>
		<th colspan="2"><span class="center">Alatan</span></th>
	</tr>
	@foreach($btmloanapplication->hasmanyequipments()->get() as $eq)
	<tr>
		<td>{{ $eq->belongstoequipment->item }}</td>
		<td style="padding: 0px;">
			<table style="margin-bottom: 0px;">
				<thead>
					<tr>
						<th>Brand</th>
						<th>Model</th>
						<th>Serial No</th>
						<th>Taken On</th>
						<th>Return On</th>
						<th>Status</th>
						<th>BTM Remarks</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>{{ $eq->belongstoequipment->brand }}</td>
						<td>{{ $eq->belongstoequipment->model }}</td>
						<td>{{ $eq->belongstoequipment->serial_number }}</td>
						<td>{{ ($eq->taken_on)?\Carbon\Carbon::parse($eq->taken_on)->format('j M Y'):NULL }}</td>
						<td>{{ ($eq->return_on)?\Carbon\Carbon::parse($eq->return_on)->format('j M Y'):NULL }}</td>
						<td>{{ $eq->belongstoequipmentstatus->status_item }}</td>
						<td>{{ $eq->status_condition_remarks }}</td>
					</tr>
				</tbody>
			</table>
		</td>
	</tr>
	@endforeach
	<tr>
		<th colspan="2"><span class="center">Sokongan Pengarah/Dekan/Ketua Jabatan</span></th>
	</tr>
	<tr>
	</tr>
	<tr>
		<td colspan="2"><span class="red bold">* Saya mengesahkan bahawa peralatan yang dipinjam adalah untuk urusan rasmi.</span></td>
	</tr>
	<tr>
		<td>Nama : <span class="bold">{{ ($btmloanapplication->belongstoappr->nama) }}</span></td>
		<td>Tarikh : <span class="bold">{{ (!is_null($btmloanapplication->approver_date))?\Carbon\Carbon::parse($btmloanapplication->approver_date)->format('D, j M Y'):NULL }}</span></td>
	</tr>
	<tr>
		<td>Catatan : {{ $btmloanapplication->approver_remarks }}</td>
		<td>Status : <span class="bold">{{ $btmloanapplication->belongstoapproverstatusloan->status_approval }}</span></td>
	</tr>
	<tr>
		<th colspan="2"><span class="center">UNTUK KEGUNAAN PEJABAT</span></th>
	</tr>
	<tr>
		<td colspan="2">
			Status Permohonan : <span class="bold">{{ $btmloanapplication->belongstostatusloan->status_loan }}</span>
		</td>
	</tr>
	<tr>
		<td>Nama : <span class="bold">{{ $btmloanapplication->belongstobtmappr->nama }}</span></td>
		<td>Tarikh : <span class="bold">{{ (!is_null($btmloanapplication->btm_date))?\Carbon\Carbon::parse($btmloanapplication->btm_date)->format('D, j M Y'):NULL }}</span></td>
	</tr>
	<tr>
		<td colspan="2">Catatan : {{ $btmloanapplication->btm_remarks }}</td>
	</tr>
</tbody>
</table>
@endsection
