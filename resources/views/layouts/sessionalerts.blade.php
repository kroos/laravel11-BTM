<!-- IF STATUS -->
@if(Session::has('status'))
	<h6 class="pb-4 mb-4 border-bottom text-center alert alert-info">
		{{ Session::get('status') }}
	</h6>
@endif
