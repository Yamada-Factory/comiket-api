<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    protected $table = 'event';

    protected $fillable = [
        'name',
        'location_facility',
        'location_address',
        'location_googlemap',
        'location_latitude',
        'location_longitude',
        'from_at',
        'to_at',
    ];

    protected $dates = [
        'from_at',
        'to_at',
        'created_at',
        'created_at',
        'updated_at',
    ];
}
