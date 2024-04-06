<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Probability extends Model
{
	use HasFactory;
	protected $fillable = [
		'atribut_id',
		'nilai_atribut_id',
		'true',
		'false',
		'total',
		'mean_true',
		'mean_false',
		'mean_total',
		'sd_true',
		'sd_false',
		'sd_total'
	];
	public function atribut()
	{
		return $this->belongsTo(Atribut::class, 'atribut_id');
	}
	public function nilai_atribut()
	{
		return $this->belongsTo(NilaiAtribut::class, 'nilai_atribut_id');
	}
}
