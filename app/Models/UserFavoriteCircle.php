<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserFavoriteCircle extends Model
{
    use HasFactory;

    protected $table = 'user_favorite_circle';

    public const DEFAULT_COLOR = '#000000';

    protected $fillable = [
        'user_id',
        'circle_id',
        'color',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function circle(): BelongsTo
    {
        return $this->belongsTo(Circle::class);
    }

    public function getCircle(): ?Circle
    {
        return $this->circle()->latest()->first();
    }

    public function favoriteEventCircle(): HasMany
    {
        return $this->hasMany(UserFavoriteEventCircle::class, 'favorite_circle_id');
    }

    public function getUserFavoriteEventCircle(): Collection
    {
        return $this->favoriteEventCircle()->getResults();
    }
}
