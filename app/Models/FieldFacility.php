<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldFacility extends Model
{
    use HasFactory;
    protected $table = "field_facilities";
    protected $guarded = [];
}
