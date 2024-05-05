<?php

namespace App\Exports;

use App\Http\Controllers\ProbabLabel;
use App\Models\Atribut;
use App\Models\NilaiAtribut;
use App\Models\TestingData;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class TestingExport
implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithStrictNullComparison
{
	public function headings(): array
	{
		$col[] = '#';
		$col[] = "Nama";
		foreach (Atribut::get() as $value) $col[] = $value->name;
		$col[] = "Hasil";
		return $col;
	}
	/**
	 * @return \Illuminate\Support\Collection
	 */
	public function collection()
	{
		return TestingData::all();
	}
	public function map($test): array
	{
		$row[] = $test->id;
		$row[] = $test->nama;
		foreach (Atribut::get() as $val) {
			if ($val->type === 'categorical') {
				$foreign = NilaiAtribut::firstWhere('id', $test[$val->slug]);
				$row[] = $foreign->name;
			} else $row[] = $test[$val->slug];
		}
		$row[] = ProbabLabel::$label[$test->status];
		return $row;
	}
}
