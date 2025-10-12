<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChartLayanan;

class ChartLayananSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ["label"=>"Layanan Online","value"=>20,"color"=>"bg-green-400","date"=>"2025-09-20"],
            ["label"=>"Antrian Digital","value"=>92,"color"=>"bg-blue-400","date"=>"2025-09-19"],
            ["label"=>"Info Real-time","value"=>78,"color"=>"bg-yellow-400","date"=>"2025-09-18"],
            ["label"=>"Pengaduan","value"=>88,"color"=>"bg-purple-400","date"=>"2025-09-20"],
            ["label"=>"Kepuasan User","value"=>95,"color"=>"bg-pink-400","date"=>"2025-09-21"],
            ["label"=>"SMS Gateway","value"=>82,"color"=>"bg-indigo-400","date"=>"2025-09-19"],
            ["label"=>"Registrasi","value"=>90,"color"=>"bg-red-400","date"=>"2025-09-20"],
            ["label"=>"Konsultasi","value"=>87,"color"=>"bg-orange-400","date"=>"2025-09-21"],
            ["label"=>"Monitoring","value"=>93,"color"=>"bg-teal-400","date"=>"2025-09-20"],
        ];

        foreach ($data as $item) {
            ChartLayanan::create($item);
        }
    }
}
