<?php

namespace App\Livewire\Settings;

use App\Models\Settings\Categories;
use Illuminate\Support\Str;
use Livewire\Attributes\On;

use Livewire\Component;

class AddCategory extends Component
{

	#[On('AddCategoryCreate')]
	public function render()
	{
		return view('livewire.settings.add-category', [
			'categories' => Categories::all(),
		]);
	}

	// public function del(Category $cicategories)
	// {
	// 	$cicategories->delete();
	// 	$this->dispatch('cicategorydel');
	// }

}
