<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Field extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->attributes['price'], 0, ',', '.');
    }
    public function listBooking(): HasMany
    {
        return $this->hasMany(ListBooking::class);
    }
    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class, 'id_field');
    }
    public function facility(): BelongsToMany
    {
        return $this->belongsToMany(Facility::class, 'field_facilities', 'id_field', 'id_facility');
    }
}
