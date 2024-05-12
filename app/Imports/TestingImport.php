<?php

namespace App\Imports;

use App\Http\Controllers\ProbabLabel;
use App\Models\Atribut;
use App\Models\NilaiAtribut;
use App\Models\TestingData;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class TestingImport implements ToModel, WithHeadingRow, WithValidation
{
	/**
	 * @param array $row
	 *
	 * @return \Illuminate\Database\Eloquent\Model|null
	 */
	public function model(array $row)
	{
		$rows = [];
		$rows['nama'] = ucfirst($row['nama']);
		foreach (Atribut::get() as $attr) {
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
		$rows['status'] = array_search( //array_search secara case insensitive
			strtolower(trim($row['status'])),
			array_map('strtolower', ProbabLabel::$label)
		);
		return new TestingData($rows);
	}
	public function rules(): array
	{
		$rules['nama'] = ['bail', 'required', 'string'];
		foreach (Atribut::get() as $attr) {
			if ($attr->type === 'categorical') $rules[$attr->slug] = 'string';
			else $rules[$attr->slug] = 'numeric';
		}
		$rules['status'] = ['bail','required',Rule::in(ProbabLabel::$label)];
		return $rules;
	}
}
