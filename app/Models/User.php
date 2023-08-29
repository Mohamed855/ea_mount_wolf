<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'user_name',
        'crm_code',
        'email',
        'phone_number',
        'password',
        'profile_image',
        'title_id',
        'line_id',
        'sector_id',
        'role',
        'activated',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function title(): HasOne
    {
        return $this->HasOne(Title::class);
    }

    public function file(): HasMany
    {
        return $this->HasMany(File::class);
    }

    public function comment() : HasMany
    {
        return $this->HasMany(Comment::class);
    }

    public function line() : BelongsTo
    {
        return $this->BelongsTo(Line::class);
    }

    public function sector() : BelongsTo
    {
        return $this->BelongsTo(Sector::class);
    }

    public function files() : BelongsToMany
    {
        return $this->belongsToMany(File::class, 'favorites');
    }

    public function videos() : BelongsToMany
    {
        return $this->belongsToMany(Video::class, 'favorite_videos');
    }

}
