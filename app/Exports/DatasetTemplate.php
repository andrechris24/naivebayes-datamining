<?php

namespace App\Exports;

use App\Http\Controllers\ProbabLabel;
use App\Models\Atribut;
use App\Models\NilaiAtribut;
use Generator;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromGenerator;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class DatasetTemplate
implements FromGenerator, ShouldAutoSize, WithStrictNullComparison
{
	use Exportable;
	public function generator(): Generator
	{
		$col[] = 'Nama';
		$totalattr = array();
		foreach (Atribut::get() as $attr) {
			$totalattr[] = NilaiAtribut::where('atribut_id', $attr->id)->count();
			$col[] = $attr->name;
		}
		$col[] = 'Status';
		yield $col;
		for ($a = 0; $a < collect($totalattr)->max(); $a++) {
			$val['nama'] = Auth::user()->name;
			foreach (Atribut::get() as $attr) {
				if ($attr->type === 'categorical') {
					$subval = NilaiAtribut::where('atribut_id', $attr->id)->get();
					$val[$attr->slug] = $subval[$a % count($subval)]->name;
				} else $val[$attr->slug] = rand(0, 2);
			}
			$val['status'] = ProbabLabel::$label[$a % 2];
			yield $val;
		}
	}
}
