<?php

namespace App\Http\Controllers;

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

        $transaction->update($validated);

        return redirect()->route('admin.transactions.show', $transaction)
            ->with('success', 'Status transaksi berhasil diperbarui.');
    }
}