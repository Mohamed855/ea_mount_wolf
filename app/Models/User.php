<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($model) {
            $time = Carbon::now()->addHours(2);
            $model->created_at = $time;
            $model->updated_at = $time;
        });
    }

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
        'lines',
        'sectors',
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
        'lines' => 'array',
        'sectors' => 'array',
    ];

    public function title(): BelongsTo
    {
        return $this->belongsTo(Title::class);
    }

    public function file(): HasMany
    {
        return $this->HasMany(File::class);
    }

    public function comment() : HasMany
    {
        return $this->HasMany(Comment::class);
    }

    public function files() : BelongsToMany
    {
        return $this->belongsToMany(File::class, 'favorites');
    }

    public function videos() : BelongsToMany
    {
        return $this->belongsToMany(Video::class, 'favorite_videos');
    }

    public function audios() : BelongsToMany
    {
        return $this->belongsToMany(Audio::class, 'favorite_audios');
    }
}
