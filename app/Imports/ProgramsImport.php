<?php

namespace App\Imports;

use App\Program;
use Maatwebsite\Excel\Concerns\ToModel;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

// class ProgramsImport implements ToCollection
// {
//     public function collection(Collection $rows)
//     {
//         foreach ($rows as $row) 
//         {
//             $program = Program::create([
//                 'name'     => $row[0],
//                 'type'    => $row[1], 
//                 'start_time' => $row[2],
//                 'end_time' => $row[3],
//                 'time_id' => $row[4],
//                 'start_date' => $row[5],
//                 'end_date' => $row[6],
//             ]);

//             echo $program->id;

//             $program->break_type()->attach(1, ['duration' => 100]);
//             $program->break_type()->attach(2, ['duration' => 100]);
//             $program->break_type()->attach(3, ['duration' => 100]);
//             $program->break_type()->attach(4, ['duration' => 100]);
//         }
//     }
// }

class ProgramsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Program([
           'name'     => $row[0],
           'type'    => $row[1], 
           'start_time' => $row[2],
           'end_time' => $row[3],
           'time_id' => $row[4],
           'start_date' => $row[5],
           'end_date' => $row[6],
        ]);
    }

}
