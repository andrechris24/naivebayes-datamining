<?php

namespace App\Imports;

use App\Http\Controllers\ProbabLabel;
use App\Models\Atribut;
use App\Models\NilaiAtribut;
use App\Models\TestingData;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TestingImport implements ToModel, WithHeadingRow
{
	/**
	 * @param array $row
	 *
	 * @return \Illuminate\Database\Eloquent\Model|null
	 */
	public function model(array $row)
	{
		$rows = [];
		$atrib = Atribut::get();
		$rows['nama'] = $row['nama'];
		foreach ($atrib as $attr) {
			if ($attr->type === 'categorical') {
				if (empty($row[$attr->slug])) $row[$attr->slug] = null;
				else {
					$foreign = NilaiAtribut::firstWhere('name', 'like', "%{$row[$attr->slug]}%");
					$row[$attr->slug] = $foreign->id;
				}
			}
			$rows[$attr->slug] = $row[$attr->slug];
		}
		$rows['status'] = array_search( //array_search dengan teknik case insensitive
			strtolower(trim($row['keterangan'])),
			array_map('strtolower', ProbabLabel::$label)
		);
		return new TestingData($rows);
	}
}
