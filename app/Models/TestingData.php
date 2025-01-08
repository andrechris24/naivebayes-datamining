<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Factories\HasFactory, Model};

class TestingData extends Model
{
	use HasFactory;
	protected $guarded = ['id', 'created_at', 'updated_at'];
	public static array $rules = [
		'nama' => ['bail', 'required', 'string'],
		'q' => 'required',
		'q.*' => ['bail', 'required', 'numeric'],
		'status' => ['bail', 'required', 'in:1,0,true,false,auto']
	], $filerule = [
		'data' => [
			'bail',
			'required',
			'file',
			'mimetypes:application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.oasis.opendocument.spreadsheet,text/csv,text/tab-separated-values'
		]
	];
}
