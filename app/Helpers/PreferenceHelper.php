<?php

namespace App\Helpers;

use App\Models\Preference;
use Illuminate\Support\Facades\Cache;

class PreferenceHelper
{
    // Get preference based on key
    public static function get($key, $default = null)
    {
        $preference = Cache::remember("preference.{$key}", 3600, function () use ($key) {
            return Preference::where('key', $key)->first();
        });

        if (!$preference) {
            return $default;
        }

        return self::castValue($preference);
    }

    // Store preference based on key
    public static function store($key, $value)
    {
        $preference = Preference::where('key', $key)->first();
    
        if ($preference) {
            $preference->update(['value' => $value]);
    
            Cache::put("preference.{$key}", $preference, 3600);
        }
    }

    // Autocast data type
    protected static function castValue($preference)
    {
        return match ($preference->type) {
            'int'     => (int) $preference->value,
            'boolean' => filter_var($preference->value, FILTER_VALIDATE_BOOLEAN),
            'json'    => json_decode($preference->value, true),
            default   => $preference->value,
        };
    }
}
