<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Customer extends Model
{
    protected $fillable = ['uuid', 'name', 'email', 'phone', 'sex'];

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    protected static function booted()
    {
        static::creating(function ($customer) {
            $customer->uuid = (string) Str::uuid();
        });
    }
}
