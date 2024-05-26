<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Food extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'price',
        'income_price',
        'duration_hours',
        'image_url',
    ];

    public function feed_purchases(): HasMany
    {
        return $this->hasMany(Feed_purchase::class);
    }
}
