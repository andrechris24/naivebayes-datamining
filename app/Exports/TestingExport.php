<?php

namespace App\Exports;

use App\Models\Atribut;
use App\Models\NilaiAtribut;
use App\Models\TestingData;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TestingExport implements FromCollection, WithHeadings, WithMapping
{
	public function headings(): array
	{
		$col[] = '#';
		$col[] = "Nama";
		foreach (Atribut::get() as $value)
			$col[] = $value->name;
		$col[] = "Keterangan";
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
			} else
				$row[] = $test[$val->slug];
		}
		$row[] = $test->status;
		return $row;
	}
}
