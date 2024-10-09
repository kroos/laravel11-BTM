<div>
	<div class="col-sm-12 table-responsive mt-3">
		<table class="table table-sm table-hover" id="category" style="font-size: 12px;">
			<thead>
				<tr>
					<th class="scope">ID</th>
					<th class="scope">Category</th>
					<th class="scope">#</th>
				</tr>
			</thead>
			<tbody>
				@if($categories->count())
					@foreach($categories as $index => $category)
						<tr wire:key="{{ $category->id.now() }}">
							<td class="scope">{{ $index + 1 }}</td>
							<td class="scope">{{ $category->category }}</td>
							<td class="scope">
								<i class="fa-1xs fa-solid fa-trash-can fa-beat" wire:click="del({{$category->id}})" wire:confirm="Are you sure?"></i>
							</td>
						</tr>
					@endforeach
				@endif
			</tbody>
		</table>
	</div>
</div>
