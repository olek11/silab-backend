<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Database\Eloquent\Model;

class UsersImport implements ToModel, WithHeadingRow
{
    public function model(array $row): ?Model
    {
        $email    = strtolower(trim($row['email'] ?? ''));
        $role     = strtolower(trim($row['role'] ?? 'user'));
        $password = $row['password'] ?? null;
        $name     = $row['nama'] ?? null;

        // 🚧 Validasi tiap field
        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Log::warning("[Import] Email tidak valid: " . json_encode($row));
            return null;
        }

        if (!in_array($role, ['admin', 'user'])) {
            Log::warning("[Import] Role tidak dikenali: $role");
            $role = 'user';
        }

        if (!$password || strlen($password) < 6) {
            Log::warning("[Import] Password lemah untuk email: $email");
            $password = 'default123';
        }

        if (!$name || strlen($name) < 3) {
            Log::warning("[Import] Nama kurang lengkap untuk email: $email");
            $name = 'Tanpa Nama';
        }

        // 🔄 Buat atau update user berdasarkan email
        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => bcrypt($password),
                'role' => $role,
            ]
        );

        // 🎯 Assign Spatie Permission role
        if (method_exists($user, 'assignRole')) {
            $user->syncRoles([$role]);
        }

        return $user;
    }
}
