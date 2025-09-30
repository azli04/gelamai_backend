<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $kategoris = [
            ['nama' => 'Uji Napza'],
            ['nama' => 'Uji Pangan'],
            ['nama' => 'Uji Kosmetik'],
            ['nama' => 'Uji Obat Tradisional'],
            ['nama' => 'Uji Obat'],
            ['nama' => 'Uji Potensi dan Sterilitas'],
        ];

        DB::table('kategori')->insert($kategoris);
    }
}
