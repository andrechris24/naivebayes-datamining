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
        \DB::table('training_data')->insert(array (
            0 => 
            array (
                'id' => 1,
                'nama' => 'Nurhayati',
                'kepemilikan_rumah' => 1,
                'pekerjaan' => 6,
                'penghasilan' => 800000,
                'listrik' => 11,
                'tanggungan' => 1,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:03',
                'updated_at' => '2024-03-10 19:36:03',
            ),
            1 => 
            array (
                'id' => 2,
                'nama' => 'Hartini',
                'kepemilikan_rumah' => 1,
                'pekerjaan' => 5,
                'penghasilan' => 1600000,
                'listrik' => 11,
                'tanggungan' => 3,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:03',
                'updated_at' => '2024-03-10 19:36:03',
            ),
            2 => 
            array (
                'id' => 3,
                'nama' => 'Dalima Lubis',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 5,
                'penghasilan' => 1600000,
                'listrik' => 12,
                'tanggungan' => 4,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:03',
                'updated_at' => '2024-03-10 19:36:03',
            ),
            3 => 
            array (
                'id' => 4,
                'nama' => 'Halimah',
                'kepemilikan_rumah' => 3,
                'pekerjaan' => 9,
                'penghasilan' => 1500000,
                'listrik' => 12,
                'tanggungan' => 4,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:03',
                'updated_at' => '2024-03-10 19:36:03',
            ),
            4 => 
            array (
                'id' => 5,
                'nama' => 'Maharani Laili',
                'kepemilikan_rumah' => 1,
                'pekerjaan' => 8,
                'penghasilan' => 4000000,
                'listrik' => 12,
                'tanggungan' => 3,
                'status' => 'Tidak Layak',
                'created_at' => '2024-03-10 19:36:03',
                'updated_at' => '2024-03-10 19:36:03',
            ),
            5 => 
            array (
                'id' => 6,
                'nama' => 'Marina',
                'kepemilikan_rumah' => 1,
                'pekerjaan' => 5,
                'penghasilan' => 3000000,
                'listrik' => 12,
                'tanggungan' => 3,
                'status' => 'Tidak Layak',
                'created_at' => '2024-03-10 19:36:03',
                'updated_at' => '2024-03-10 19:36:03',
            ),
            6 => 
            array (
                'id' => 7,
                'nama' => 'Asnindar',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 4,
                'penghasilan' => 3500000,
                'listrik' => 12,
                'tanggungan' => 5,
                'status' => 'Tidak Layak',
                'created_at' => '2024-03-10 19:36:03',
                'updated_at' => '2024-03-10 19:36:03',
            ),
            7 => 
            array (
                'id' => 8,
                'nama' => 'Hendrik Hidayat',
                'kepemilikan_rumah' => 1,
                'pekerjaan' => 4,
                'penghasilan' => 1800000,
                'listrik' => 11,
                'tanggungan' => 2,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:03',
                'updated_at' => '2024-03-10 19:36:03',
            ),
            8 => 
            array (
                'id' => 9,
                'nama' => 'Fadilah Umaya',
                'kepemilikan_rumah' => 1,
                'pekerjaan' => 4,
                'penghasilan' => 1200000,
                'listrik' => 11,
                'tanggungan' => 2,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:03',
                'updated_at' => '2024-03-10 19:36:03',
            ),
            9 => 
            array (
                'id' => 10,
                'nama' => 'Erna',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 4,
                'penghasilan' => 1500000,
                'listrik' => 12,
                'tanggungan' => 5,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:03',
                'updated_at' => '2024-03-10 19:36:03',
            ),
            10 => 
            array (
                'id' => 11,
                'nama' => 'Suriati',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 5,
                'penghasilan' => 2200000,
                'listrik' => 12,
                'tanggungan' => 6,
                'status' => 'Tidak Layak',
                'created_at' => '2024-03-10 19:36:03',
                'updated_at' => '2024-03-10 19:36:03',
            ),
            11 => 
            array (
                'id' => 12,
                'nama' => 'Zulkarnain',
                'kepemilikan_rumah' => 1,
                'pekerjaan' => 7,
                'penghasilan' => 2000000,
                'listrik' => 12,
                'tanggungan' => 6,
                'status' => 'Tidak Layak',
                'created_at' => '2024-03-10 19:36:03',
                'updated_at' => '2024-03-10 19:36:03',
            ),
            12 => 
            array (
                'id' => 13,
                'nama' => 'Misni',
                'kepemilikan_rumah' => 1,
                'pekerjaan' => 5,
                'penghasilan' => 1800000,
                'listrik' => 12,
                'tanggungan' => 2,
                'status' => 'Tidak Layak',
                'created_at' => '2024-03-10 19:36:03',
                'updated_at' => '2024-03-10 19:36:03',
            ),
            13 => 
            array (
                'id' => 14,
                'nama' => 'Harya Ningsih',
                'kepemilikan_rumah' => 1,
                'pekerjaan' => 9,
                'penghasilan' => 1000000,
                'listrik' => 11,
                'tanggungan' => 1,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:03',
                'updated_at' => '2024-03-10 19:36:03',
            ),
            14 => 
            array (
                'id' => 15,
                'nama' => 'Rika Sri Wahyuni',
                'kepemilikan_rumah' => 1,
                'pekerjaan' => 6,
                'penghasilan' => 1000000,
                'listrik' => 11,
                'tanggungan' => 2,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:03',
                'updated_at' => '2024-03-10 19:36:03',
            ),
            15 => 
            array (
                'id' => 16,
                'nama' => 'Yusni',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 9,
                'penghasilan' => 1600000,
                'listrik' => 12,
                'tanggungan' => 5,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:03',
                'updated_at' => '2024-03-10 19:36:03',
            ),
            16 => 
            array (
                'id' => 17,
                'nama' => 'Eka Jurita Tarigan',
                'kepemilikan_rumah' => 3,
                'pekerjaan' => 5,
                'penghasilan' => 1300000,
                'listrik' => 12,
                'tanggungan' => 2,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:03',
                'updated_at' => '2024-03-10 19:36:03',
            ),
            17 => 
            array (
                'id' => 18,
                'nama' => 'Astutiana',
                'kepemilikan_rumah' => 3,
                'pekerjaan' => 4,
                'penghasilan' => 800000,
                'listrik' => 12,
                'tanggungan' => 1,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:03',
                'updated_at' => '2024-03-10 19:36:03',
            ),
            18 => 
            array (
                'id' => 19,
                'nama' => 'Bambang Hardianto',
                'kepemilikan_rumah' => 1,
                'pekerjaan' => 4,
                'penghasilan' => 2000000,
                'listrik' => 12,
                'tanggungan' => 3,
                'status' => 'Tidak Layak',
                'created_at' => '2024-03-10 19:36:03',
                'updated_at' => '2024-03-10 19:36:03',
            ),
            19 => 
            array (
                'id' => 20,
                'nama' => 'Ridawati',
                'kepemilikan_rumah' => 1,
                'pekerjaan' => 4,
                'penghasilan' => 2000000,
                'listrik' => 12,
                'tanggungan' => 5,
                'status' => 'Tidak Layak',
                'created_at' => '2024-03-10 19:36:03',
                'updated_at' => '2024-03-10 19:36:03',
            ),
            20 => 
            array (
                'id' => 21,
                'nama' => 'Wirda Zendrato',
                'kepemilikan_rumah' => 1,
                'pekerjaan' => 4,
                'penghasilan' => 3500000,
                'listrik' => 12,
                'tanggungan' => 5,
                'status' => 'Tidak Layak',
                'created_at' => '2024-03-10 19:36:03',
                'updated_at' => '2024-03-10 19:36:03',
            ),
            21 => 
            array (
                'id' => 22,
                'nama' => 'Hariani',
                'kepemilikan_rumah' => 1,
                'pekerjaan' => 4,
                'penghasilan' => 1200000,
                'listrik' => 11,
                'tanggungan' => 3,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:03',
                'updated_at' => '2024-03-10 19:36:03',
            ),
            22 => 
            array (
                'id' => 23,
                'nama' => 'Rahmadhani',
                'kepemilikan_rumah' => 1,
                'pekerjaan' => 9,
                'penghasilan' => 1300000,
                'listrik' => 11,
                'tanggungan' => 2,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:03',
                'updated_at' => '2024-03-10 19:36:03',
            ),
            23 => 
            array (
                'id' => 24,
                'nama' => 'Armadani',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 9,
                'penghasilan' => 1800000,
                'listrik' => 12,
                'tanggungan' => 4,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:03',
                'updated_at' => '2024-03-10 19:36:03',
            ),
            24 => 
            array (
                'id' => 25,
                'nama' => 'Sumarsih',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 6,
                'penghasilan' => 1600000,
                'listrik' => 12,
                'tanggungan' => 1,
                'status' => 'Tidak Layak',
                'created_at' => '2024-03-10 19:36:03',
                'updated_at' => '2024-03-10 19:36:03',
            ),
            25 => 
            array (
                'id' => 26,
                'nama' => 'Wagiyah',
                'kepemilikan_rumah' => 1,
                'pekerjaan' => 5,
                'penghasilan' => 2500000,
                'listrik' => 12,
                'tanggungan' => 3,
                'status' => 'Tidak Layak',
                'created_at' => '2024-03-10 19:36:03',
                'updated_at' => '2024-03-10 19:36:03',
            ),
            26 => 
            array (
                'id' => 27,
                'nama' => 'Yandi Iskandar',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 7,
                'penghasilan' => 2500000,
                'listrik' => 12,
                'tanggungan' => 3,
                'status' => 'Tidak Layak',
                'created_at' => '2024-03-10 19:36:03',
                'updated_at' => '2024-03-10 19:36:03',
            ),
            27 => 
            array (
                'id' => 28,
                'nama' => 'Suprianti',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 9,
                'penghasilan' => 1500000,
                'listrik' => 11,
                'tanggungan' => 3,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:03',
                'updated_at' => '2024-03-10 19:36:03',
            ),
            28 => 
            array (
                'id' => 29,
                'nama' => 'Apri Yanti Ningsih',
                'kepemilikan_rumah' => 3,
                'pekerjaan' => 6,
                'penghasilan' => 1200000,
                'listrik' => 11,
                'tanggungan' => 2,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:03',
                'updated_at' => '2024-03-10 19:36:03',
            ),
            29 => 
            array (
                'id' => 30,
                'nama' => 'Marsi',
                'kepemilikan_rumah' => 3,
                'pekerjaan' => 6,
                'penghasilan' => 800000,
                'listrik' => 12,
                'tanggungan' => 5,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:03',
                'updated_at' => '2024-03-10 19:36:03',
            ),
            30 => 
            array (
                'id' => 31,
                'nama' => 'Kartini',
                'kepemilikan_rumah' => 1,
                'pekerjaan' => 4,
                'penghasilan' => 1500000,
                'listrik' => 11,
                'tanggungan' => 5,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:03',
                'updated_at' => '2024-03-10 19:36:03',
            ),
            31 => 
            array (
                'id' => 32,
                'nama' => 'Irmawati Siregar',
                'kepemilikan_rumah' => 1,
                'pekerjaan' => 4,
                'penghasilan' => 1300000,
                'listrik' => 12,
                'tanggungan' => 6,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:03',
                'updated_at' => '2024-03-10 19:36:03',
            ),
            32 => 
            array (
                'id' => 33,
                'nama' => 'Sugiem',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 5,
                'penghasilan' => 4000000,
                'listrik' => 12,
                'tanggungan' => 5,
                'status' => 'Tidak Layak',
                'created_at' => '2024-03-10 19:36:03',
                'updated_at' => '2024-03-10 19:36:03',
            ),
            33 => 
            array (
                'id' => 34,
                'nama' => 'Bambang Saputra',
                'kepemilikan_rumah' => 1,
                'pekerjaan' => 4,
                'penghasilan' => 2800000,
                'listrik' => 12,
                'tanggungan' => 3,
                'status' => 'Tidak Layak',
                'created_at' => '2024-03-10 19:36:03',
                'updated_at' => '2024-03-10 19:36:03',
            ),
            34 => 
            array (
                'id' => 35,
                'nama' => 'Hafni Murni',
                'kepemilikan_rumah' => 1,
                'pekerjaan' => 6,
                'penghasilan' => 3000000,
                'listrik' => 12,
                'tanggungan' => 3,
                'status' => 'Tidak Layak',
                'created_at' => '2024-03-10 19:36:03',
                'updated_at' => '2024-03-10 19:36:03',
            ),
            35 => 
            array (
                'id' => 36,
                'nama' => 'Masnik',
                'kepemilikan_rumah' => 3,
                'pekerjaan' => 5,
                'penghasilan' => 2000000,
                'listrik' => 11,
                'tanggungan' => 1,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:03',
                'updated_at' => '2024-03-10 19:36:03',
            ),
            36 => 
            array (
                'id' => 37,
                'nama' => 'Asman',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 6,
                'penghasilan' => 1000000,
                'listrik' => 11,
                'tanggungan' => 2,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:03',
                'updated_at' => '2024-03-10 19:36:03',
            ),
            37 => 
            array (
                'id' => 38,
                'nama' => 'Desi Saptiani',
                'kepemilikan_rumah' => 3,
                'pekerjaan' => 9,
                'penghasilan' => 1300000,
                'listrik' => 12,
                'tanggungan' => 4,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:03',
                'updated_at' => '2024-03-10 19:36:03',
            ),
            38 => 
            array (
                'id' => 39,
                'nama' => 'Dedi Irawan',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 10,
                'penghasilan' => 2500000,
                'listrik' => 12,
                'tanggungan' => 3,
                'status' => 'Tidak Layak',
                'created_at' => '2024-03-10 19:36:04',
                'updated_at' => '2024-03-10 19:36:04',
            ),
            39 => 
            array (
                'id' => 40,
                'nama' => 'Ade Chandra Dewi',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 5,
                'penghasilan' => 2800000,
                'listrik' => 12,
                'tanggungan' => 2,
                'status' => 'Tidak Layak',
                'created_at' => '2024-03-10 19:36:04',
                'updated_at' => '2024-03-10 19:36:04',
            ),
            40 => 
            array (
                'id' => 41,
                'nama' => 'Saimah Siregar',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 9,
                'penghasilan' => 3000000,
                'listrik' => 12,
                'tanggungan' => 2,
                'status' => 'Tidak Layak',
                'created_at' => '2024-03-10 19:36:04',
                'updated_at' => '2024-03-10 19:36:04',
            ),
            41 => 
            array (
                'id' => 42,
                'nama' => 'Rosita',
                'kepemilikan_rumah' => 1,
                'pekerjaan' => 5,
                'penghasilan' => 1200000,
                'listrik' => 11,
                'tanggungan' => 1,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:04',
                'updated_at' => '2024-03-10 19:36:04',
            ),
            42 => 
            array (
                'id' => 43,
                'nama' => 'Nurleni',
                'kepemilikan_rumah' => 1,
                'pekerjaan' => 4,
                'penghasilan' => 1000000,
                'listrik' => 11,
                'tanggungan' => 1,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:04',
                'updated_at' => '2024-03-10 19:36:04',
            ),
            43 => 
            array (
                'id' => 44,
                'nama' => 'Rusiah',
                'kepemilikan_rumah' => 3,
                'pekerjaan' => 9,
                'penghasilan' => 1500000,
                'listrik' => 12,
                'tanggungan' => 4,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:04',
                'updated_at' => '2024-03-10 19:36:04',
            ),
            44 => 
            array (
                'id' => 45,
                'nama' => 'Syafitriani',
                'kepemilikan_rumah' => 3,
                'pekerjaan' => 9,
                'penghasilan' => 1600000,
                'listrik' => 12,
                'tanggungan' => 5,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:04',
                'updated_at' => '2024-03-10 19:36:04',
            ),
            45 => 
            array (
                'id' => 46,
                'nama' => 'Sriana',
                'kepemilikan_rumah' => 3,
                'pekerjaan' => 9,
                'penghasilan' => 1800000,
                'listrik' => 12,
                'tanggungan' => 5,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:04',
                'updated_at' => '2024-03-10 19:36:04',
            ),
            46 => 
            array (
                'id' => 47,
                'nama' => 'Ponimi',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 5,
                'penghasilan' => 2800000,
                'listrik' => 12,
                'tanggungan' => 6,
                'status' => 'Tidak Layak',
                'created_at' => '2024-03-10 19:36:04',
                'updated_at' => '2024-03-10 19:36:04',
            ),
            47 => 
            array (
                'id' => 48,
                'nama' => 'Erfina',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 4,
                'penghasilan' => 4000000,
                'listrik' => 12,
                'tanggungan' => 3,
                'status' => 'Tidak Layak',
                'created_at' => '2024-03-10 19:36:04',
                'updated_at' => '2024-03-10 19:36:04',
            ),
            48 => 
            array (
                'id' => 49,
                'nama' => 'Tuti Erlinda',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 5,
                'penghasilan' => 800000,
                'listrik' => 11,
                'tanggungan' => 2,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:04',
                'updated_at' => '2024-03-10 19:36:04',
            ),
            49 => 
            array (
                'id' => 50,
                'nama' => 'Maharani',
                'kepemilikan_rumah' => 3,
                'pekerjaan' => 6,
                'penghasilan' => 1500000,
                'listrik' => 11,
                'tanggungan' => 5,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:04',
                'updated_at' => '2024-03-10 19:36:04',
            ),
            50 => 
            array (
                'id' => 51,
                'nama' => 'Rosdiana Nasution',
                'kepemilikan_rumah' => 3,
                'pekerjaan' => 4,
                'penghasilan' => 2000000,
                'listrik' => 12,
                'tanggungan' => 5,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:04',
                'updated_at' => '2024-03-10 19:36:04',
            ),
            51 => 
            array (
                'id' => 52,
                'nama' => 'Sri Lasmi',
                'kepemilikan_rumah' => 3,
                'pekerjaan' => 4,
                'penghasilan' => 1600000,
                'listrik' => 12,
                'tanggungan' => 4,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:04',
                'updated_at' => '2024-03-10 19:36:04',
            ),
            52 => 
            array (
                'id' => 53,
                'nama' => 'Santi',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 4,
                'penghasilan' => 2800000,
                'listrik' => 12,
                'tanggungan' => 3,
                'status' => 'Tidak Layak',
                'created_at' => '2024-03-10 19:36:04',
                'updated_at' => '2024-03-10 19:36:04',
            ),
            53 => 
            array (
                'id' => 54,
                'nama' => 'Suriadi',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 5,
                'penghasilan' => 3000000,
                'listrik' => 12,
                'tanggungan' => 3,
                'status' => 'Tidak Layak',
                'created_at' => '2024-03-10 19:36:04',
                'updated_at' => '2024-03-10 19:36:04',
            ),
            54 => 
            array (
                'id' => 55,
                'nama' => 'Misnawati',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 6,
                'penghasilan' => 3000000,
                'listrik' => 12,
                'tanggungan' => 3,
                'status' => 'Tidak Layak',
                'created_at' => '2024-03-10 19:36:04',
                'updated_at' => '2024-03-10 19:36:04',
            ),
            55 => 
            array (
                'id' => 56,
                'nama' => 'Yuliah',
                'kepemilikan_rumah' => 1,
                'pekerjaan' => 4,
                'penghasilan' => 1200000,
                'listrik' => 11,
                'tanggungan' => 4,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:04',
                'updated_at' => '2024-03-10 19:36:04',
            ),
            56 => 
            array (
                'id' => 57,
                'nama' => 'Tri Eka Syahputri',
                'kepemilikan_rumah' => 1,
                'pekerjaan' => 5,
                'penghasilan' => 1300000,
                'listrik' => 11,
                'tanggungan' => 4,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:04',
                'updated_at' => '2024-03-10 19:36:04',
            ),
            57 => 
            array (
                'id' => 58,
                'nama' => 'Sukesih',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 5,
                'penghasilan' => 1000000,
                'listrik' => 12,
                'tanggungan' => 4,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:04',
                'updated_at' => '2024-03-10 19:36:04',
            ),
            58 => 
            array (
                'id' => 59,
                'nama' => 'Suriani',
                'kepemilikan_rumah' => 3,
                'pekerjaan' => 5,
                'penghasilan' => 1800000,
                'listrik' => 12,
                'tanggungan' => 6,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:04',
                'updated_at' => '2024-03-10 19:36:04',
            ),
            59 => 
            array (
                'id' => 60,
                'nama' => 'Asmawati',
                'kepemilikan_rumah' => 3,
                'pekerjaan' => 4,
                'penghasilan' => 1600000,
                'listrik' => 12,
                'tanggungan' => 5,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:04',
                'updated_at' => '2024-03-10 19:36:04',
            ),
            60 => 
            array (
                'id' => 61,
                'nama' => 'Nurasiah',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 7,
                'penghasilan' => 3000000,
                'listrik' => 12,
                'tanggungan' => 2,
                'status' => 'Tidak Layak',
                'created_at' => '2024-03-10 19:36:04',
                'updated_at' => '2024-03-10 19:36:04',
            ),
            61 => 
            array (
                'id' => 62,
                'nama' => 'Jumaidah',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 8,
                'penghasilan' => 3000000,
                'listrik' => 12,
                'tanggungan' => 3,
                'status' => 'Tidak Layak',
                'created_at' => '2024-03-10 19:36:04',
                'updated_at' => '2024-03-10 19:36:04',
            ),
            62 => 
            array (
                'id' => 63,
                'nama' => 'Kasiem',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 4,
                'penghasilan' => 1800000,
                'listrik' => 11,
                'tanggungan' => 5,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:04',
                'updated_at' => '2024-03-10 19:36:04',
            ),
            63 => 
            array (
                'id' => 64,
                'nama' => 'Tumpuk Puspa Sari',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 9,
                'penghasilan' => 2000000,
                'listrik' => 11,
                'tanggungan' => 6,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:04',
                'updated_at' => '2024-03-10 19:36:04',
            ),
            64 => 
            array (
                'id' => 65,
                'nama' => 'Finta Ria',
                'kepemilikan_rumah' => 3,
                'pekerjaan' => 9,
                'penghasilan' => 1300000,
                'listrik' => 12,
                'tanggungan' => 4,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:04',
                'updated_at' => '2024-03-10 19:36:04',
            ),
            65 => 
            array (
                'id' => 66,
                'nama' => 'Evi Samosir',
                'kepemilikan_rumah' => 3,
                'pekerjaan' => 6,
                'penghasilan' => 1200000,
                'listrik' => 12,
                'tanggungan' => 4,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:04',
                'updated_at' => '2024-03-10 19:36:04',
            ),
            66 => 
            array (
                'id' => 67,
                'nama' => 'Reslin BR Hombing',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 4,
                'penghasilan' => 2200000,
                'listrik' => 12,
                'tanggungan' => 4,
                'status' => 'Tidak Layak',
                'created_at' => '2024-03-10 19:36:04',
                'updated_at' => '2024-03-10 19:36:04',
            ),
            67 => 
            array (
                'id' => 68,
                'nama' => 'Yuyun Marhamah',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 9,
                'penghasilan' => 2200000,
                'listrik' => 12,
                'tanggungan' => 5,
                'status' => 'Tidak Layak',
                'created_at' => '2024-03-10 19:36:04',
                'updated_at' => '2024-03-10 19:36:04',
            ),
            68 => 
            array (
                'id' => 69,
                'nama' => 'Nuraini Lubis',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 4,
                'penghasilan' => 2500000,
                'listrik' => 12,
                'tanggungan' => 6,
                'status' => 'Tidak Layak',
                'created_at' => '2024-03-10 19:36:04',
                'updated_at' => '2024-03-10 19:36:04',
            ),
            69 => 
            array (
                'id' => 70,
                'nama' => 'Samsiar',
                'kepemilikan_rumah' => 1,
                'pekerjaan' => 6,
                'penghasilan' => 2000000,
                'listrik' => 11,
                'tanggungan' => 6,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:04',
                'updated_at' => '2024-03-10 19:36:04',
            ),
            70 => 
            array (
                'id' => 71,
                'nama' => 'Sri Lindawati',
                'kepemilikan_rumah' => 3,
                'pekerjaan' => 4,
                'penghasilan' => 2000000,
                'listrik' => 11,
                'tanggungan' => 5,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:04',
                'updated_at' => '2024-03-10 19:36:04',
            ),
            71 => 
            array (
                'id' => 72,
                'nama' => 'Siti Saerah',
                'kepemilikan_rumah' => 3,
                'pekerjaan' => 9,
                'penghasilan' => 1800000,
                'listrik' => 12,
                'tanggungan' => 5,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:04',
                'updated_at' => '2024-03-10 19:36:04',
            ),
            72 => 
            array (
                'id' => 73,
                'nama' => 'Ely Safitri Handayani',
                'kepemilikan_rumah' => 3,
                'pekerjaan' => 6,
                'penghasilan' => 800000,
                'listrik' => 12,
                'tanggungan' => 4,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:04',
                'updated_at' => '2024-03-10 19:36:04',
            ),
            73 => 
            array (
                'id' => 74,
                'nama' => 'Supiyah',
                'kepemilikan_rumah' => 3,
                'pekerjaan' => 5,
                'penghasilan' => 1200000,
                'listrik' => 11,
                'tanggungan' => 2,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:04',
                'updated_at' => '2024-03-10 19:36:04',
            ),
            74 => 
            array (
                'id' => 75,
                'nama' => 'Sriati',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 8,
                'penghasilan' => 4000000,
                'listrik' => 11,
                'tanggungan' => 4,
                'status' => 'Tidak Layak',
                'created_at' => '2024-03-10 19:36:04',
                'updated_at' => '2024-03-10 19:36:04',
            ),
            75 => 
            array (
                'id' => 76,
                'nama' => 'Nuraini',
                'kepemilikan_rumah' => 2,
                'pekerjaan' => 10,
                'penghasilan' => 3500000,
                'listrik' => 11,
                'tanggungan' => 4,
                'status' => 'Tidak Layak',
                'created_at' => '2024-03-10 19:36:04',
                'updated_at' => '2024-03-10 19:36:04',
            ),
            76 => 
            array (
                'id' => 77,
                'nama' => 'Edywati',
                'kepemilikan_rumah' => 3,
                'pekerjaan' => 9,
                'penghasilan' => 1800000,
                'listrik' => 11,
                'tanggungan' => 3,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:04',
                'updated_at' => '2024-03-10 19:36:04',
            ),
            77 => 
            array (
                'id' => 78,
                'nama' => 'Yusridah Yusuf',
                'kepemilikan_rumah' => 3,
                'pekerjaan' => 6,
                'penghasilan' => 2000000,
                'listrik' => 11,
                'tanggungan' => 1,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:04',
                'updated_at' => '2024-03-10 19:36:04',
            ),
            78 => 
            array (
                'id' => 79,
                'nama' => 'Rusmiati',
                'kepemilikan_rumah' => 3,
                'pekerjaan' => 9,
                'penghasilan' => 1200000,
                'listrik' => 11,
                'tanggungan' => 3,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:04',
                'updated_at' => '2024-03-10 19:36:04',
            ),
            79 => 
            array (
                'id' => 80,
                'nama' => 'Lestari',
                'kepemilikan_rumah' => 3,
                'pekerjaan' => 6,
                'penghasilan' => 800000,
                'listrik' => 11,
                'tanggungan' => 1,
                'status' => 'Layak',
                'created_at' => '2024-03-10 19:36:04',
                'updated_at' => '2024-03-10 19:36:04',
            ),
        ));
    }
}