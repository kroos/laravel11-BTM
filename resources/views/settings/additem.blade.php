<x-app-layout>

	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Add Item') }}
		</h2>
	</x-slot>

	<div class="col-sm-12 row">
		<div class="col-sm-6 p-1 mx-auto">
			@livewire('Settings.AddCategoryCreate')
			@livewire('Settings.AddCategory')
		</div>
		<div class="col-sm-6 p-1 mx-auto">
			<h3>Add Item</h3>
			@livewire('Settings.AddItemCreate')
		</div>
	</div>
	<div class="col-sm-12 row">
		@livewire('Settings.AddItem')
	</div>

</x-app-layout>
