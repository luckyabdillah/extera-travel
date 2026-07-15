<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Package extends Model
{
    protected $fillable = [
        'uuid', 'package_category_id', 'title', 'slug', 'flyer_path',
        'flight_by', 'date', 'total_days', 'quota',
        'inclusions', 'exclusions', 'requirements',
    ];

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function category()
    {
        return $this->belongsTo(PackageCategory::class, 'package_category_id');
    }

    public function prices()
    {
        return $this->hasMany(PackagePrice::class);
    }

    public function cheapestPrice(): ?PackagePrice
    {
        return $this->prices->sortBy('price')->first();
    }

    protected static function booted()
    {
        static::creating(function ($package) {
            $package->uuid = (string) Str::uuid();

            if (!$package->slug) {
                $slug = Str::slug($package->title);
                $originalSlug = $slug;
                $counter = 1;
                while (Package::where('slug', $slug)->exists()) {
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }
                $package->slug = $slug;
            }
        });

        static::updating(function ($package) {
            if ($package->isDirty('title') && !$package->isDirty('slug')) {
                $slug = Str::slug($package->title);
                $originalSlug = $slug;
                $counter = 1;
                while (Package::where('slug', $slug)->where('id', '!=', $package->id)->exists()) {
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }
                $package->slug = $slug;
            }
        });
    }
}
