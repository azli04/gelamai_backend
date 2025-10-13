<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

    protected $table = 'pengaduans';

    protected $fillable = [
        'nama_lengkap',
        'umur',
        'nama_perusahaan',
        'jenis_perusahaan',
        'jenis_pengaduan',
        'jenis_produk',
        'tanggal',
        'jam',
        'email',
        'no_telepon',
        'alamat',
        'nama_produk',
        'no_registrasi',
        'kadaluarsa',
        'nama_pabrik',
        'alamat_pabrik',
        'batch',
        'pertanyaan',
        'attachments',
        'status',
        'tanggapan',
        'ditanggapi_oleh',
        'tanggal_tanggapan',
    ];

    protected $casts = [
        'attachments' => 'array',
        'tanggal' => 'date',
        'kadaluarsa' => 'date',
        'tanggal_tanggapan' => 'datetime',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'ditanggapi_oleh');
    }
}
