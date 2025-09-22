<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    use HasFactory;

    protected $table = 'pertanyaan';
    protected $primaryKey = 'id_pertanyaan';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    const STATUS_MENUNGGU = 'menunggu';
    const STATUS_DISPOSISI = 'disposisi';
    const STATUS_DIJAWAB_FUNGSI = 'dijawab fungsi';
    const STATUS_DIJAWAB_WEB = 'dijawab web';
    const STATUS_SELESAI = 'selesai';

    protected $fillable = [
        'nama', 'profesi', 'tanggal_lahir', 'alamat', 'email', 'no_hp', 'topik',
        'isi_pertanyaan', 'status', 'admin_fungsi_id', 'jawaban'
    ];

    public function faq()
    {
        return $this->hasOne(Faq::class, 'pertanyaan_id', 'id_pertanyaan');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_fungsi_id', 'id_admin');
    }
}
