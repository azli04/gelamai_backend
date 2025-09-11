<?php

// app/Models/Layanan.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
     protected $fillable = [
        'title',       // untuk sidebar
        'Image',     // cover/thumbnail
        'details',     // konten bebas (HTML)
    ];
}
