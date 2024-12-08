<li class="nav-item">
	<a class="nav-link {{ (request()->route()->uri == 'emailaccapp')?'active':NULL }}" href="{{ route('emailaccapp.index') }}">
		<i class="fa-regular fa-envelope fa-beat"></i>&nbsp;
		Email Account Application
	</a>
</li>
<li>
	<a class="nav-link {{ (request()->route()->uri == 'loanapp')?'active':NULL }}" href="{{ route('loanapp.index') }}">
		<i class="fa-solid fa-gavel fa-beat"></i>&nbsp;
		Equipment Loan Application
	</a>
</li>
<li class="nav-item dropdown">
	<a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
		<i class="fa-solid fa-gear fa-beat"></i>&nbsp;Setting
	</a>
	<div class="dropdown-menu">
		<a class="dropdown-item" href="{{ route('additem.index') }}">Add Equipment</a>
		<a class="dropdown-item" href="{{ route('addapprover.index') }}">Add Department Approver</a>
		<a class="dropdown-item" href="{{ route('btmapprover.create') }}">Add BTM Approver</a>
		<div class="dropdown-divider"></div>
		<a class="dropdown-item" href="{{ route('btmloanapplications.index') }}">BTM Loan Approval</a>
	</div>
</li>
