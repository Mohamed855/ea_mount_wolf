<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'user_id',
        'status',
    ];

    public function comments() : HasMany
    {
        return $this->HasMany(Comment::class);
    }
}
