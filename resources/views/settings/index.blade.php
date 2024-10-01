<x-app-layout>

	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Add Item') }}
		</h2>
	</x-slot>

	<div class="col-sm-12 row border border-primary">
		<div class="col-sm-6 p-1 mx-auto border border-warning">
			@livewire('Settings.AddCategoryCreate')
			@livewire('Settings.AddCategory')
		</div>
		<div class="col-sm-6 p-1 mx-auto border border-warning">
			<h3>Add Item</h3>
		</div>
	</div>

</x-app-layout>
