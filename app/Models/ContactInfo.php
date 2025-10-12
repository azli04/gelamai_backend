<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'call_center_1',
        'call_center_2',
        'email',
        'working_hours',
        'twitter',
        'youtube',
        'instagram',
        'facebook',
    ];
}
