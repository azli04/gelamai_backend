<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Whistleblowing extends Model
{
    use HasFactory;

    protected $table = 'whistleblowing';
    protected $primaryKey = 'id_whistle';

    protected $fillable = [
        'id_user',
        'nama_lengkap_user',
        'profesi',
        'alamat',
        'tgl_lahir',
        'email',
        'kontak',
        'indikasi_pelanggaran',
        'lokasi_pelanggaran',
        'oknum_pelanggaran',
        'kronologi',
        'data_pendukung',
        'dikirim_ke_kepala',
        'status',
        'id_admin',
    ];

    protected $casts = [
        'tgl_lahir' => 'date',
        'dikirim_ke_kepala' => 'boolean',
    ];

    /**
     * Relasi ke user pelapor (relasi optional)
     */
    public function pelapor()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Relasi ke admin whistle
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'id_admin', 'id_user');
    }

    /**
     * Enkripsi otomatis untuk data sensitif
     */
    public function setKronologiAttribute($value)
    {
        $this->attributes['kronologi'] = $value ? Crypt::encryptString($value) : null;
    }

    public function getKronologiAttribute($value)
    {
        return $value ? Crypt::decryptString($value) : null;
    }

    public function setOknumPelanggaranAttribute($value)
    {
        $this->attributes['oknum_pelanggaran'] = $value ? Crypt::encryptString($value) : null;
    }

    public function getOknumPelanggaranAttribute($value)
    {
        return $value ? Crypt::decryptString($value) : null;
    }
}
