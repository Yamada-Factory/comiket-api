<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CircleLink extends Model
{
    use HasFactory;

    protected $table = 'circle_link';

    protected $fillable = ['circle_id', 'type', 'url'];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function circle(): BelongsTo
    {
        return $this->belongsTo(Circle::class);
    }
}
