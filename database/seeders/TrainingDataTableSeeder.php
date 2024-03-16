<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TrainingDataTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('training_data')->delete();
        
        App\Models\TrainingData::insert(array (
            array (
                'nama' => 'Nurhayati',
                'kepemilikan_rumah' => 1,
                'pekerjaan' => 6,
                'penghasilan' => 800000,
                'listrik' => 11,
                'tanggungan' => 1,
                'status' => 'Layak'
            ),
            array (
                'nama' => 'Hartini',
                'kepemilikan_rumah' => 1,
                'pekerjaan' => 5,
                'penghasilan' => 1600000,
                'listrik' => 11,
                'tanggungan' => 3,
                'status' => 'Layak'
            ),
            array (
                'nama' => 'Dalima Lubis',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 5,
                'penghasilan' => 1600000,
                'listrik' => 12,
                'tanggungan' => 4,
                'status' => 'Layak'
            ),
            array (
                'nama' => 'Halimah',
                'kepemilikan_rumah' => 3,
                'pekerjaan' => 9,
                'penghasilan' => 1500000,
                'listrik' => 12,
                'tanggungan' => 4,
                'status' => 'Layak'
            ),
            array (
                'nama' => 'Maharani Laili',
                'kepemilikan_rumah' => 1,
                'pekerjaan' => 8,
                'penghasilan' => 4000000,
                'listrik' => 12,
                'tanggungan' => 3,
                'status' => 'Tidak Layak'
            ),
            array (
                'nama' => 'Marina',
                'kepemilikan_rumah' => 1,
                'pekerjaan' => 5,
                'penghasilan' => 3000000,
                'listrik' => 12,
                'tanggungan' => 3,
                'status' => 'Tidak Layak'
            ),
            array (
                'nama' => 'Asnindar',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 4,
                'penghasilan' => 3500000,
                'listrik' => 12,
                'tanggungan' => 5,
                'status' => 'Tidak Layak'
            ),
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
            ),
            array (
                'nama' => 'Armadani',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 9,
                'penghasilan' => 1800000,
                'listrik' => 12,
                'tanggungan' => 4,
                'status' => 'Layak'
            ),
            array (
                'nama' => 'Sumarsih',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 6,
                'penghasilan' => 1600000,
                'listrik' => 12,
                'tanggungan' => 1,
                'status' => 'Tidak Layak'
            ),
            array (
                'nama' => 'Wagiyah',
                'kepemilikan_rumah' => 1,
                'pekerjaan' => 5,
                'penghasilan' => 2500000,
                'listrik' => 12,
                'tanggungan' => 3,
                'status' => 'Tidak Layak'
            ),
            array (
                'nama' => 'Yandi Iskandar',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 7,
                'penghasilan' => 2500000,
                'listrik' => 12,
                'tanggungan' => 3,
                'status' => 'Tidak Layak'
            ),
            array (
                'nama' => 'Suprianti',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 9,
                'penghasilan' => 1500000,
                'listrik' => 11,
                'tanggungan' => 3,
                'status' => 'Layak'
            ),
            array (
                'nama' => 'Apri Yanti Ningsih',
                'kepemilikan_rumah' => 3,
                'pekerjaan' => 6,
                'penghasilan' => 1200000,
                'listrik' => 11,
                'tanggungan' => 2,
                'status' => 'Layak'
            ),
            array (
                'nama' => 'Marsi',
                'kepemilikan_rumah' => 3,
                'pekerjaan' => 6,
                'penghasilan' => 800000,
                'listrik' => 12,
                'tanggungan' => 5,
                'status' => 'Layak'
            ),
            array (
                'nama' => 'Kartini',
                'kepemilikan_rumah' => 1,
                'pekerjaan' => 4,
                'penghasilan' => 1500000,
                'listrik' => 11,
                'tanggungan' => 5,
                'status' => 'Layak'
            ),
            array (
                'nama' => 'Irmawati Siregar',
                'kepemilikan_rumah' => 1,
                'pekerjaan' => 4,
                'penghasilan' => 1300000,
                'listrik' => 12,
                'tanggungan' => 6,
                'status' => 'Layak'
            ),
            array (
                'nama' => 'Sugiem',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 5,
                'penghasilan' => 4000000,
                'listrik' => 12,
                'tanggungan' => 5,
                'status' => 'Tidak Layak'
            ),
            array (
                'nama' => 'Bambang Saputra',
                'kepemilikan_rumah' => 1,
                'pekerjaan' => 4,
                'penghasilan' => 2800000,
                'listrik' => 12,
                'tanggungan' => 3,
                'status' => 'Tidak Layak'
            ),
            array (
                'nama' => 'Hafni Murni',
                'kepemilikan_rumah' => 1,
                'pekerjaan' => 6,
                'penghasilan' => 3000000,
                'listrik' => 12,
                'tanggungan' => 3,
                'status' => 'Tidak Layak'
            ),
            array (
                'nama' => 'Masnik',
                'kepemilikan_rumah' => 3,
                'pekerjaan' => 5,
                'penghasilan' => 2000000,
                'listrik' => 11,
                'tanggungan' => 1,
                'status' => 'Layak'
            ),
            array (
                'nama' => 'Asman',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 6,
                'penghasilan' => 1000000,
                'listrik' => 11,
                'tanggungan' => 2,
                'status' => 'Layak'
            ),
            array (
                'nama' => 'Desi Saptiani',
                'kepemilikan_rumah' => 3,
                'pekerjaan' => 9,
                'penghasilan' => 1300000,
                'listrik' => 12,
                'tanggungan' => 4,
                'status' => 'Layak'
            ),
            array (
                'nama' => 'Dedi Irawan',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 10,
                'penghasilan' => 2500000,
                'listrik' => 12,
                'tanggungan' => 3,
                'status' => 'Tidak Layak'
            ),
            array (
                'nama' => 'Ade Chandra Dewi',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 5,
                'penghasilan' => 2800000,
                'listrik' => 12,
                'tanggungan' => 2,
                'status' => 'Tidak Layak'
            ),
            array (
                'nama' => 'Saimah Siregar',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 9,
                'penghasilan' => 3000000,
                'listrik' => 12,
                'tanggungan' => 2,
                'status' => 'Tidak Layak'
            ),
            array (
                'nama' => 'Rosita',
                'kepemilikan_rumah' => 1,
                'pekerjaan' => 5,
                'penghasilan' => 1200000,
                'listrik' => 11,
                'tanggungan' => 1,
                'status' => 'Layak'
            ),
            array (
                'nama' => 'Nurleni',
                'kepemilikan_rumah' => 1,
                'pekerjaan' => 4,
                'penghasilan' => 1000000,
                'listrik' => 11,
                'tanggungan' => 1,
                'status' => 'Layak'
            ),
            array (
                'nama' => 'Rusiah',
                'kepemilikan_rumah' => 3,
                'pekerjaan' => 9,
                'penghasilan' => 1500000,
                'listrik' => 12,
                'tanggungan' => 4,
                'status' => 'Layak'
            ),
            array (
                'nama' => 'Syafitriani',
                'kepemilikan_rumah' => 3,
                'pekerjaan' => 9,
                'penghasilan' => 1600000,
                'listrik' => 12,
                'tanggungan' => 5,
                'status' => 'Layak'
            ),
            array (
                'nama' => 'Sriana',
                'kepemilikan_rumah' => 3,
                'pekerjaan' => 9,
                'penghasilan' => 1800000,
                'listrik' => 12,
                'tanggungan' => 5,
                'status' => 'Layak'
            ),
            array (
                'nama' => 'Ponimi',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 5,
                'penghasilan' => 2800000,
                'listrik' => 12,
                'tanggungan' => 6,
                'status' => 'Tidak Layak'
            ),
            array (
                'nama' => 'Erfina',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 4,
                'penghasilan' => 4000000,
                'listrik' => 12,
                'tanggungan' => 3,
                'status' => 'Tidak Layak'
            ),
            array (
                'nama' => 'Tuti Erlinda',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 5,
                'penghasilan' => 800000,
                'listrik' => 11,
                'tanggungan' => 2,
                'status' => 'Layak'
            ),
            array (
                'nama' => 'Maharani',
                'kepemilikan_rumah' => 3,
                'pekerjaan' => 6,
                'penghasilan' => 1500000,
                'listrik' => 11,
                'tanggungan' => 5,
                'status' => 'Layak'
            ),
            array (
                'nama' => 'Rosdiana Nasution',
                'kepemilikan_rumah' => 3,
                'pekerjaan' => 4,
                'penghasilan' => 2000000,
                'listrik' => 12,
                'tanggungan' => 5,
                'status' => 'Layak'
            ),
            array (
                'nama' => 'Sri Lasmi',
                'kepemilikan_rumah' => 3,
                'pekerjaan' => 4,
                'penghasilan' => 1600000,
                'listrik' => 12,
                'tanggungan' => 4,
                'status' => 'Layak'
            ),
            array (
                'nama' => 'Santi',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 4,
                'penghasilan' => 2800000,
                'listrik' => 12,
                'tanggungan' => 3,
                'status' => 'Tidak Layak'
            ),
            array (
                'nama' => 'Suriadi',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 5,
                'penghasilan' => 3000000,
                'listrik' => 12,
                'tanggungan' => 3,
                'status' => 'Tidak Layak'
            ),
            array (
                'nama' => 'Misnawati',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 6,
                'penghasilan' => 3000000,
                'listrik' => 12,
                'tanggungan' => 3,
                'status' => 'Tidak Layak'
            ),
            array (
                'nama' => 'Yuliah',
                'kepemilikan_rumah' => 1,
                'pekerjaan' => 4,
                'penghasilan' => 1200000,
                'listrik' => 11,
                'tanggungan' => 4,
                'status' => 'Layak'
            ),
            array (
                'nama' => 'Tri Eka Syahputri',
                'kepemilikan_rumah' => 1,
                'pekerjaan' => 5,
                'penghasilan' => 1300000,
                'listrik' => 11,
                'tanggungan' => 4,
                'status' => 'Layak'
            ),
            array (
                'nama' => 'Sukesih',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 5,
                'penghasilan' => 1000000,
                'listrik' => 12,
                'tanggungan' => 4,
                'status' => 'Layak',
                'created_at' => '2024-03-16 22:16:27',
                'updated_at' => '2024-03-16 22:16:27',
            ),
            array (
                'nama' => 'Suriani',
                'kepemilikan_rumah' => 3,
                'pekerjaan' => 5,
                'penghasilan' => 1800000,
                'listrik' => 12,
                'tanggungan' => 6,
                'status' => 'Layak'
            ),
            array (
                'nama' => 'Asmawati',
                'kepemilikan_rumah' => 3,
                'pekerjaan' => 4,
                'penghasilan' => 1600000,
                'listrik' => 12,
                'tanggungan' => 5,
                'status' => 'Layak'
            ),
            array (
                'nama' => 'Nurasiah',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 7,
                'penghasilan' => 3000000,
                'listrik' => 12,
                'tanggungan' => 2,
                'status' => 'Tidak Layak'
            ),
            array (
                'nama' => 'Jumaidah',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 8,
                'penghasilan' => 3000000,
                'listrik' => 12,
                'tanggungan' => 3,
                'status' => 'Tidak Layak'
            ),
            array (
                'nama' => 'Kasiem',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 4,
                'penghasilan' => 1800000,
                'listrik' => 11,
                'tanggungan' => 5,
                'status' => 'Layak'
            ),
            array (
                'nama' => 'Tumpuk Puspa Sari',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 9,
                'penghasilan' => 2000000,
                'listrik' => 11,
                'tanggungan' => 6,
                'status' => 'Layak'
            )
        ));
        
        
    }
}