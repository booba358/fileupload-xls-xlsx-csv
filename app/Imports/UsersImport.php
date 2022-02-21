<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            'first_name'     => $row[1],
            'last_name'    => $row[2],
            'gender' => $row[3],
            'country' => $row[4],
            'age' => $row[5],
            'date' => $row[6],
            'id' => $row[7],
        ]);
    }
}
