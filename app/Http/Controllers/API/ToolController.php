<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tool;


class ToolController extends Controller
{
    // Endpoint publik: GET /tools
    public function index()
    {
        return Tool::all();
    }

    // Admin-only: POST /tools
    public function store(Request $req)
    {
        $data = $req->validate([
            'name' => 'required',
            'code' => 'required|unique:tools',
            'stock' => 'required|integer'
        ]);

        return Tool::create($data);
    }

    // Admin-only: PUT /tools/{id}
    public function update(Request $req, Tool $tool)
    {
        $tool->update($req->all());
        return $tool;
    }

    // Admin-only: DELETE /tools/{id}
    public function destroy(Tool $tool)
    {
        $tool->delete();
        return response()->json(['message' => 'Alat dihapus']);
    }
}
