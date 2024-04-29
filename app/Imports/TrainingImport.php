<?php

namespace App\Imports;

use App\Http\Controllers\ProbabLabel;
use App\Models\Atribut;
use App\Models\NilaiAtribut;
use App\Models\TrainingData;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class TrainingImport implements ToModel, WithHeadingRow, WithValidation
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
					$foreign = NilaiAtribut::firstWhere(
						'name',
						'like',
						"%{$row[$attr->slug]}%"
					);
					$row[$attr->slug] = $foreign->id;
				}
			}
			$rows[$attr->slug] = $row[$attr->slug];
		}
		$rows['status'] = array_search( //array_search dengan teknik case insensitive
			strtolower(trim($row['hasil'])),
			array_map('strtolower', ProbabLabel::$label)
		);
		return new TrainingData($rows);
	}
	public function rules(): array
	{
		$rules['nama'] = ['bail', 'required', 'string'];
		foreach (Atribut::get() as $attr) {
			if ($attr->type === 'categorical') $rules[$attr->slug] = 'string';
			else $rules[$attr->slug] = 'numeric';
		}
		$rules['hasil'] = 'required';
		return $rules;
	}
}
