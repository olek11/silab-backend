<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class GenericImport implements ToCollection
{
    protected $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function collection(Collection $rows)
    {
        if ($this->type === 'users') {
            foreach ($rows as $row) {
                User::updateOrCreate(
                    ['email' => $row[1]], // email
                    [
                        'name' => $row[0],
                        'password' => bcrypt($row[2] ?? 'password'),
                        'role' => $row[3] ?? 'user',
                    ]
                );
            }
        }
    }
}
