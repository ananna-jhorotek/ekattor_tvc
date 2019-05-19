<?php

namespace App\Imports;

use App\Commercial;
use App\Program;
use App\Break_type;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class CommercialsImport implements ToModel,WithHeadingRow,WithCalculatedFormulas
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {    
        $program = Program::where('name', $row['program'])->first();
        $break = Break_type::where('name', $row['breaks'])->first();

        if($program && $break)
        {
            return new Commercial([
                'name'     => $row['name'],
                'client'    => $row['client'], 
                'brand'    => $row['brand'], 
                'program_id' => $program->id,
                'break_id' => $break->id,
                'duration' => $row['duration'],
                'start_date' => date('y-m-d', strtotime($row['start_date'])),
                'end_date' => date('y-m-d', strtotime($row['end_date'])),
                'net_rate' => $row['net_rate'],
                'remarks' => $row['remarks'],
            ]);
        }
        
    }
}
