<div>
	<div class="col-sm-12 table-responsive mt-3">
		<h2>Item List</h2>
		<table class="table table-sm table-hover" id="item" style="font-size: 12px;">
			<thead>
				<tr>
					<th class="scope">Category</th>
					<th class="scope">Item</th>
					<th class="scope">Brand</th>
					<th class="scope">Model</th>
					<th class="scope">Serial Number</th>
					<th class="scope">Description</th>
					<th class="scope">#</th>
				</tr>
			</thead>
			<tbody>
				@if($items->count())
					@foreach($items as $index => $item)
						<tr wire:key="{{ $item->id.now() }}">
							<td class="scope">{{ $item->belongstocategory->category }}</td>
							<td class="scope">{{ $item->item }}</td>
							<td class="scope">{{ $item->brand }}</td>
							<td class="scope">{{ $item->model }}</td>
							<td class="scope">{{ $item->serial_number }}</td>
							<td class="scope">{{ $item->description }}</td>
							<td class="scope">
								<i class="fa-1xs fa-solid fa-trash-can fa-beat" wire:click="del({{$item->id}})" wire:confirm="Are you sure?"></i>
							</td>
						</tr>
					@endforeach
				@endif
			</tbody>
		</table>
	</div>
</div>
