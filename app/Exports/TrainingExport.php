<?php

namespace App\Exports;

use App\Models\Atribut;
use App\Models\NilaiAtribut;
use App\Models\TrainingData;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TrainingExport implements FromCollection, WithHeadings, WithMapping
{
	public function headings(): array
	{
		$col[] = '#';
		$col[] = "Nama";
		foreach (Atribut::get() as $value) $col[] = $value->name;
		$col[] = "Keterangan";
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
		$row[] = $train->status;
		return $row;
	}
}
