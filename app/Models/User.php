<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'user';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'no_telp',
        'team',
        'address',
        'date_of_birth',
        'password',
    ];

    public function getFormattedProfilePhotoAttribute(): string
    {
        if (!$this->profile_photo) {
            return asset('assets/icons/profile.svg');
        }
        return asset('storage/' . $this->profile_photo);
    }
    public function article(): HasMany
    {
        return $this->hasMany(Article::class);
    }
    public function booking(): HasMany
    {
        return $this->hasMany(Booking::class, 'rented_by');
    }
    public function sparingCreated(): HasMany
    {
        return $this->hasMany(Sparing::class, 'created_by');
    }
    public function sparingRequest(): HasMany
    {
        return $this->hasMany(SparingRequest::class, 'id_user');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    // protected $hidden = [
    //     'password',
    //     'remember_token',
    // ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
