<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class GenericExport implements FromCollection
{
    protected $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function collection()
    {
        switch ($this->type) {
            case 'users':
                return User::select('name', 'email', 'role')->get();
            default:
                return collect([]);
        }
    }
}
