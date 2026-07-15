<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transaction extends Model
{
    protected $fillable = [
        'uuid', 'invoice_no', 'invoice_year', 'name', 'email', 'phone',
        'total_bill', 'status', 'payment_status', 'expiration_time',
    ];

    protected function casts(): array
    {
        return [
            'total_bill' => 'decimal:2',
        ];
    }

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    protected static function booted()
    {
        static::creating(function ($t) {
            $t->uuid = (string) Str::uuid();
        });
    }
}
