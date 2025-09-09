@extends('layouts.pdf-layout')

@section('title', '(BTM01) Borang Permohonan Alamat Emel Rasmi @unishams.edu.my')
@section('header-title', '(BTM01) Borang Permohonan Alamat Emel Rasmi @unishams.edu.my')

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
						{{ 'BTM-ER-'.\Carbon\Carbon::parse($email->created_at)->format('ym').str_pad( $email->id, 3, "0", STR_PAD_LEFT) }}
					</span>
				</td>
				<td>
					Tarikh Permohonan : <span class="bold">{{ \Carbon\Carbon::parse($email->created_at)->format('D, j F Y') }}</span>
				</td>
			</tr>
			<tr>
					<!-- <td colspan="2">
						<p class="bold underline">Terma & Syarat :</p>
						<ul>
								<li>Permohonan yang tidak lengkap tidak akan diproses</li>
								<li>Digalakkan untuk tidak menggunakan nombor, simbol, space, dash atau underscore sebagai email ID</li>
								<li>Digalakkan untuk menggunakan nama sendiri sebagai email ID</li> -->
							</ul>
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
							Nama : <span class="bold">{{ $email->belongstostaff->nama }}</span>
						</td>
						<td style="width: 50%;">
							KPB : <span class="bold">{{ $email->belongstostaff->belongstomanydepartment->first()->namajabatan }}</span>
						</td>
					</tr>
				</tbody>
				<thead>
					<tr>
						<th colspan="2"><span class="center">Emel ID Yang Dipohon</span></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td colspan="2">Jenis Emel : {{ ($email->group_email == 1)?'Emel Berkumpulan':'Emel Individu' }}</td>
					</tr>
					<tr>
						<td {!! ($email->group_email==1)?NULL:'colspan="2"' !!} style="padding: 0px;">
							<table style="margin-bottom: 0px;">
								<thead>
									<tr>
										<th>Cadangan Emel ID</th>
										<th>Emel ID Yang Diluluskan</th>
										<th>Katalaluan Sementara</th>
									</tr>
								</thead>
								<tbody>
									@foreach($email->hasmanyemailsuggestion()->get() as $v)
									<tr>
										<td>{{ $v->email_suggestion }}@unishams.edu.my</td>
										<td>{{ ($v->approved_email)?'Approved Email ID':NULL }}</td>
										<td>{{ $v->temp_password }}</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</td>
						@if($email->group_email==1)
						<td style="padding: 0px;">
							<table style="margin-bottom: 0px;">
								<thead>
									<tr>
										<th>Ahli Kumpulan</th>
										<th>Emel Ahli Kumpulan</th>
									</tr>
								</thead>
								<tbody>
									@foreach($email->hasmanyemailgroupmember()->get() as $v)
									<tr>
										<td>{{ \App\Models\Login::where('email', $v->email_staff)->first()->name }}</td>
										<td>{{ $v->email_staff }}</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</td>
						@endif
					</tr>
				</tbody>
				<thead>
					<tr>
						<th colspan="2"><span class="center red bold">*Peringatan Penting : Anda dikehendaki untuk menukar katalaluan sementara dengan segera setelah mendapat kelulusan daripada Bahagian Teknologi Maklumat.*</span></th>
					</tr>
				</thead>
				<thead>
					<tr>
						<th colspan="2"><span class="center">Sokongan Pengarah/Dekan/Ketua Jabatan</span></th>
					</tr>
				</thead>
				<tbody>
					<tr>
					</tr>
					<tr>
						<td>Nama : <span class="bold">{{ ($email->belongstoappr->nama) }}</span></td>
						<td>Tarikh : <span class="bold">{{ (!is_null($email->approver_date))?\Carbon\Carbon::parse($email->approver_date)->format('D, j F Y'):NULL }}</span></td>
					</tr>
					<tr>
						<td>Catatan : {{ $email->approver_remarks }}</td>
						<td>Status : <span class="bold">{{ $email->belongstoapproverstatusloan->status_approval }}</span></td>
					</tr>
					<tr>
						<td colspan="2"><span class="red bold">* Saya mengesahkan bahawa maklumat yang diberikan adalah benar dan untuk urusan rasmi.</span></td>
					</tr>
					<tr>
						<th colspan="2"><span class="center">UNTUK KEGUNAAN PEJABAT</span></th>
					</tr>
					<tr>
						<td colspan="2">
							Status Permohonan : <span class="bold">{{ $email->belongstostatusemail->status_loan }}</span>
						</td>
					</tr>
					<tr>
						<td>Nama : <span class="bold">{{ $email->belongstobtmappr->nama }}</span></td>
						<td>Tarikh : <span class="bold">{{ (!is_null($email->btm_date))?\Carbon\Carbon::parse($email->btm_date)->format('D, j M Y'):NULL }}</span></td>
					</tr>
					<tr>
						<td colspan="2">Catatan : {{ $email->btm_remarks }}</td>
					</tr>
				</tbody>
			</table>
@endsection
