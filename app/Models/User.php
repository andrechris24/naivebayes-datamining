<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
	use HasApiTokens, HasFactory, Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = ['name', 'email', 'password'];

	/**
	 * The attributes that should be hidden for serialization.
	 *
	 * @var array<int, string>
	 */
	protected $hidden = ['password', 'remember_token'];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = ['email_verified_at' => 'datetime', 'password' => 'hashed'];
	public static array $rules = [
			'name' => ['bail', 'required', 'string'],
			'email' => ['bail', 'required', 'email', 'unique:users'],
			'password' => ['bail', 'required', 'confirmed', 'between:8,20'],
			'password_confirmation' => 'required'
		], $updrules = [
			'name' => ['bail', 'required', 'string'],
			'email' => ['bail', 'required', 'email', 'unique:users'],
			'current_password' => ['bail', 'required', 'current_password'],
			'password' => ['nullable', 'bail', 'confirmed', 'between:8,20'],
			'password_confirmation' => 'required_with:password'
		], $loginrules = [
			'email' => ['bail', 'required', 'email'],
			'password' => ['bail', 'required', 'between:8,20']
		], $forgetrules = ['email' => ['bail', 'required', 'email', 'exists:users']],
		$resetrules = [
			'email' => ['bail', 'required', 'email', 'exists:users'],
			'password' => ['bail', 'required', 'confirmed', 'between:8,20'],
			'password_confirmation' => 'required',
			'token' => 'required'
		], $delrules = [
			'confirm_pass' => ['bail', 'required', 'current_password', 'between:8,20']
		], $userrules = [
			'name' => ['bail', 'required', 'string'],
			'email' => ['bail', 'required', 'email', 'unique:users'],
			'current_password' => ['bail', 'required', 'current_password', 'between:8,20'],
			'password' => ['bail', 'required', 'confirmed', 'between:8,20'],
			'password_confirmation' => 'required',
		];
}
