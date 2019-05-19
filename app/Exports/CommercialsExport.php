<?php

namespace App\Exports;

use App\Commercial;
use Maatwebsite\Excel\Concerns\FromArray;

class CommercialsExport implements FromArray
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return Commercial::all();
    // }

    protected $commercials;

    public function __construct(array $commercials)
    {
        $this->commercials = $commercials;
    }

    public function array(): array
    {
        return $this->commercials;
    }
}
