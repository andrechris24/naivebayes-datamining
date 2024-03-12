<?php

namespace App\Exports;
use App\Models\Atribut;
use App\Models\NilaiAtribut;
use App\Models\TestingData;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TestingExport implements FromCollection,WithHeadings
{
    public function headings(): array
    {
        $col[]='#';
        $col[]="Nama";
        foreach (Atribut::get() as $value) {
            $col[]=$value->name;
        }
        $col[]="Keterangan";
        return $col;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return TestingData::all();
    }
}
