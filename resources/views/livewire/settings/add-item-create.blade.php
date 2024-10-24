<div>
	<div class="col-sm-12">
		<form wire:submit.prevent="store">
			@csrf
			<!-- category -->
			<x-input-label for="cat" class="mt-3" :value="__('Category : ')" />
			<x-select-input id="cat" wire:model="category_id" class="{{ ($errors->has('category_id')?'is-invalid':NULL) }}" >
				@foreach($cat as $k => $v)
				<option value="{{ $v->id }}" :true="{{ ((old('category_id' == $v->id)?'true':NULL)) }}">{{ $v->category }}</option>
				@endforeach
			</x-select-input>
			<x-input-error id="cat" :messages="$errors->get('category_id')" />

			<!-- item -->
			<x-input-label for="it" class="mt-3" :value="__('Item : ')" />
			<x-text-input id="it" wire:model="item" :value="old('item')" class="{{ ($errors->has('item')?'is-invalid':NULL) }}" />
			<x-input-error id="it" :messages="$errors->get('item')" />

			<!-- brand -->
			<x-input-label for="br" class="mt-3" :value="__('Brand : ')" />
			<x-text-input id="br" wire:model="brand" :value="old('brand')" class="{{ ($errors->has('brand')?'is-invalid':NULL) }}" />
			<x-input-error id="br" :messages="$errors->get('brand')" />

			<!-- model -->
			<x-input-label for="mo" class="mt-3" :value="__('Model : ')" />
			<x-text-input id="mo" wire:model="model" :value="old('model')" class="{{ ($errors->has('model')?'is-invalid':NULL) }}" />
			<x-input-error id="mo" :messages="$errors->get('model')" />

			<!-- serial_number -->
			<x-input-label for="sr" class="mt-3" :value="__('Serial Number : ')" />
			<x-text-input id="sr" wire:model="serial_number" :value="old('serial_number')" class="{{ ($errors->has('serial_number')?'is-invalid':NULL) }}" />
			<x-input-error id="sr" :messages="$errors->get('serial_number')" />

			<!-- description -->
			<x-input-label for="desc" class="mt-3" :value="__('Description : ')" />
			<x-textarea-input id="desc" wire:model="description" :value="old('description')" class="{{ ($errors->has('description')?'is-invalid':NULL) }}" >
				{{ old('description') }}
			</x-textarea-input>
			<x-input-error id="desc" :messages="$errors->get('description')" />

			<x-primary-button type="submit" class="m-3">
				{{ __('Add Item') }}
			</x-primary-button>
		</form>
	</div>
</div>
