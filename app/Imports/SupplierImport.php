<?php

namespace App\Imports;

use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SupplierImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        Supplier::create([
            'name' => $row['name'],
            'phone' => $row['phone'],
            'contact_person' => $row['contact_person'],
            'email' => $row['email'],
            'bank_info' => $row['bank_info'],
            'user_id' => Auth::user()->id
        ]);
    }

    public function headingRow(): int
    {
        return 1;
    }
}
