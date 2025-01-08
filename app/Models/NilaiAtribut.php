<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Factories\HasFactory, Model};

class NilaiAtribut extends Model
{
	use HasFactory;
	protected $fillable = ['atribut_id', 'name'];
	public static array $rules = [
		'atribut_id' => ['bail', 'required', 'exists:atributs,id'],
		'name' => 'required'
	];
	public function atribut()
	{
		return $this->belongsTo(Atribut::class, 'atribut_id');
	}
	public function probability()
	{
		return $this->hasOne(Probability::class, 'nilai_atribut_id');
	}
	public function training_data()
	{
		return $this->hasMany(TrainingData::class);
	}
	public function testing_data()
	{
		return $this->hasMany(TestingData::class);
	}
}
