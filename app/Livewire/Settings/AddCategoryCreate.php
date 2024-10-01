<?php

namespace App\Livewire\Settings;

use Livewire\Component;

use App\Models\Settings\Categories;

use Illuminate\Support\Str;
use Livewire\Attributes\Rule;

class AddCategoryCreate extends Component
{

	#[Rule('required|string|min:5', 'Category')]
	public $category;

	public function updated($property, $value)
	{
		if ($property == 'category') {
			$this->category = ucwords(Str::lower($value));
		}
	}

	public function store()
	{
		$this->validate();
		Categories::create(['category' => $this->category]);
		$this->reset();
		$this->dispatch('AddCategoryCreate');
		// $this->redirect(route('cicategory.index'), $navigate = true)->with('flash_message', 'Success create Category');
		// return redirect()->route('cicategory.index')->with('flash_message', 'Success create Category');
	}

	public function render()
	{
		return view('livewire.settings.add-category-create');
	}
}
