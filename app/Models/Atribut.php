<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atribut extends Model
{
	use HasFactory;
	protected $fillable = ['name', 'slug', 'type', 'desc'];
	public static array $rules = [
		'name' => 'required',
		'type' => ['bail', 'required', 'in:numeric,categorical']
	];
	public static array $tipe = [
		'numeric' => 'Numerik',
		'categorical' => 'Kategoris'
	];
	public function nilai_atribut()
	{
		return $this->hasOne(NilaiAtribut::class, 'atribut_id');
	}
	public function probability()
	{
		return $this->hasOne(Probability::class, 'atribut_id');
	}
}
