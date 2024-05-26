<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'health_level',
        'hunger_level',
        'image_url',
        'price',
    ];
    public function userDogs(): HasMany
    {
        return $this->hasMany(UserDog::class);
    }
}
