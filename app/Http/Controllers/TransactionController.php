<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with('details')
            ->latest();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('invoice_no', 'like', "%{$s}%")
                  ->orWhere('name', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        $transactions = $query->paginate(15);

        return view('admin.transactions.index', compact('transactions'));
    }

    public function create()
    {
        $packages = Package::orderBy('title')->get();

        return view('admin.transactions.create', compact('packages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:100',
            'package_id' => 'nullable|exists:packages,id',
            'status' => 'required|in:pending,confirmed',
            'payment_status' => 'required|in:unpaid,paid',
            'expiration_time' => 'nullable|integer|min:0',
        ]);

        $year = date('Y');
        $lastInvoice = Transaction::where('invoice_year', $year)->max('invoice_no');
        $nextNum = $lastInvoice ? (int)substr($lastInvoice, 3) + 1 : 1;

        $transaction = Transaction::create([
            'package_id' => $validated['package_id'] ?? null,
            'invoice_no' => 'INV' . str_pad($nextNum, 5, '0', STR_PAD_LEFT),
            'invoice_year' => $year,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'total_bill' => 0,
            'status' => $validated['status'],
            'payment_status' => $validated['payment_status'],
            'expiration_time' => $validated['expiration_time'] ?? 24,
        ]);

        return redirect()->route('admin.transactions.show', $transaction)
            ->with('success', 'Transaksi berhasil dibuat. Silakan tambahkan item pesanan.');
    }

    public function show(Transaction $transaction)
    {
        $transaction->load('details');

        return view('admin.transactions.show', compact('transaction'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'status' => 'nullable|in:pending,confirmed',
            'payment_status' => 'nullable|in:unpaid,paid',
        ]);

        $oldStatus = $transaction->status;
        $newStatus = $validated['status'] ?? $oldStatus;
        $packagePax = (int) ($transaction->package_pax ?? 0);

        $transaction->update($validated);

        if ($oldStatus !== $newStatus && $transaction->package_id && $packagePax > 0) {
            $package = Package::find($transaction->package_id);

            if ($package) {
                if ($newStatus === 'confirmed') {
                    $package->decrement('quota', $packagePax);
                } elseif ($oldStatus === 'confirmed' && $newStatus === 'pending') {
                    $package->increment('quota', $packagePax);
                }
            }
        }

        return redirect()->route('admin.transactions.show', $transaction)
            ->with('success', 'Status transaksi berhasil diperbarui.');
    }
}
