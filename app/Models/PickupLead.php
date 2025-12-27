<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PickupLead extends Model
{
    use HasFactory;

    protected $fillable = ['contact','answers_json'];

    protected $casts = [
        'answers_json' => 'array'
    ];
}
