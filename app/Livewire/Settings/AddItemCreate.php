<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;

use App\Models\Settings\Category;
use App\Models\Settings\Item;

class AddItemCreate extends Component
{

	#[Rule('required', 'Category')]
	public $category_id;

	#[Rule('required|string', 'Item')]
	public $item;

	#[Rule('string|nullable', 'Brand')]
	public $brand;

	#[Rule('string|nullable', 'Model')]
	public $model;

	#[Rule('string|nullable', 'Serial Number')]
	public $serial_number;

	#[Rule('required|string', 'Description')]
	public $description;

	// public function mount()
	// {
	// 	$this->cat = Category::all();
	// }


	public function store()
	{
		$this->validate();
		Item::create([
			'category_id' => $this->category_id,
			'item' => $this->item,
			'brand' => $this->brand,
			'model' => $this->model,
			'serial_number' => $this->serial_number,
			'description' => $this->description,
		]);
		$this->reset();
		$this->dispatch('AddItemCreate');
	}

	#[On('AddCategoryCreate')]
	public function render()
	{
		return view('livewire.settings.add-item-create', [
			'cat' => Category::all(),
		]);
	}
}
