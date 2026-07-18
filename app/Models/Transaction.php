<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class Transaction extends Model
{
    protected $fillable = [
        "uuid", "package_id", "invoice_no", "invoice_year", "name", "email", "phone",
        "total_bill", "status", "payment_status", "expiration_time",
    ];

    public function getRouteKeyName(): string
    {
        return "uuid";
    }

    protected function casts(): array
    {
        return [
            "total_bill" => "decimal:2",
        ];
    }

    public function package()
    {
        return $this->belongsTo(Package::class)->withTrashed();
    }

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function recalculateTotalBill(): void
    {
        $total = $this->details()->sum(DB::raw("qty * unit_price"));
        $this->update(["total_bill" => $total]);
    }

    protected static function booted()
    {
        static::creating(function ($t) {
            $t->uuid = (string) Str::uuid();
        });
    }
}
