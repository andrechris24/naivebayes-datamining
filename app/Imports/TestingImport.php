<?php

namespace App\Imports;
use App\Models\Atribut;
use App\Models\NilaiAtribut;
use App\Models\TestingData;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class TestingImport implements ToModel,WithHeadingRow
{
	/**
	* @param array $row
	*
	* @return \Illuminate\Database\Eloquent\Model|null
	*/
	public function model(array $row)
	{
		$rows=[];
		$atrib=Atribut::get();
		$rows['nama']=$row['nama'];
		foreach($attrib as $attr){
			if($atrib->type==='categorical'){
				$foreign=NilaiAtribut::where('slug',$row[$attr->slug])->first();
				$row[$attr->slug]=$foreign->id;
			}
			$rows[$attr->slug]=$row[$attr->slug];
		}
		$rows['status']=$row['keterangan'];
		return new TestingData($rows);
	}
}
