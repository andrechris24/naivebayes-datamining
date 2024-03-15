<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestingDataTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		\App\Models\TestingData::insert(
			array (
					array (
						'nama' => 'Hendrik Hidayat',
						'kepemilikan_rumah' => 1,
						'pekerjaan' => 4,
						'penghasilan' => 1800000,
						'listrik' => 11,
						'tanggungan' => 2,
						'status' => 'Layak'
					),
					array (
						'nama' => 'Fadilah Umaya',
						'kepemilikan_rumah' => 1,
						'pekerjaan' => 4,
						'penghasilan' => 1200000,
						'listrik' => 11,
						'tanggungan' => 2,
						'status' => 'Layak'
					),
					array (
						'nama' => 'Erna',
						'kepemilikan_rumah' => 2,
						'pekerjaan' => 4,
						'penghasilan' => 1500000,
						'listrik' => 12,
						'tanggungan' => 5,
						'status' => 'Layak'
					),
					array (
						'nama' => 'Suriati',
						'kepemilikan_rumah' => 2,
						'pekerjaan' => 5,
						'penghasilan' => 2200000,
						'listrik' => 12,
						'tanggungan' => 6,
						'status' => 'Tidak Layak'
					),
					array (
						'nama' => 'Zulkarnain',
						'kepemilikan_rumah' => 1,
						'pekerjaan' => 7,
						'penghasilan' => 2000000,
						'listrik' => 12,
						'tanggungan' => 6,
						'status' => 'Tidak Layak'
					),
					array (
						'nama' => 'Misni',
						'kepemilikan_rumah' => 1,
						'pekerjaan' => 5,
						'penghasilan' => 1800000,
						'listrik' => 12,
						'tanggungan' => 2,
						'status' => 'Tidak Layak'
					),
					array (
						'nama' => 'Harya Ningsih',
						'kepemilikan_rumah' => 1,
						'pekerjaan' => 9,
						'penghasilan' => 1000000,
						'listrik' => 11,
						'tanggungan' => 1,
						'status' => 'Layak'
					),
					array (
						'nama' => 'Rika Sri Wahyuni',
						'kepemilikan_rumah' => 1,
						'pekerjaan' => 6,
						'penghasilan' => 1000000,
						'listrik' => 11,
						'tanggungan' => 2,
						'status' => 'Layak'
					),
					array (
						'nama' => 'Yusni',
						'kepemilikan_rumah' => 2,
						'pekerjaan' => 9,
						'penghasilan' => 1600000,
						'listrik' => 12,
						'tanggungan' => 5,
						'status' => 'Layak'
					),
					array (
						'nama' => 'Eka Jurita Tarigan',
						'kepemilikan_rumah' => 3,
						'pekerjaan' => 5,
						'penghasilan' => 1300000,
						'listrik' => 12,
						'tanggungan' => 2,
						'status' => 'Layak'
					),
					array (
						'nama' => 'Astutiana',
						'kepemilikan_rumah' => 3,
						'pekerjaan' => 4,
						'penghasilan' => 800000,
						'listrik' => 12,
						'tanggungan' => 1,
						'status' => 'Layak'
					),
					array (
						'nama' => 'Bambang Hardianto',
						'kepemilikan_rumah' => 1,
						'pekerjaan' => 4,
						'penghasilan' => 2000000,
						'listrik' => 12,
						'tanggungan' => 3,
						'status' => 'Tidak Layak'
					),
					array (
						'nama' => 'Ridawati',
						'kepemilikan_rumah' => 1,
						'pekerjaan' => 4,
						'penghasilan' => 2000000,
						'listrik' => 12,
						'tanggungan' => 5,
						'status' => 'Tidak Layak'
					),
					array (
						'nama' => 'Wirda Zendrato',
						'kepemilikan_rumah' => 1,
						'pekerjaan' => 4,
						'penghasilan' => 3500000,
						'listrik' => 12,
						'tanggungan' => 5,
						'status' => 'Tidak Layak'
					),
					array (
						'nama' => 'Hariani',
						'kepemilikan_rumah' => 1,
						'pekerjaan' => 4,
						'penghasilan' => 1200000,
						'listrik' => 11,
						'tanggungan' => 3,
						'status' => 'Layak'
					),
					array (
						'nama' => 'Rahmadhani',
						'kepemilikan_rumah' => 1,
						'pekerjaan' => 9,
						'penghasilan' => 1300000,
						'listrik' => 11,
						'tanggungan' => 2,
						'status' => 'Layak'
					)
			)
		);
	}
}
