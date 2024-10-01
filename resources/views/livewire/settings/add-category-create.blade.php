<div>
	<h3>Add Category</h3>

	<div class="col-sm-12 border border-primary">
		<form wire:submit.prevent="store">
			@csrf
			<!-- category -->
				<x-input-label for="category" :value="__('Category : ')" />
				<x-text-input id="category" wire:model.change="category" :value="old('category')" class="{{ $errors->has('category') ? 'is-invalid' : NULL }}"/>
				<x-input-error :messages="$errors->get('category')" />

			<x-primary-button class="m-3">
				{{ __('Add Category') }}
			</x-primary-button>
		</form>
	</div>

</div>
