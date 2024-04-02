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
	private string $tipe;
	private int $index = 0;
	public function __construct(string $type)
	{
		$tipe = $type;
	}
	public function headings(): array
	{
		return array(
			'#',
			'Nama',
			'Layak',
			'Tidak Layak',
			'Kelas Prediksi',
			'Kelas Asli'
		);
	}
	/**
	 * @return \Illuminate\Support\Collection
	 */
	public function query()
	{
		global $tipe;
		if ($tipe === 'train' || $tipe === 'test')
			return Classification::query()->where('type', $tipe);
		return Classification::query();
	}
	public function map($class): array
	{
		global $index;
		return array(
			++$index,
			$class->name,
			$class->layak ?? 0.00,
			$class->tidak_layak ?? 0.00,
			$class->predicted,
			$class->real
		);
	}
}
