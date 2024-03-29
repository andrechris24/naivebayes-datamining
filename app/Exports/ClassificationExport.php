<?php

namespace App\Exports;

use App\Models\Classification;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ClassificationExport implements FromQuery, WithHeadings, WithMapping
{
	use Exportable;
	public function __construct(string $type)
	{
		$this->type = $type;
		$this->idx = 0;
	}
	public function headings(): array
	{
		return array(
			'#',
			'Nama', 
			'Layak',
			'Tidak Layak',
			'Kelas Prediksi',
			'Kelas Asli');
	}
	/**
	 * @return \Illuminate\Support\Collection
	 */
	public function query()
	{
		if($this->type==='train'||$this->type==='test') 
			return Classification::query()->where('type',$this->type);
		return Classification::query();
	}
	public function map($class): array
	{
		return array(
			++$this->idx, 
			$class->name, 
			$class->layak,
			$class->tidak_layak,
			$class->predicted,
			$class->real
		);
	}
}
