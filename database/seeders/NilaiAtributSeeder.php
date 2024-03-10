<?php

namespace Database\Seeders;
use App\Models\NilaiAtribut;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NilaiAtributSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NilaiAtribut::create([
            'atribut_id'=>1,
            'name'=>'Milik sendiri'
        ]);
        NilaiAtribut::create([
            'atribut_id'=>1,
            'name'=>'Menumpang'
        ]);
        NilaiAtribut::create([
            'atribut_id'=>1,
            'name'=>'Kontrak/sewa'
        ]);
        NilaiAtribut::create([
            'atribut_id'=>2,
            'name'=>'Wiraswasta'
        ]);
        NilaiAtribut::create([
            'atribut_id'=>2,
            'name'=>'Wirausaha'
        ]);
        NilaiAtribut::create([
            'atribut_id'=>2,
            'name'=>'Buruh'
        ]);
        NilaiAtribut::create([
            'atribut_id'=>2,
            'name'=>'Pensiunan'
        ]);
        NilaiAtribut::create([
            'atribut_id'=>2,
            'name'=>'Guru'
        ]);
        NilaiAtribut::create([
            'atribut_id'=>2,
            'name'=>'Karyawan swasta'
        ]);
        NilaiAtribut::create([
            'atribut_id'=>2,
            'name'=>'Catering'
        ]);
        NilaiAtribut::create([
            'atribut_id'=>4,
            'name'=>'450 VA'
        ]);
        NilaiAtribut::create([
            'atribut_id'=>4,
            'name'=>'900 VA'
        ]);
    }
}
