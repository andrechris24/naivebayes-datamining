<?php

namespace Database\Seeders;

use App\Models\NilaiAtribut;
use Illuminate\Database\Seeder;

class NilaiAtributSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		NilaiAtribut::insert([
			['atribut_id' => 1, 'name' => 'Milik sendiri'],
			['atribut_id' => 1, 'name' => 'Menumpang'],
			['atribut_id' => 1, 'name' => 'Sewa'],
			['atribut_id' => 2, 'name' => 'Wiraswasta'],
			['atribut_id' => 2, 'name' => 'Wirausaha'],
			['atribut_id' => 2, 'name' => 'Buruh'],
			['atribut_id' => 2, 'name' => 'Pensiunan'],
			['atribut_id' => 2, 'name' => 'Guru'],
			['atribut_id' => 2, 'name' => 'Karyawan swasta'],
			['atribut_id' => 2, 'name' => 'Catering'],
			['atribut_id' => 4, 'name' => '450 VA'],
			['atribut_id' => 4, 'name' => '900 VA']
		]);
	}
}
