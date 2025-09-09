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
        'nama_user',
        'email',
        'isi',
        'status',
        'id_admin',
        'id_admin_fungsi',
        'jawaban',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function adminPengaduan()
    {
        return $this->belongsTo(User::class, 'id_admin', 'id_user');
    }

    public function adminFungsi()
    {
        return $this->belongsTo(User::class, 'id_admin_fungsi', 'id_user');
    }

}
