<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'src',
        'user_id',
        'line_id',
        'sector_id',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    public function line(): BelongsTo
    {
        return $this->BelongsTo(Line::class);
    }

    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class,'favorite_videos');
    }
}