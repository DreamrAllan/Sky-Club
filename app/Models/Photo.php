<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Photo extends Model
{
    use HasFactory;
    protected $with = ['field'];
    protected $guarded = [];
    public function field(): BelongsTo
    {
        return $this->belongsTo(Field::class, 'id_field');
    }
}
