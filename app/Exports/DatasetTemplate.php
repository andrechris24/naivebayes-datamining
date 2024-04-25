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
		$val['nama'] = Auth::user()->name;
		foreach (Atribut::get() as $attr) {
			$subval = [];
			$col[] = $attr->name;
			if ($attr->type === 'categorical') {
				foreach (NilaiAtribut::where('atribut_id', $attr->id)->get() as $sub) {
					$subval[] = $sub->name;
				}
				$val[$attr->slug] = $subval;
			} else $val[$attr->slug] = rand(1, 5);
		}
		$col[] = 'Hasil';
		$val['hasil'] = ProbabLabel::$label;
		yield $col;
		yield $val;
	}
}
