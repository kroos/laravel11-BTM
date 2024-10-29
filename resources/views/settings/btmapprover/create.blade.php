<x-app-layout>

	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Add BTM Approver') }}
		</h2>
	</x-slot>

	<div class="col-sm-12 d-flex justify-content-center">
		<p>Just checked on the name and you will be fine.</p>
		<form action="#" method="PATCH">
			@csrf
			@if($stfbtm->count())
				@foreach($stfbtm as $v)
					<div class="form-check m-3">
						<input class="form-check-input cnostaf" type="checkbox" name="nostaf[]" id="{{ $v['nostaf'] }}" value="1" data-id="{{ $v['nostaf'] }}" {{ ($v->hasmanybtmapprover()->where('active', 1)->count())?'checked=checked':NULL }}>
						<label class="form-check-label" for="{{ $v['nostaf'] }}">
							{!! $v['nostaf'].'&nbsp;->&nbsp;'.$v['nama'] !!}
						</label>
					</div>
				@endforeach
			@endif
	</div>

@section('js')
/////////////////////////////////////////////////////////////////////////////////////////
$('.cnostaf').change(function() {
	// console.log($(this).prop('checked'));
	// console.log($(this).val());		// cant rely on value, always give value 1 even if its unchecked

	var dat = $.ajax({
		url: "{{ route('btmapprover.store') }}",
		type: "POST",
		data : {
					nostaf: $(this).data('id'),
					active: $(this).prop('checked'),
					_token: '{!! csrf_token() !!}',
				},
		dataType: 'json',
		global: false,
		async:false,
		success: function (response) {
			return response;
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.log(textStatus, errorThrown);
		}
	}).responseText;
	var data = $.parseJSON( dat );
	console.log(data.active);
	$("label[for='"+$(this).attr("id")+"']").text(data.active);
	swal.fire('', data.message, data.status);
	// alert(data.status);
});

/////////////////////////////////////////////////////////////////////////////////////////
@endsection
</x-app-layout>
