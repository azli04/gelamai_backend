<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeritaEvent extends Model
{
    use HasFactory;

    protected $table = 'berita_event';
    protected $primaryKey = 'id_berita'; // ✅ sesuai migration
    public $timestamps = true;

    protected $fillable = [
        'judul',
        'isi',
        'gambar',
        'tipe',
        'tanggal',
        'views',
    ];
}
