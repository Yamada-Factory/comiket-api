<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class UserFavoriteEventCircle extends Model
{
    use HasFactory;

    protected $table = 'user_favorite_event_circle';

    protected $fillable = [
        'user_id',
        'favorite_circle_id',
        'event_id',
        'priority',
        'e-commerce_flag',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'e-commerce_flag' => 'boolean',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function getEvent(): ?Event
    {
        return $this->event()->getResults();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getUserInfo(): ?User
    {
        return $this->user()->getResults();
    }

    public function circle(): HasOneThrough
    {
        return $this->HasOneThrough(Circle::class, UserFavoriteCircle::class, 'id', 'id', 'favorite_circle_id', 'circle_id');
    }
}
