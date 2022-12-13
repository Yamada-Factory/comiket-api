<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Circle extends Model
{
    use HasFactory;

    protected $table = 'circle';

    protected $fillable = ['name', 'author', 'circle_ms_id'];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function links(): HasMany
    {
        return $this->hasMany(CircleLink::class);
    }

    public function getLinks()
    {
        return $this->links()->getResults();
    }
}
