<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

class File extends Model
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

    protected $fillable = [
        'name',
        'type',
        'size',
        'user_id',
        'titles',
        'lines',
        'sectors',
        'status',
        'stored_name',
    ];

    protected $casts = [
        'titles' => 'array',
        'lines' => 'array',
        'sectors' => 'array',
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
        return $this->belongsToMany(User::class,'favorites');
    }
}
