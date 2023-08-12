<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BrainBox extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'line_id',
    ];

    public function line(): BelongsTo
    {
        return $this->BelongsTo(Line::class);
    }

    public function topic() : HasMany
    {
        return $this->HasMany(Topic::class);
    }

}

