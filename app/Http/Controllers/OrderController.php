<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmationMail;
use App\Models\Package;
use App\Models\Customer;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function checkout(Package $package)
    {
        if ($package->quota <= 0) {
            return redirect()->back()->with("error", "Maaf, kuota paket ini sudah habis.");
        }

        $package->load(["prices", "category"]);
        return view("checkout.form", compact("package"));
    }

    public function storeCustomers(Request $request, Package $package)
    {
        $validated = $request->validate([
            "booker_name" => "required|string|max:255",
            "booker_email" => "required|email|max:255",
            "booker_phone" => "nullable|string|max:100",
            "total_pax" => "required|integer|min:1|max:100",
            "passengers" => "required|array|min:1",
            "passengers.*.name" => "required|string|max:255",
            "passengers.*.email" => "nullable|email|max:255",
            "passengers.*.phone" => "nullable|string|max:100",
            "passengers.*.gender" => "required|in:male,female",
            "passengers.*.price_type" => "required|exists:package_prices,id",
        ]);

        $customers = [];
        $passengerPrices = [];
        foreach ($validated["passengers"] as $pax) {
            $customer = Customer::firstOrCreate(
                [
                    "name" => $pax["name"],
                    "email" => $pax["email"] ?? $validated["booker_email"],
                    "phone" => $pax["phone"] ?? $validated["booker_phone"],
                    "sex" => $pax["gender"],
                ],
                [
                    "name" => $pax["name"],
                    "email" => $pax["email"] ?? $validated["booker_email"],
                    "phone" => $pax["phone"] ?? $validated["booker_phone"],
                    "sex" => $pax["gender"],
                ]
            );
            $customers[] = $customer;
            $passengerPrices[] = [
                "customer_uuid" => $customer->uuid,
                "price_id" => $pax["price_type"],
            ];
        }

        session([
            "checkout" => [
                "package_uuid" => $package->uuid,
                "booker_name" => $validated["booker_name"],
                "booker_email" => $validated["booker_email"],
                "booker_phone" => $validated["booker_phone"],
                "total_pax" => $validated["total_pax"],
                "customer_uuids" => array_map(fn($c) => $c->uuid, $customers),
                "passenger_prices" => $passengerPrices,
            ]
        ]);

        $package->load("prices");

        return redirect()->route("checkout.getConfirmation", $package)->with([
            "package" => $package,
            "customers" => $customers,
        ]);
    }

    public function getConfirmation(Package $package)
    {
        $checkout = session("checkout");
        if (!$checkout) {
            return redirect()->route("packages.index")->with("error", "Sesi checkout tidak ditemukan. Silakan mulai lagi.");
        }

        $customers = Customer::whereIn("uuid", $checkout["customer_uuids"])->get();
        $package->load("prices");

        $priceMap = $package->prices->keyBy("id");

        $passengerPrices = collect($checkout["passenger_prices"])->map(function ($pp) use ($priceMap, $customers) {
            $customer = $customers->firstWhere("uuid", $pp["customer_uuid"]);
            $price = $priceMap[$pp["price_id"]] ?? null;
            return [
                "customer" => $customer,
                "price" => $price,
            ];
        });

        $grouped = $passengerPrices->groupBy(fn($pp) => $pp["price"]->id ?? 0);

        return view("checkout.confirm", compact("package", "customers", "passengerPrices", "grouped"));
    }

    public function confirm(Request $request, Package $package)
    {
        $checkout = session("checkout");
        if (!$checkout || $checkout["package_uuid"] !== $package->uuid) {
            return redirect()->route("checkout", $package)->with("error", "Sesi kadaluarsa. Silakan mulai lagi.");
        }

        $package->load("prices");
        $priceMap = $package->prices->keyBy("id");

        $grouped = collect($checkout["passenger_prices"])->groupBy("price_id");

        $totalBill = 0;
        foreach ($grouped as $priceId => $passengers) {
            $price = $priceMap[$priceId] ?? null;
            $totalBill += ($price?->price ?? 0) * count($passengers);
        }

        $transaction = DB::transaction(function () use ($package, $checkout, $totalBill, $grouped, $priceMap) {
            $year = date("Y");
            $lastInvoice = Transaction::where("invoice_year", $year)->max("invoice_no");
            $nextNum = $lastInvoice ? (int)substr($lastInvoice, 3) + 1 : 1;

            $transaction = Transaction::create([
                "package_id" => $package->id,
                "package_pax" => $checkout["total_pax"],
                "invoice_no" => "INV" . str_pad($nextNum, 5, "0", STR_PAD_LEFT),
                "invoice_year" => $year,
                "name" => $checkout["booker_name"],
                "email" => $checkout["booker_email"],
                "phone" => $checkout["booker_phone"],
                "total_bill" => $totalBill,
                "status" => "pending",
                "payment_status" => "unpaid",
                "expiration_time" => 24,
            ]);

            foreach ($grouped as $priceId => $passengers) {
                $price = $priceMap[$priceId] ?? null;
                $qty = count($passengers);
                $priceType = $price?->price_type ?? "Unknown";

                TransactionDetail::create([
                    "transaction_id" => $transaction->id,
                    "description" => $package->title . " (" . $priceType . ") x " . $qty . " pax",
                    "qty" => $qty,
                    "unit_price" => $price?->price ?? 0,
                ]);
            }

            return $transaction;
        });

        session()->forget("checkout");

        try {
            Mail::to($transaction->email)->send(new OrderConfirmationMail($transaction));
        } catch (\Exception $e) {
            \Log::error("Failed to send order confirmation email: " . $e->getMessage());
        }

        return redirect()->route("checkout.success", $transaction->uuid);
    }

    public function success(Transaction $transaction)
    {
        return view("checkout.success", compact("transaction"));
    }
}