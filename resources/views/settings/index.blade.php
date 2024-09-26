<x-app-layout>

	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Add Item') }}
		</h2>
	</x-slot>

	<div class="col-sm-12 row">
		<div class="col-sm-5 p-2 m-1 d-flex flex-column align-items-center">
			<h3>Add Category</h3>

<!-- this should be livewire but need to relearn again.. -->
			<form method="POST" action="{{ route('login') }}" id="form" class="" >
				@csrf
				<!-- category -->
				<div class="form-group row mb-3">
					<x-input-label for="category" :value="__('Category : ')" />
					<x-text-input id="category" name="category" :value="old('category')" class="{{ $errors->has('category') ? 'is-invalid' : NULL }}"/>
					<x-input-error :messages="$errors->get('category')" />
				</div>

				<x-primary-button class="m-3">
					{{ __('Submit') }}
				</x-primary-button>
			</form>

		</div>
		<div class="col-sm-5 p-2 m-1 d-flex flex-column align-items-center">
			<h3>Add Item</h3>
		</div>
	</div>

</x-app-layout>
