<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'Super Admin',
            'Admin Pengaduan',
            'Admin Fungsi',
            'Admin Whistle Blowing',
            'Admin Web',
            'Admin Operasional',
        ];

        foreach ($roles as $role) {
            Role::create(['nm_role' => $role]);
        }
    }
}
