<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'nama' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'password' => 'password123',
                'role' => 'Super Admin',
            ],
            [
                'nama' => 'Admin Pengaduan',
                'email' => 'pengaduan@example.com',
                'password' => 'password123',
                'role' => 'Admin Pengaduan',
            ],
            [
                'nama' => 'Admin Fungsi',
                'email' => 'fungsi@example.com',
                'password' => 'password123',
                'role' => 'Admin Fungsi',
            ],
            [
                'nama' => 'Admin WB',
                'email' => 'wb@example.com',
                'password' => 'password123',
                'role' => 'Admin Whistle Blowing',
            ],
            [
                'nama' => 'Admin Web',
                'email' => 'web@example.com',
                'password' => 'password123',
                'role' => 'Admin Web',
            ],
            [
                'nama' => 'Kepala BPOM',
                'email' => 'kepala@example.com',
                'password' => 'password123',
                'role' => 'Kepala BPOM',
            ],
        ];

        foreach ($users as $u) {
            $role = Role::where('nm_role', $u['role'])->first();

            User::updateOrCreate(
                ['email' => $u['email']], // unik biar ga dobel
                [
                    'nama' => $u['nama'],
                    'password' => Hash::make($u['password']),
                    'id_role' => $role->id_role,
                ]
            );
        }
    }
}
