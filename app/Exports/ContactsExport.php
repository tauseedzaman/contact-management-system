<?php

namespace App\Exports;

use App\Models\Contact;
use Maatwebsite\Excel\Concerns\FromCollection;

class ContactsExport implements FromCollection
{
    public function collection()
    {
        return Contact::where("user_id", auth()->id())->get(["id", "name", "email", "phone", "address","category_id","created_at","user_id"]);
    }
}
