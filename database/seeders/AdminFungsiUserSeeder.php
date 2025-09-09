<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminFungsiUserSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan ada role "Admin Fungsi"
        $role = Role::firstOrCreate(
            ['nm_role' => 'Admin Fungsi'],
            ['created_at' => now(), 'updated_at' => now()]
        );

        // Ambil semua data dari tabel admin_fungsi
        $admins = DB::table('admin_fungsi')->get();

        foreach ($admins as $admin) {
            User::firstOrCreate(
                ['email' => strtolower(str_replace(' ', '', $admin->nama)) . '@example.com'],
                [
                    'nama' => $admin->nama,
                    'password' => Hash::make('password123'), // default password
                    'id_role' => $role->id_role,
                ]
            );
        }
    }
}
