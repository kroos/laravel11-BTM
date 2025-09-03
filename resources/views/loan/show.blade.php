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
						{{ 'BTM-LE-'.\Carbon\Carbon::parse($loanapp->created_at)->format('ym').str_pad( $loanapp->id, 3, "0", STR_PAD_LEFT) }}
					</span>
				</td>
				<td>
					Tarikh Permohonan : <span class="bold">{{ \Carbon\Carbon::parse($loanapp->created_at)->format('D, j F Y') }}</span>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<p class="bold underline">Terma & Syarat :</p>
					<ul>
						<li>Permohonan hendaklah diterima oleh BTM dalam tempoh <span class="bold underline">TIGA (3) hari</span> bekerja sebelum program berlangsung. <span class="bold underline">Permohonan lewat tidak akan dilayan.</span></li>
						<li>Permohonan yang tidak lengkap tidak akan diproses</li>
						<li class="bold">Sila ambil perhatian dan pulangkan semula ke pejabat BTM seperti yang telah ditetapkan</li>
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
					Nama : <span class="bold">{{ $loanapp->belongstostaff->nama }}</span>
				</td>
				<td style="width: 50%;">
					Kuliyyah : <span class="bold">{{ $loanapp->belongstostaff->belongstomanydepartment->first()->namajabatan }}</span>
				</td>
			</tr>
			<tr>
				<td>
					Tujuan Pinjaman : <span class="bold">{{ $loanapp->loan_purpose }}</span>
				</td>
				<td>Lokasi : <span class="bold">{{ $loanapp->location }}</span></td>
			</tr>
			<tr>
				<td>
					Tarikh Mula Pinjam : <span class="bold">{{ \Carbon\Carbon::parse($loanapp->date_loan_from)->format('D, j F Y') }}</span>
				</td>
				<td>
					Tarikh Tamat Pinjam : <span class="bold">{{ \Carbon\Carbon::parse($loanapp->date_loan_to)->format('D, j F Y') }}</span>
				</td>
			</tr>
			<tr>
				<th colspan="2"><span class="center">Alatan</span></th>
			</tr>
			@foreach($loanapp->hasmanyequipments()->get() as $eq)
			<tr>
				<td>{{ $eq->belongstoequipment->item }}</td>
				<td style="padding: 0px;">
					<table style="margin-bottom: 0px;">
						<thead>
							<tr>
								<th>Brand</th>
								<th>Model</th>
								<th>Serial No</th>
								<th>Description</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>{{ $eq->belongstoequipment->brand }}</td>
								<td>{{ $eq->belongstoequipment->model }}</td>
								<td>{{ $eq->belongstoequipment->serial_number }}</td>
								<td>{{ $eq->belongstoequipment->description }}</td>
								<td>{{ $eq->belongstoequipmentstatus->status_item }}</td>
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
				<td>Nama : <span class="bold">{{ ($loanapp->belongstoappr->nama) }}</span></td>
				<td>Tarikh : <span class="bold">{{ (!is_null($loanapp->approver_date))?\Carbon\Carbon::parse($loanapp->approver_date)->format('D, j F Y'):NULL }}</span></td>
			</tr>
			<tr>
				<td>Catatan : {{ $loanapp->approver_remarks }}</td>
				<td>Status : <span class="bold">{{ $loanapp->belongstoapproverstatusloan->status_approval }}</span></td>
			</tr>
			<tr>
				<th colspan="2"><span class="center">UNTUK KEGUNAAN PEJABAT</span></th>
			</tr>
			<tr>
				<td colspan="2">
					Status Permohonan : <span class="bold">{{ $loanapp->belongstostatusloan->status_loan }}</span>
				</td>
			</tr>
			<tr>
				<td>Nama : <span class="bold">{{ $loanapp->belongstobtmappr->nama }}</span></td>
				<td>Tarikh : <span class="bold">{{ (!is_null($loanapp->btm_date))?\Carbon\Carbon::parse($loanapp->btm_date)->format('D, j M Y'):NULL }}</span></td>
			</tr>
			<tr>
				<td colspan="2">Catatan : {{ $loanapp->btm_remarks }}</td>
			</tr>
		</tbody>
	</table>
@endsection
