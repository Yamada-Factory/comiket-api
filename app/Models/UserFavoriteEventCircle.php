<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFavoriteEventCircle extends Model
{
    use HasFactory;

    protected $table = 'user_favorite_circle';

    protected $fillable = [
        'user_id',
        'circle_id',
        'priority',
        'e-commerce_flag',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'e-commerce_flag' => 'boolean'
    ];
}
