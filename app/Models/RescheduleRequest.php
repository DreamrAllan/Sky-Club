<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RescheduleRequest extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function getFormattedSessionAttribute()
    {
        return str_pad($this->attributes['session'] - 1, 2, '0', STR_PAD_LEFT) . ':00 - ' . str_pad($this->attributes['session'], 2, '0', STR_PAD_LEFT) . ':00';
    }
    public function getFormattedDateAttribute()
    {
        return Carbon::parse($this->attributes['date'])->format('d F Y');
    }
    public function getFormattedCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format('d F Y | H:m');
    }
    public function listBooking(): BelongsTo
    {
        return $this->belongsTo(ListBooking::class, 'id_list_booking');
    }
}
