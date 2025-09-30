<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TbBiayaUjiSeeder extends Seeder
{
    public function run()
    {
        $napzaId = DB::table('kategori')->where('nama', 'Uji Napza')->value('id');

        $data = [
            [
                'kategori_id'   => $napzaId,
                'parameter'     => 'Ganja',
                'biaya'         => 400000
            ],
            [
                'kategori_id'   => $napzaId,
                'parameter'     => 'Shabu',
                'biaya'         => 650000
            ],
            [
                'kategori_id'   => $napzaId,
                'parameter'     => 'Ekstasi',
                'biaya'         => 650000
            ],
        ];

        DB::table('tb_biaya_uji')->insert($data);
    }
}
