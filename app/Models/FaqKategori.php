<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqKategori extends Model
{
    use HasFactory;

    protected $table = 'faq_kategori';
    protected $primaryKey = 'id_faq_kategori';
    protected $fillable = ['nama','admin_role_id','deskripsi'];

    public function faqs()
    {
        return $this->hasMany(Faq::class, 'id_faq_kategori');
    }

    public function adminRole()
    {
        return $this->belongsTo(Role::class, 'admin_role_id');
    }
}

