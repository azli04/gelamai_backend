<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aplikasi extends Model
{
    use HasFactory;

    protected $table = 'aplikasi';
    protected $primaryKey = 'id_aplikasi';

    protected $fillable = [
        'nama_app',   // 🔹 disamakan
        'url',
        'kategori',
        'image',
        'deskripsi',
    ];
}
