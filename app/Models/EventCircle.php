<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class EventCircle extends Model
{
    use HasFactory;

    protected $table = 'event_circle';

    protected $fillable = [
        'circle_id',
        'event_id',
        'hall',
        'day',
        'block',
        'space',
        'genre',
        'description',
        'menu',
        'images',
        'other',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'images'  => 'json',
        'other'  => 'json',
    ];

    public function circle(): HasManyThrough
    {
        return $this->hasManyThrough(Circle::class, CircleLink::class);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
