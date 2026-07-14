<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Gallery extends Model
{
    protected $fillable = ['uuid', 'title', 'description', 'path'];

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    protected static function booted()
    {
        static::creating(function ($gallery) {
            $gallery->uuid = (string) Str::uuid();
        });
    }
}
