<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        Faq::create([
            'pertanyaan'=>'Bagaimana cara mengirim sampel?',
            'jawaban'=>'Isi form online lalu kirim ke alamat BBPOM Padang.'
        ]);
    }
}
