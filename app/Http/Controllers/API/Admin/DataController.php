<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\GenericExport;
use App\Imports\GenericImport;
use Maatwebsite\Excel\Facades\Excel;


class DataController extends Controller
{
    public function export($type)
    {
        return Excel::download(new GenericExport($type), "{$type}.xlsx");
    }

    public function import(Request $req, $type)
    {
        $req->validate(['file' => 'required|file|mimes:xlsx']);
        Excel::import(new GenericImport($type), $req->file('file'));
        return response()->json(['message' => 'Impor sukses']);
    }
}
