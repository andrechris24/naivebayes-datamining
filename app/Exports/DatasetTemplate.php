<?php

namespace App\Exports;

use App\Http\Controllers\ProbabLabel;
use App\Models\Atribut;
use App\Models\NilaiAtribut;
use Generator;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromGenerator;

class DatasetTemplate implements FromGenerator
{
	use Exportable;
	public function generator(): Generator
	{
		$col[] = 'Nama';
		$val[] = Auth::user()->name;
		foreach (Atribut::get() as $attr) {
			$col[] = $attr->name;
			if ($attr->type === 'categorical') {
				$val[] = NilaiAtribut::select('name')->where('atribut_id', $attr->id)
					->get();
			} else $val[] = rand(1, 5);
		}
		$col[] = 'Keterangan';
		$val[] = json_encode(ProbabLabel::$status);
		yield $col;
		yield $val;
	}
}
