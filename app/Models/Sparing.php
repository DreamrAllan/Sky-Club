<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sparing extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function getFormattedStatusSparingAttribute(): string
    {
        if ($this->status_sparing == 'pending') {
            return 'Menunggu Lawan';
        } elseif ($this->status_sparing == 'done') {
            return 'Selesai';
        }
        return 'default';
    }
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function request(): HasMany
    {
        return $this->hasMany(SparingRequest::class, 'id_sparing');
    }
    public function listBooking(): BelongsTo
    {
        return $this->belongsTo(ListBooking::class, 'id_list_booking');
    }
}
