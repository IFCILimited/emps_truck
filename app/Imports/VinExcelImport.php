<?php

namespace App\Imports;

use Illuminate\Support\Collection;
// use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToArray;

class VinExcelImport implements ToArray
{
    public function array(array $rows)
    {
        return $rows; 
    }
}