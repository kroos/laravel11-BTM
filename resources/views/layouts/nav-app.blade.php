<!--
<li class="nav-item">
	<a class="nav-link {{ (request()->route()->uri == '')?'active':NULL }}" href="#">AUTH</a>
</li>
 -->

<li class="nav-item dropdown">
	<a class="nav-link dropdown-toggle active" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
		<i class="fa-solid fa-gear"></i> Setting
	</a>
	<div class="dropdown-menu">
		<a class="dropdown-item" href="{{ route('additem.index') }}">Add Item</a>
		<a class="dropdown-item" href="{{ route('addapprover.index') }}">Add Approver</a>
<!--
		<div class="dropdown-divider"></div>
		<a class="dropdown-item" href="#">Separated link</a>
 -->
	</div>
</li>
