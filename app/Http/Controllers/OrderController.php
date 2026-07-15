<?php

namespace App\Http\Controllers;

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
        $package->load(['prices', 'category']);
        return view('checkout.form', compact('package'));
    }

    public function storeCustomers(Request $request, Package $package)
    {
        $validated = $request->validate([
            'booker_name' => 'required|string|max:255',
            'booker_email' => 'required|email|max:255',
            'booker_phone' => 'nullable|string|max:100',
            'total_pax' => 'required|integer|min:1|max:100',
            'passengers' => 'required|array|min:1',
            'passengers.*.name' => 'required|string|max:255',
            'passengers.*.email' => 'nullable|email|max:255',
            'passengers.*.phone' => 'nullable|string|max:100',
            'passengers.*.gender' => 'required|in:male,female',
        ]);

        $customers = [];
        foreach ($validated['passengers'] as $pax) {
            $customer = Customer::create([
                'name' => $pax['name'],
                'email' => $pax['email'] ?? $validated['booker_email'],
                'phone' => $pax['phone'] ?? $validated['booker_phone'],
                'sex' => $pax['gender'],
            ]);
            $customers[] = $customer;
        }

        session([
            'checkout' => [
                'package_uuid' => $package->uuid,
                'booker_name' => $validated['booker_name'],
                'booker_email' => $validated['booker_email'],
                'booker_phone' => $validated['booker_phone'],
                'total_pax' => $validated['total_pax'],
                'customer_uuids' => array_map(fn($c) => $c->uuid, $customers),
            ]
        ]);

        $cheapest = $package->cheapestPrice();
        $package->load('prices');

        return view('checkout.confirm', compact('package', 'customers', 'cheapest'));
    }

    public function confirm(Request $request, Package $package)
    {
        $checkout = session('checkout');
        if (!$checkout || $checkout['package_uuid'] !== $package->uuid) {
            return redirect()->route('checkout', $package)->with('error', 'Sesi kadaluarsa. Silakan mulai lagi.');
        }

        $customers = Customer::whereIn('uuid', $checkout['customer_uuids'])->get();
        $cheapest = $package->cheapestPrice();
        $totalBill = $cheapest ? $cheapest->price * $checkout['total_pax'] : 0;

        $transaction = DB::transaction(function () use ($package, $checkout, $totalBill) {
            $year = date('Y');
            $lastInvoice = Transaction::where('invoice_year', $year)->max('invoice_no');
            $nextNum = $lastInvoice ? (int)substr($lastInvoice, 3) + 1 : 1;

            $transaction = Transaction::create([
                'invoice_no' => 'INV' . str_pad($nextNum, 5, '0', STR_PAD_LEFT),
                'invoice_year' => $year,
                'name' => $checkout['booker_name'],
                'email' => $checkout['booker_email'],
                'phone' => $checkout['booker_phone'],
                'total_bill' => $totalBill,
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'expiration_time' => 24,
            ]);

            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'description' => $package->title . ' x ' . $checkout['total_pax'] . ' pax',
                'qty' => $checkout['total_pax'],
                'unit_price' => $cheapest?->price ?? 0,
            ]);

            return $transaction;
        });

        session()->forget('checkout');

        // Send email
        try {
            Mail::send('emails.invoice', compact('transaction', 'package', 'customers'), function ($msg) use ($transaction) {
                $msg->to($transaction->email, $transaction->name)
                    ->subject('Invoice #' . $transaction->invoice_no . ' - Extera Travel');
            });
        } catch (\Exception $e) {
            // Email failure shouldn't break the flow
        }

        return redirect()->route('checkout.success', $transaction->uuid);
    }

    public function success(Transaction $transaction)
    {
        return view('checkout.success', compact('transaction'));
    }
}
