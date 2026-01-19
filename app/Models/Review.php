<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;
    protected $with = ['user'];
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class, 'id_booking');
    }
}
