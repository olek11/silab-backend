<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    // 📋 Data yang akan diekspor
    public function collection()
    {
        return User::select('name', 'email', 'role')->get();
    }

    // 🏷️ Heading baris pertama
    public function headings(): array
    {
        return ['Nama', 'Email', 'Role'];
    }
}
