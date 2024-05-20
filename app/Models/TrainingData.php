<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingData extends Model
{
	use HasFactory;
	protected $guarded = ['id', 'created_at', 'updated_at'];
	public static array $rules = [
		'nama' => ['bail', 'required', 'string'],
		'status' => ['bail', 'required', 'boolean'],
		'q' => 'required',
		'q.*' => ['bail', 'required', 'numeric']
	], $filerule = [
		'data' => [
			'bail',
			'required',
			'file',
			'mimetypes:application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.oasis.opendocument.spreadsheet,text/csv,text/tab-separated-values'
		]
	];
}
