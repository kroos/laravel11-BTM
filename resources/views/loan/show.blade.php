<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>BTM Equipment Loan Form</title>
	<style>
/* Set A4 size */
* {
	margin: 0;
	padding: 0;
	box-sizing: border-box;
}

@page {
	size: A4;
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
	font-size: 14px; /* Set default font size for the body */
}

/* Style content with shaded background */
.content {
	width: 80%;
	height: 80%;
	padding: 20px;
	box-sizing: border-box;
	font-family: Arial, sans-serif;
	background-color: #f0f0f0; /* Light gray shade */
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

/* Center class for centering elements */
.center {
	display: flex;
	justify-content: center;
	align-items: center;
	text-align: center;
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
}

th,
td {
	border: 1px solid #ccc;
	padding: 10px;
	text-align: left;
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
								<p>Peralatan yang disediakan :</p>
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
						Tarikh Permohonan : <span class="bold">{{ \Carbon\Carbon::parse($loanapp->created_at)->format('D, j F Y') }}</span>
					</td>
				</tr>
				<tr>
					<td>
						Tarikh Mula Pinjam : <span class="bold">{{ \Carbon\Carbon::parse($loanapp->date_loan_from)->format('D, j F Y') }}</span>
					</td>
					<td>
						Tarikh Tamat Pinjam : : <span class="bold">{{ \Carbon\Carbon::parse($loanapp->date_loan_to)->format('D, j F Y') }}</span>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						Tempoh : <span class="bold">{{ \Carbon\Carbon::parse($loanapp->date_loan_to)->daysUntil($loanapp->date_loan_from, 1)->count() }} hari</span>.
					</td>
				</tr>
				<tr>
					<td colspan="2">
						Tujuan Pinjaman : {{ $loanapp->loan_purpose }}
					</td>
				</tr>
			</tbody>
	</table>
</div>
</body>

</html>
