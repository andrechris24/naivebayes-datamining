<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classification extends Model
{
	use HasFactory;
	protected $fillable = [
		'name', 'type', 'true', 'false', 'predicted', 'real'
	];
	public static array $rule = ['type' => ['bail', 'required', 'in:train,test,all']],
		$tipedata = ['train' => 'Training', 'test' => 'Testing'];
}
