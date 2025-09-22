<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profil extends Model
{
    use HasFactory;

    // Nama tabel (opsional, kalau beda dengan default plural)
    protected $table = 'profil';

    // Kolom yang boleh diisi (mass assignment)
    protected $fillable = [
        'title',
        'image',
        'details',
    ];
}
