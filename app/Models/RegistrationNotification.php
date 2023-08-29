<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'sector_id',
        'line_id',
    ];
}
