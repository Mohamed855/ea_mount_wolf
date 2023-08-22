<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Line extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function user(): HasMany
    {
        return $this->HasMany(User::class);
    }

    public function file(): HasMany
    {
        return $this->HasMany(File::class);
    }

    public function sector() : BelongsToMany
    {
        return $this->belongsToMany(Sector::class);
    }
}
