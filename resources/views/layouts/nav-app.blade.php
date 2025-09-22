<li class="nav-item">
	<a class="nav-link" href="{{ route('emailaccapp.index') }}">
		<i class="fa-regular fa-envelope fa-beat"></i>&nbsp;
		BTM01 - Emel Rasmi
	</a>
</li>
<li class="nav-item">
	<a class="nav-link" href="{{ route('regaccicms.index') }}">
		<i class="fa-regular fa-address-card fa-beat"></i>&nbsp;
		BTM02 - Pendaftaran Akaun & Modul ICMS
	</a>
</li>
<li>
	<a class="nav-link" href="{{ route('loanapp.index') }}">
		<i class="fa-solid fa-gavel fa-beat"></i>&nbsp;
		BTM03 - Pinjaman Peralatan
	</a>
</li>
<li class="nav-item dropdown">
	<a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
		<i class="fa-solid fa-gear fa-beat"></i>&nbsp;Setting
	</a>
	<div class="dropdown-menu">
			<a class="dropdown-item" href="{{ route('btmemailapplications.index') }}">(BTM01) BTM Email Registration Approval</a>
			<a class="dropdown-item" href="{{ route('btmicmsrequester.index') }}">(BTM02) BTM ICMS Registration Account Approval</a>
			<a class="dropdown-item" href="{{ route('btmloanapplications.index') }}">(BTM03) BTM Loan Approval</a>
		<div class="dropdown-divider"></div>
			<a class="dropdown-item" href="{{ route('additem.index') }}">Add Equipment</a>
			<a class="dropdown-item" href="{{ route('addapprover.index') }}">Add Department Approver</a>
			<a class="dropdown-item" href="{{ route('btmapprover.create') }}">Add BTM Approver</a>
	</div>
</li>
