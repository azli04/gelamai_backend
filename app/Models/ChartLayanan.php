<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChartLayanan extends Model
{
    use HasFactory;

    protected $table = 'chart_layanan';

    protected $fillable = [
        'label',
        'value',
        'color',
        'date',
    ];
}
