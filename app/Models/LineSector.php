<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LineSector extends Model
{
    use HasFactory;

    protected $fillable = [
        'line_id',
        'sector_id',
    ];
}
