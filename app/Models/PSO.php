<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PSO extends Model
{
	use HasFactory;
	protected $fillable = [
		'atribut',
		'loop',
		'data',
		'velocity',
		'function',
		'pbest',
		'gbest'
	];
	public static array $rules = ['loop' => ['bail', 'required', 'between:1,20']];
}
