<x-app-layout>

	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Add Item') }}
		</h2>
	</x-slot>

	<div class="col-sm-12 row align-items-center justify-content-between">
		<div class="col-sm-5 row justify-content-center p-1 m-0">
			@livewire('Settings.AddCategoryCreate')
			@livewire('Settings.AddCategory')
		</div>
		<div class="col-sm-5 row justify-content-center p-1 m-0">
			<h3>Add Item</h3>
			@livewire('Settings.AddItemCreate')
		</div>
	</div>
	<div class="col-sm-12 row">
		@livewire('Settings.AddItem')
	</div>

</x-app-layout>
