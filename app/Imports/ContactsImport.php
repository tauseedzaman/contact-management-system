<?php

namespace App\Imports;

use App\Models\Contact;
use Maatwebsite\Excel\Concerns\ToModel;
use Str;

class ContactsImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Contact([
            'name'     => $row[1],
            'email'    => $row[2],
            'uuid'    => Str::uuid(),
            'phone'    => $row[3],
            'address'    => $row[4],
            'category_id'    => $row[5],
            'created_at'    => $row[6],
            'user_id'    => $row[7],
        ]);
    }
}
