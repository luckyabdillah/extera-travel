<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class HeroImage extends Model
{
    protected $fillable = ['uuid', 'title', 'path'];

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    protected static function booted()
    {
        static::creating(function ($heroImage) {
            $heroImage->uuid = (string) Str::uuid();
        });
    }
}
