<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestingData extends Model
{
	use HasFactory;
	protected $guarded = ['id', 'created_at', 'updated_at'];
	public static array $rules = [
		'nama' => 'required',
		'q' => 'required',
		'q.*' => ['bail', 'required', 'numeric'],
		'status' => ['bail', 'required', 'in:Layak,Tidak Layak,Otomatis']
	], $filerule = [
		'data' => [
			'bail',
			'required',
			'file',
			'mimetypes:application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.oasis.opendocument.spreadsheet,text/csv,text/tab-separated-values'
		]
	];
	public function nilaiatribut()
	{
		return $this->belongsTo(NilaiAtribut::class);
	}
}
