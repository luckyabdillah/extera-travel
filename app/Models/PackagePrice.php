<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackagePrice extends Model
{
    protected $fillable = ['package_id', 'price_type', 'currency', 'price'];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
