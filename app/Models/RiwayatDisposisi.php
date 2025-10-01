<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatDisposisi extends Model
{
    use HasFactory;

    protected $table = 'riwayat_disposisi';

    protected $fillable = [
        'pertanyaan_id','dari_user_id','ke_user_id','catatan'
    ];

    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class, 'pertanyaan_id');
    }

    public function dari()
    {
        return $this->belongsTo(User::class, 'dari_user_id');
    }

    public function ke()
    {
        return $this->belongsTo(User::class, 'ke_user_id');
    }
}

