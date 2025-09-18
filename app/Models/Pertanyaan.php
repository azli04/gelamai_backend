<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    use HasFactory;

    protected $table = 'pertanyaan';
    protected $primaryKey = 'id_pertanyaan';

    protected $fillable = [
        'nama_lengkap',
        'profesi',
        'tanggal_lahir',
        'alamat',
        'email',
        'no_hp',
        'id_faq_kategori',
        'isi_pertanyaan',
        'status',
    ];

    public function kategori()
    {
        return $this->belongsTo(FaqKategori::class, 'id_faq_kategori');
    }

    public function faq()
    {
        return $this->hasOne(Faq::class, 'id_pertanyaan', 'id_pertanyaan');
    }
}
