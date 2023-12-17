<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class LineSector extends Model
{
    use HasFactory;

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($model) {
            $time = Carbon::now()->addHours(2);
            $model->created_at = $time;
            $model->updated_at = $time;
        });
    }

    protected $table = 'line_sector';

    protected $fillable = [
        'line_id',
        'sector_id',
    ];
}
