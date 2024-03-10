<?php

namespace Database\Seeders;
use App\Models\Atribut;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AtributSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Atribut::create([
            'name' => 'Kepemilikan Rumah',
            'slug'=>'kepemilikan_rumah',
            'type'=>'categorical'
        ]);
        Atribut::create([
            'name' => 'Pekerjaan',
            'slug'=>'pekerjaan',
            'type'=>'categorical'
        ]);
        Atribut::create([
            'name' => 'Penghasilan',
            'slug'=>'penghasilan',
            'type'=>'numeric'
        ]);
        Atribut::create([
            'name' => 'Listrik',
            'slug'=>'listrik',
            'type'=>'categorical'
        ]);
        Atribut::create([
            'name' => 'Tanggungan',
            'slug'=>'tanggungan',
            'type'=>'numeric'
        ]);
    }
}
