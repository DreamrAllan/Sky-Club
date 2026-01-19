<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserInfo extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function booking(): HasMany
    {
        return $this->hasMany(Booking::class, 'user_info');
    }
}
