<?php

namespace App\Livewire\Settings;

use Livewire\Component;

use Illuminate\Support\Str;
use Livewire\Attributes\On;

use App\Models\Settings\Item;

class AddItem extends Component
{
	public function del(Item $item)
	{
		$item->delete();
		// $this->dispatch('');
	}

	#[On('AddItemCreate')]
	public function render()
	{
		return view('livewire.settings.add-item', [
			'items' => Item::all(),
		]);
	}
}
