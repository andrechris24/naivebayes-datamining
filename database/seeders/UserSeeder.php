<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class UserSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		app()[PermissionRegistrar::class]->forgetCachedPermissions();

		Permission::create(['name' => 'manage attributes']);
		Permission::create(['name' => 'manage datasets']);
		Permission::create(['name' => 'manage calculations']);
		Permission::create(['name' => 'manage users']);

		$role1 = Role::create(['name' => 'user']);
		$role1->givePermissionTo('manage datasets');
		$role1->givePermissionTo('manage calculations');

		$role2 = Role::create(['name' => 'admin']);
		$role2->givePermissionTo('manage users');
		$role2->givePermissionTo('manage attributes');
		$role2->givePermissionTo('manage datasets');
		$role2->givePermissionTo('manage calculations');

		$user = \App\Models\User::factory()->create([
			'name' => 'Test User',
			'email' => 'test@example.com'
		]);
		$user->assignRole($role1);

		$user = \App\Models\User::factory()->create([
			'name' => 'Administrator',
			'email' => 'admin@example.com'
		]);
		$user->assignRole($role2);
	}
}
