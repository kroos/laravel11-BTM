<?php
\Auth::user()->setConnection('mysql3');
\Auth::user()->unreadNotifications->markAsRead();
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>BTM Email Registration Form</title>
	<style>
/* Set A4 size */
* {
	margin: 0;
	padding: 0;
	box-sizing: border-box;
}

@page {
	size:  21cm 29.7cm;
	margin: 0;
}

/* Set content to fill the entire A4 page */
html,
body {
	width: 210mm;
	height: 297mm;
	margin: 0;
	padding: 0;
	display: flex;
	justify-content: center;
	align-items: center;
	font-size: 12px; /* Set default font size for the body */
}

/* Style content with shaded background */
.content {
	width: 90%;
	height: 90%;
	padding: 30;
	box-sizing: border-box;
	font-family: Arial, sans-serif;
	background-color: #f0f0f0; /* Light gray shade */
}

/* Center class for centering elements */
.center {
	display: flex;
	justify-content: center;
	align-items: center;
	text-align: center;
}

/* Page break styles */
.page-break {
	page-break-before: always; /* Start a new page before the element */
	page-break-after: always; /* Or, start a new page after the element */
}

/* Headings styles with font sizes */
h1 {
	font-size: 24px;
	font-weight: bold;
	text-align: center;
	margin-bottom: 20px;
}

h2 {
	font-size: 20px;
	font-weight: bold;
	margin-bottom: 15px;
}

h3 {
	font-size: 18px;
	font-weight: bold;
	margin-bottom: 10px;
}

/* Paragraph styles with font size */
p {
	font-size: 14px;
	line-height: 1.6;
	margin-bottom: 15px;
}

/* Bold and underline styles */
.bold {
	font-weight: bold;
}

.red {
	color: red;
}

.underline {
	text-decoration: underline;
}

/* Unordered list styles */
ul {
	list-style-type: disc;
	margin-left: 20px;
	margin-bottom: 15px;
	font-size: 14px; /* Set font size for unordered lists */
}

/* Ordered list styles */
ol {
	list-style-type: decimal;
	margin-left: 20px;
	margin-bottom: 15px;
	font-size: 14px; /* Set font size for ordered lists */
}

/* Table styles */
table {
	width: 100%;
	border-collapse: collapse;
	margin-bottom: 20px;
	font-size: 14px; /* Set font size for table content */
	page-break-inside: auto;
}

th,
td {
	border: 1px solid #ccc;
	padding: 10px;
	text-align: left;
	page-break-inside: avoid;
}

th {
	background-color: #d9e9ff; /* Light blue background */
	font-weight: bold;
}

tr:nth-child(even) {
	background-color: #f0f0f0; /* Light gray background for even rows */
}

	</style>
</head>

<body>
<div class="content">
	<!-- Your content goes here -->
	<h1>Borang Permohonan Akaun Email Rasmi @unishams.edu.my</h1>

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
					<td colspan="2">
						<p class="bold underline">Terma & Syarat :</p>
						<ul>
								<li>Permohonan yang tidak lengkap tidak akan diproses</li>
								<li>Digalakkan untuk tidak menggunakan nombor, simbol, space, dash atau underscore sebagai email ID</li>
								<li>Digalakkan untuk menggunakan nama sendiri sebagai email ID</li>
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
						Kuliyyah : <span class="bold">{{ $email->belongstostaff->belongstomanydepartment->first()->namajabatan }}</span>
					</td>
				</tr>
			</tbody>
			<thead>
				<tr>
					<th colspan="2"><span class="center">Email ID Yang Dipohon</span></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="2">Jenis Akaun : {{ ($email->group_email == 1)?'Email Berkumpulan':'Email Individu' }}</td>
				</tr>
				<tr>
					<td {!! ($email->group_email==1)?NULL:'colspan="2"' !!} style="padding: 0px;">
						<table style="margin-bottom: 0px;">
							<thead>
								<tr>
									<th>Cadangan Email ID</th>
									<th>Email ID Yang Diluluskan</th>
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
										<th>Email Ahli Kumpulan</th>
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
					<th colspan="2"><span class="center red bold">*Peringatan Penting : Anda dikehendaki untuk menukar katalaluan sementara dengan segera setelah mendapat kelulusan dari Bahagian Teknologi Maklumat.*</span></th>
				</tr>
			</thead>
			<thead>
				<tr>
					<th colspan="2"><span class="center">Kelulusan Pengarah/Dekan/Ketua Jabatan</span></th>
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
					<th colspan="2"><span class="center">Untuk Kegunaan Pejabat</span></th>
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
</div>
</body>
</html>
