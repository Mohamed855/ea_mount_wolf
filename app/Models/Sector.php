<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sector extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'employees_number',
        'files_number',
        'views_number',
    ];

    public function user() : HasMany
    {
        return $this->HasMany(User::class);
    }

    public function line() : BelongsToMany
    {
        return $this->belongsToMany(Line::class)->using(LineSector::class);
    }
}
