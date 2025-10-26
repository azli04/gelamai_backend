<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $table = 'faqs';

    protected $fillable = [
        'question_id',
        'topik',
        'pertanyaan',
        'jawaban',
        'urutan',
        'is_active',
        'view_count',
        'published_by',
        'published_at'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'view_count' => 'integer',
        'urutan' => 'integer',
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relasi ke Pertanyaan - RENAME untuk menghindari konflik dengan kolom 'pertanyaan'
    public function pertanyaanRelation()
    {
        return $this->belongsTo(Pertanyaan::class, 'question_id');
    }

    // Relasi ke User (publisher)
    public function publisher()
    {
        return $this->belongsTo(User::class, 'published_by', 'id_user');
    }

    // Scope untuk filter aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk sorting berdasarkan urutan
    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan', 'asc');
    }

    // Scope untuk filter berdasarkan topik
    public function scopeByTopic($query, $topik)
    {
        return $query->where('topik', $topik);
    }

    // Method untuk increment view count
    public function incrementViewCount()
    {
        $this->increment('view_count');
    }
}
