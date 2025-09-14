<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $table = 'faq';
    protected $primaryKey = 'id_faq';
    protected $fillable = ['pertanyaan','jawaban','status','id_faq_kategori','answered_by'];

    public function kategori()
    {
        return $this->belongsTo(FaqKategori::class, 'id_faq_kategori');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'answered_by');
    }
}
