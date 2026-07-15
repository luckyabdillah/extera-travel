<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class PackageCategory extends Model
{
    use SoftDeletes;

    protected $fillable = ['uuid', 'name', 'image_cover', 'mark_as_favorite'];

    protected function casts(): array
    {
        return [
            'mark_as_favorite' => 'boolean',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    protected static function booted()
    {
        static::creating(function ($category) {
            $category->uuid = (string) Str::uuid();
        });
    }
}
