<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageItinerary extends Model
{
    protected $fillable = [
        'package_id', 'marker', 'title', 'itinerary',
        'accommodation_place', 'accommodation_days', 'meals',
        'optional_activities', 'included_activities', 'special_information',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
