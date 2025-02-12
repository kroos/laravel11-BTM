<x-app-layout>

	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Add Item') }}
		</h2>
	</x-slot>

	<div class="col-sm-12 d-flex align-items-center justify-content-between">
		<div class="col-sm-5 row justify-content-center p-1 m-0">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Add Category</h3>
				</div>
				<div class="card-body">
					@livewire('Settings.AddCategoryCreate')
					@livewire('Settings.AddCategory')
				</div>
			</div>
		</div>

		<div class="col-sm-5 row justify-content-center p-1 m-0">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Add Item</h3>
				</div>
				<div class="card-body">
					@livewire('Settings.AddItemCreate')
				</div>
			</div>
		</div>
	</div>

	<div class="col-sm-12 row mt-3">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Item List</h3>
			</div>
			<div class="card-body">
				@livewire('Settings.AddItem')
			</div>
		</div>
	</div>

</x-app-layout>
