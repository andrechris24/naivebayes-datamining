<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Factories\HasFactory, Model};

class Classification extends Model
{
	use HasFactory;
	protected $fillable = ['name', 'type', 'true', 'false', 'predicted', 'real'];
	public static array $rule = ['tipe' => ['bail', 'required', 'in:train,test,all']],
		$tipedata = ['train' => 'Training', 'test' => 'Testing'];
}
