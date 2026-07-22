<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    protected $fillable = ['title', 'image_cover', 'slug', 'content'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
