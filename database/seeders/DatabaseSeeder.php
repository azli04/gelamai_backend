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
            //KategoriSeeder::class,     // kategori harus ada dulu
            ParameterUjiSeeder::class, // parameter harus ada dulu
            BiayaUjiSeeder::class,     // relasi ke kategori + parameter

            // Konten informasi
            FaqSeeder::class,
            ArtikelSeeder::class,
            BeritaEventSeeder::class,
        ]);
    }
}
