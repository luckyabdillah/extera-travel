<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Hotel extends Model
{
    protected $fillable = [
        'uuid', 'name', 'address', 'city',
        'star_rating', 'phone', 'email', 'description',
        'latitude', 'longitude',
    ];

    protected function casts(): array
    {
        return [
            'star_rating' => 'integer',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    protected static function booted()
    {
        static::creating(function ($hotel) {
            $hotel->uuid = (string) Str::uuid();
        });
    }
}
