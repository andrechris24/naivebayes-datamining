<?php

namespace App\Exports;

use App\Http\Controllers\ProbabLabel;
use App\Models\Atribut;
use App\Models\NilaiAtribut;
use App\Models\TrainingData;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class TrainingExport
implements FromCollection, WithHeadings, WithMapping, WithStrictNullComparison
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
		return TrainingData::all();
	}
	public function map($train): array
	{
		$row[] = $train->id;
		$row[] = $train->nama;
		foreach (Atribut::get() as $val) {
			if ($val->type === 'categorical') {
				$foreign = NilaiAtribut::firstWhere('id', $train[$val->slug]);
				$row[] = $foreign->name;
			} else $row[] = $train[$val->slug];
		}
		$row[] = ProbabLabel::$label[$train->status];
		return $row;
	}
}
