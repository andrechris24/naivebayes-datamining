<?php

namespace App\Exports;

use App\Http\Controllers\ProbabLabel;
use App\Models\Atribut;
use App\Models\NilaiAtribut;
use Generator;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromGenerator;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class DatasetTemplate implements FromGenerator, WithStrictNullComparison
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
					$count = count($subval);
					$val[$attr->slug] = $subval[$a % $count]->name;
				} else $val[$attr->slug] = rand(0, 1);
			}
			$val['status'] = ProbabLabel::$label[$a % 2];
			yield $val;
		}
	}
}
