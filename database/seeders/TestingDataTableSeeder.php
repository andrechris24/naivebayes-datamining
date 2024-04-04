<?php

namespace Database\Seeders;

use App\Models\TestingData;
use Illuminate\Database\Seeder;

class TestingDataTableSeeder extends Seeder
{
	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		TestingData::insert(array(
			array(
				'nama' => 'Nurhayati',
				'kepemilikan_rumah' => 1,
				'pekerjaan' => 6,
				'penghasilan' => 800000,
				'listrik' => 11,
				'tanggungan' => 1,
				'status' => 'Layak'
			),
			array(
				'nama' => 'Asmawati',
				'kepemilikan_rumah' => 3,
				'pekerjaan' => 4,
				'penghasilan' => 1600000,
				'listrik' => 12,
				'tanggungan' => 5,
				'status' => 'Layak'
			),
			array(
				'nama' => 'Wirda Zendrato',
				'kepemilikan_rumah' => 1,
				'pekerjaan' => 4,
				'penghasilan' => 3500000,
				'listrik' => 12,
				'tanggungan' => 5,
				'status' => 'Tidak Layak'
			),
			array(
				'nama' => 'Nurasiah',
				'kepemilikan_rumah' => 2,
				'pekerjaan' => 7,
				'penghasilan' => 3000000,
				'listrik' => 12,
				'tanggungan' => 2,
				'status' => 'Tidak Layak'
			),
			array(
				'nama' => 'Astutiana',
				'kepemilikan_rumah' => 3,
				'pekerjaan' => 4,
				'penghasilan' => 800000,
				'listrik' => 12,
				'tanggungan' => 1,
				'status' => 'Layak'
			),
			array(
				'nama' => 'Rosita',
				'kepemilikan_rumah' => 1,
				'pekerjaan' => 5,
				'penghasilan' => 1200000,
				'listrik' => 11,
				'tanggungan' => 1,
				'status' => 'Layak'
			),
			array(
				'nama' => 'Dedi Irawan',
				'kepemilikan_rumah' => 2,
				'pekerjaan' => 10,
				'penghasilan' => 2500000,
				'listrik' => 12,
				'tanggungan' => 3,
				'status' => 'Tidak Layak'
			),
			array(
				'nama' => 'Halimah',
				'kepemilikan_rumah' => 3,
				'pekerjaan' => 9,
				'penghasilan' => 1500000,
				'listrik' => 12,
				'tanggungan' => 4,
				'status' => 'Layak'
			),
			array(
				'nama' => 'Eka Jurita Tarigan',
				'kepemilikan_rumah' => 3,
				'pekerjaan' => 5,
				'penghasilan' => 1300000,
				'listrik' => 12,
				'tanggungan' => 2,
				'status' => 'Layak'
			),
			array(
				'nama' => 'Apri Yanti Ningsih',
				'kepemilikan_rumah' => 3,
				'pekerjaan' => 6,
				'penghasilan' => 1200000,
				'listrik' => 11,
				'tanggungan' => 2,
				'status' => 'Layak'
			),
			array(
				'nama' => 'Sumarsih',
				'kepemilikan_rumah' => 2,
				'pekerjaan' => 6,
				'penghasilan' => 1600000,
				'listrik' => 12,
				'tanggungan' => 1,
				'status' => 'Tidak Layak'
			),
			array(
				'nama' => 'Syafitriani',
				'kepemilikan_rumah' => 3,
				'pekerjaan' => 9,
				'penghasilan' => 1600000,
				'listrik' => 12,
				'tanggungan' => 5,
				'status' => 'Layak'
			),
			array(
				'nama' => 'Erfina',
				'kepemilikan_rumah' => 2,
				'pekerjaan' => 4,
				'penghasilan' => 4000000,
				'listrik' => 12,
				'tanggungan' => 3,
				'status' => 'Tidak Layak'
			),
			array(
				'nama' => 'Jumaidah',
				'kepemilikan_rumah' => 2,
				'pekerjaan' => 8,
				'penghasilan' => 3000000,
				'listrik' => 12,
				'tanggungan' => 3,
				'status' => 'Tidak Layak'
			),
			array(
				'nama' => 'Wagiyah',
				'kepemilikan_rumah' => 1,
				'pekerjaan' => 5,
				'penghasilan' => 2500000,
				'listrik' => 12,
				'tanggungan' => 3,
				'status' => 'Tidak Layak'
			),
			array(
				'nama' => 'Tuti Erlinda',
				'kepemilikan_rumah' => 2,
				'pekerjaan' => 5,
				'penghasilan' => 800000,
				'listrik' => 11,
				'tanggungan' => 2,
				'status' => 'Layak'
			)
		));
	}
}
