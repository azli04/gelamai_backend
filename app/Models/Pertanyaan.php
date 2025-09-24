<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    use HasFactory;

    protected $table = 'pertanyaan';

    protected $fillable = [
        'nama','profesi','tanggal_lahir','alamat','email','no_hp',
        'topik','isi_pertanyaan','jawaban','status','fungsi_id','created_by'
    ];

    public function disposisi()
    {
        return $this->hasMany(RiwayatDisposisi::class);
    }

    public function faq()
    {
        return $this->hasOne(Faq::class);
    }

    public function fungsiTujuan()
    {
        return $this->belongsTo(User::class, 'fungsi_id');
    }
}
