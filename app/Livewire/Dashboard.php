<?php

namespace App\Livewire;

use App\Models\TestingData;
use App\Models\TrainingData;
use Livewire\Component;

class Dashboard extends Component
{
	public function render()
	{
		$data = [
			'test' => TestingData::count(),
			'train' => TrainingData::count(),
			'all' => TestingData::count() + TrainingData::count()
		];
		return view('livewire.dashboard', $data);
	}
}
