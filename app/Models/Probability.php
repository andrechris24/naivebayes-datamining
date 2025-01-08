<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Factories\HasFactory, Model};

class Probability extends Model
{
	use HasFactory;
	protected $fillable = ['atribut_id', 'nilai_atribut_id', 'true', 'false', 'total'];
	public function atribut()
	{
		return $this->belongsTo(Atribut::class, 'atribut_id');
	}
	public function nilai_atribut()
	{
		return $this->belongsTo(NilaiAtribut::class, 'nilai_atribut_id');
	}
	public static function probabKelas()
	{
		$total = TrainingData::count();
		if ($total === 0) $true = $false = 0;
		else {
			$true = TrainingData::where('status', true)->count() / $total;
			$false = TrainingData::where('status', false)->count() / $total;
		}
		return ['true' => $true, 'false' => $false];
	}
}
