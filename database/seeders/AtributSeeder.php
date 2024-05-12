<?php

namespace Database\Seeders;

use App\Models\Atribut;
use Illuminate\Database\Seeder;

class AtributSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		Atribut::insert([
			[
				'name' => 'Kepemilikan Rumah', 
				'slug' => 'kepemilikan_rumah', 
				'type' => 'categorical'
			],
			['name' => 'Pekerjaan', 'slug' => 'pekerjaan', 'type' => 'categorical'],
			['name' => 'Penghasilan', 'slug' => 'penghasilan', 'type' => 'numeric'],
			['name' => 'Listrik', 'slug' => 'listrik', 'type' => 'categorical'],
			['name' => 'Tanggungan', 'slug' => 'tanggungan', 'type' => 'numeric']
		]);
	}
}
