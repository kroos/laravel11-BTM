<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>BTM Equipment Loan Form</title>
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
	<h1>Borang Pinjaman Peralatan</h1>

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
					<td colspan="2">
						Tujuan Pinjaman : <span class="bold">{{ $loanapp->loan_purpose }}</span>
					</td>
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
					<th colspan="2"><span class="center">Kelulusan Pengarah/Dekan/Ketua Jabatan</span></th>
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
					<td>Status : <span class="bold">{{ $loanapp->belongstostatusloan->status_loan }}</span></td>
				</tr>
				<tr>
					<th colspan="2"><span class="center">Untuk Kegunaan Pejabat</span></th>
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
</div>
</body>
</html>
