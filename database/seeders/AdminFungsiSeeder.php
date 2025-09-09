<?php
// filepath: d:\kp\bpom-web\backend\database\seeders\AdminFungsiSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminFungsiSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $data = [
            ['nama' => 'Admin tik'],
            ['nama' => 'Admin laboratorium'],
            ['nama' => 'Admin kepegawaian'],
            ['nama' => 'Admin pengadaan'],
            ['nama' => 'Admin humas'],
          
            // dst
        ];

        $data = array_map(function($item) use ($now) {
            $item['created_at'] = $now;
            $item['updated_at'] = $now;
            return $item;
        }, $data);

        DB::table('admin_fungsi')->insert($data);
    }
}