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
        'image',
        'brain_box_id',
    ];

    public function brainBox(): BelongsTo
    {
        return $this->BelongsTo(BrainBox::class);
    }

    public function comments() : HasMany
    {
        return $this->HasMany(Comment::class);
    }
}
