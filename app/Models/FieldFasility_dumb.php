<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldFasility_dumb extends Model
{
    use HasFactory;
    protected $table = 'field_fasility_dumbs';
    protected $fillable = [
        'facilities'
    ];
}
