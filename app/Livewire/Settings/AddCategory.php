<?php

namespace App\Livewire\Settings;

use App\Models\Settings\Category;
use Illuminate\Support\Str;
use Livewire\Attributes\On;

use Livewire\Component;

class AddCategory extends Component
{
	#[On('AddCategoryCreate')]
	public function render()
	{
		return view('livewire.settings.add-category', [
			'categories' => Category::all(),
		]);
	}

	public function del(Category $category)
	{
		$category->delete();
		// $this->dispatch('');
	}

}
