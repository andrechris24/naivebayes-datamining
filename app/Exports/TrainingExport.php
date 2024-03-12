<?php

namespace App\Exports;
use App\Models\Atribut;
use App\Models\NilaiAtribut;
use App\Models\TrainingData;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TrainingExport implements FromCollection,WithHeadings
{
    public function headings(): array
    {
        $col[]='#';
        $col[]="Nama";
        foreach (Atribut::get() as $key => $value) {
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
        return TrainingData::all();
    }
}
