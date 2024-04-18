<?php

namespace App\Livewire;

use App\Exports\DatasetTemplate;
use Livewire\Component;

class DataTemplate extends Component
{
	public function download()
	{
		return (new DatasetTemplate)->download('template.xlsx');
	}
	public function render()
	{
		return view('livewire.data-template');
	}
}
