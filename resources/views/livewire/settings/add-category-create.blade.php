<div>
	<h3>Add Category</h3>

	<div class="col-sm-12">
		<form wire:submit.prevent="store">
			@csrf
			<!-- category -->
			<x-input-label for="cat" :value="__('Category : ')" />
			<x-text-input id="cat" wire:model="category" :value="old('category')" class="{{ ($errors->has('category')? 'is-invalid' : NULL) }}"/>
			<x-input-error :messages="$errors->get('category')" />

			<x-primary-button type="submit" class="m-3">
				{{ __('Add Category') }}
			</x-primary-button>
		</form>
	</div>

</div>
