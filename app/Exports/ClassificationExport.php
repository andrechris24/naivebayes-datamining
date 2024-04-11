<?php

namespace App\Exports;

use App\Http\Controllers\Controller;
use App\Models\Classification;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class ClassificationExport
implements FromQuery, WithHeadings, WithMapping, WithStrictNullComparison
{
	use Exportable;
	private string $tipe;
	private int $index = 0;
	public function __construct(string $type)
	{
		$this->tipe = $type;
	}
	public function headings(): array
	{
		return array(
			'#',
			'Nama',
			Controller::$status[true],
			Controller::$status[false],
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
			$class->true ?? 0.00,
			$class->false ?? 0.00,
			Controller::$status[$class->predicted],
			Controller::$status[$class->real]
		);
	}
}
