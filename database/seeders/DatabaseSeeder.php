<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Urutan seeder HARUS sesuai dependensi
        $this->call([
            RolesSeeder::class,        // duluan, karena user butuh role
            UsersSeeder::class,        // setelah roles, isi user admin

            // Master data
            //KategoriSeeder::class,     
            //ParameterUjiSeeder::class, 
            //BiayaUjiSeeder::class,     // relasi ke kategori + parameter

            // FAQ
            FaqKategoriSeeder::class,  // ✅ kategori FAQ harus ada dulu
            //FaqSeeder::class,          // baru data FAQ

            // Konten informasi
            ArtikelSeeder::class,
            BeritaEventSeeder::class,
        ]);
    }
}
