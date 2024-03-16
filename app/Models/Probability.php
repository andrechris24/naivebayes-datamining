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
		'layak',
		'tidak_layak',
		'total',
		'mean_layak',
		'mean_tidak_layak',
		'mean_total',
		'sd_layak',
		'sd_tidak_layak',
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
