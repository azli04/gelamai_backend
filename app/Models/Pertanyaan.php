<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    use HasFactory;

    protected $table = 'pertanyaan';

    protected $fillable = [
        'nama_lengkap',
        'profesi',
        'tanggal_lahir',
        'alamat',
        'email',
        'no_hp',
        'topik',
        'isi_pertanyaan',
        'status'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relasi ke FAQ
    public function faq()
    {
        return $this->hasOne(Faq::class, 'question_id');
    }

    // Scope untuk filter status
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeProcessed($query)
    {
        return $query->where('status', 'processed');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
}
