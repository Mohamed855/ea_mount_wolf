<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'size',
        'user_id',
        'line_id',
        'sector_id',
        'viewed',
        'downloaded',
    ];

    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    public function line(): BelongsTo
    {
        return $this->BelongsTo(Line::class);
    }

    public function favorite() : BelongsToMany
    {
        return $this->belongsToMany(User::class)->using(Favorite::class);
    }
}
