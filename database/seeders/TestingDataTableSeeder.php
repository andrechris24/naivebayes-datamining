<?php

namespace Database\Seeders;

use App\Models\TestingData;
use Illuminate\Database\Seeder;

class TestingDataTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TestingData::insert(
            array(
                array(
                    'nama' => 'Finta Ria',
                    'kepemilikan_rumah' => 3,
                    'pekerjaan' => 9,
                    'penghasilan' => 1300000,
                    'listrik' => 12,
                    'tanggungan' => 4,
                    'status' => 'Layak'
                ),
                array(
                    'nama' => 'Evi Samosir',
                    'kepemilikan_rumah' => 3,
                    'pekerjaan' => 6,
                    'penghasilan' => 1200000,
                    'listrik' => 12,
                    'tanggungan' => 4,
                    'status' => 'Layak'
                ),
                array(
                    'nama' => 'Reslin BR Hombing',
                    'kepemilikan_rumah' => 2,
                    'pekerjaan' => 4,
                    'penghasilan' => 2200000,
                    'listrik' => 12,
                    'tanggungan' => 4,
                    'status' => 'Tidak Layak'
                ),
                array(
                    'nama' => 'Yuyun Marhamah',
                    'kepemilikan_rumah' => 2,
                    'pekerjaan' => 9,
                    'penghasilan' => 2200000,
                    'listrik' => 12,
                    'tanggungan' => 5,
                    'status' => 'Tidak Layak'
                ),
                array(
                    'nama' => 'Nuraini Lubis',
                    'kepemilikan_rumah' => 2,
                    'pekerjaan' => 4,
                    'penghasilan' => 2500000,
                    'listrik' => 12,
                    'tanggungan' => 6,
                    'status' => 'Tidak Layak'
                ),
                array(
                    'nama' => 'Samsiar',
                    'kepemilikan_rumah' => 1,
                    'pekerjaan' => 6,
                    'penghasilan' => 2000000,
                    'listrik' => 11,
                    'tanggungan' => 6,
                    'status' => 'Layak'
                ),
                array(
                    'nama' => 'Sri Lindawati',
                    'kepemilikan_rumah' => 3,
                    'pekerjaan' => 4,
                    'penghasilan' => 2000000,
                    'listrik' => 11,
                    'tanggungan' => 5,
                    'status' => 'Layak'
                ),
                array(
                    'nama' => 'Siti Saerah',
                    'kepemilikan_rumah' => 3,
                    'pekerjaan' => 9,
                    'penghasilan' => 1800000,
                    'listrik' => 12,
                    'tanggungan' => 5,
                    'status' => 'Layak'
                ),
                array(
                    'nama' => 'Ely Safitri Handayani',
                    'kepemilikan_rumah' => 3,
                    'pekerjaan' => 6,
                    'penghasilan' => 800000,
                    'listrik' => 12,
                    'tanggungan' => 4,
                    'status' => 'Layak'
                ),
                array(
                    'nama' => 'Supiyah',
                    'kepemilikan_rumah' => 3,
                    'pekerjaan' => 5,
                    'penghasilan' => 1200000,
                    'listrik' => 11,
                    'tanggungan' => 2,
                    'status' => 'Layak'
                ),
                array(
                    'nama' => 'Sriati',
                    'kepemilikan_rumah' => 2,
                    'pekerjaan' => 8,
                    'penghasilan' => 4000000,
                    'listrik' => 11,
                    'tanggungan' => 4,
                    'status' => 'Tidak Layak'
                ),
                array(
                    'nama' => 'Nuraini',
                    'kepemilikan_rumah' => 2,
                    'pekerjaan' => 10,
                    'penghasilan' => 3500000,
                    'listrik' => 11,
                    'tanggungan' => 4,
                    'status' => 'Tidak Layak'
                ),
                array(
                    'nama' => 'Edywati',
                    'kepemilikan_rumah' => 3,
                    'pekerjaan' => 9,
                    'penghasilan' => 1800000,
                    'listrik' => 11,
                    'tanggungan' => 3,
                    'status' => 'Layak'
                ),
                array(
                    'nama' => 'Yusridah Yusuf',
                    'kepemilikan_rumah' => 3,
                    'pekerjaan' => 6,
                    'penghasilan' => 2000000,
                    'listrik' => 11,
                    'tanggungan' => 1,
                    'status' => 'Layak'
                ),
                array(
                    'nama' => 'Rusmiati',
                    'kepemilikan_rumah' => 3,
                    'pekerjaan' => 9,
                    'penghasilan' => 1200000,
                    'listrik' => 11,
                    'tanggungan' => 3,
                    'status' => 'Layak'
                ),
                array(
                    'nama' => 'Lestari',
                    'kepemilikan_rumah' => 3,
                    'pekerjaan' => 6,
                    'penghasilan' => 800000,
                    'listrik' => 11,
                    'tanggungan' => 1,
                    'status' => 'Layak'
                )
            )
        );
    }
}
