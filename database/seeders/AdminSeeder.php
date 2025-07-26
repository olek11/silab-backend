<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek apakah sudah ada admin dengan email ini
        $check = User::where('email', 'admin@labapp.com')->first();
        if ($check) return;

        $admin = User::create([
            'name' => 'Admin Master',
            'email' => 'admin@labapp.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);

        $admin->assignRole('admin'); // ✅ Spatie Permission
    }
}
