<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tool;
use App\Models\Room;
use App\Models\Booking;
use Illuminate\Support\Facades\Log;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use App\Exports\UsersExport;

class AdminController extends Controller
{
    // 📋 Tampilkan semua user + role Spatie
    public function index()
    {
        $users = User::select('id', 'name', 'email', 'role')->get();

        foreach ($users as $user) {
            $user->roles = method_exists($user, 'getRoleNames')
                ? $user->getRoleNames()
                : [$user->role ?? 'user'];
        }

        return response()->json([
            'data' => $users,
            'message' => 'Daftar pengguna berhasil dimuat'
        ]);
    }

    // ➕ Tambah pengguna
    public function store(Request $req)
    {
        $req->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:user,admin',
        ]);

        try {
            $user = User::create([
                'name' => $req->input('name'),
                'email' => $req->input('email'),
                'password' => bcrypt($req->input('password')),
                'role' => $req->input('role'),
            ]);

            $user->assignRole($req->input('role'));

            return response()->json([
                'data' => $user,
                'message' => 'Pengguna berhasil ditambahkan'
            ], 201);
        } catch (\Exception $e) {
            Log::error("Gagal tambah user: " . $e->getMessage());
            return response()->json([
                'message' => 'Terjadi kesalahan saat menambahkan pengguna'
            ], 500);
        }
    }

    // ✏️ Update nama & email
    public function update(Request $req, $id)
    {
        $user = User::findOrFail($id);

        $req->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $user->update($req->only('name', 'email'));

        return response()->json([
            'data' => $user,
            'message' => 'Pengguna berhasil diperbarui'
        ]);
    }

    // 🔄 Ubah role pengguna (Spatie + kolom role)
    public function updateRole(Request $req, $id)
    {
        $req->validate([
            'role' => 'required|in:user,admin',
        ]);

        $user = User::findOrFail($id);
        $newRole = $req->input('role');

        $user->role = $newRole;
        $user->syncRoles($newRole);
        $user->save();

        return response()->json([
            'message' => 'Role pengguna berhasil diperbarui'
        ]);
    }

    // 🗑️ Hapus pengguna
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'message' => 'Pengguna berhasil dihapus'
        ]);
    }

    // 📥 Import pengguna dari Excel
    public function import(Request $req)
    {
        $req->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:2048'
        ]);

        try {
            Excel::import(new UsersImport, $req->file('file'));
            return response()->json([
                'message' => 'Data pengguna berhasil diimpor'
            ]);
        } catch (\Exception $e) {
            Log::error("Gagal import Excel: " . $e->getMessage());
            return response()->json([
                'message' => 'Gagal impor Excel, pastikan format sesuai template'
            ], 500);
        }
    }

    // 📤 Export pengguna ke Excel
    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    // 📊 Statistik data
    public function stats()
    {
        return response()->json([
            'tools' => Tool::count(),
            'rooms' => Room::count(),
            'bookings' => Booking::count(),
            'users' => User::count(),
        ]);
    }
}
