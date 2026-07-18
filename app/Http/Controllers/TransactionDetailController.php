<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;

class TransactionDetailController extends Controller
{
    public function store(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            "description" => "required|string|max:255",
            "qty" => "required|integer|min:1",
            "unit_price" => "required|numeric|min:0",
        ]);

        $transaction->details()->create([
            "description" => $validated["description"],
            "qty" => $validated["qty"],
            "unit_price" => $validated["unit_price"],
        ]);

        $transaction->recalculateTotalBill();

        return redirect()->back()->with("success", "Detail transaksi berhasil ditambahkan.");
    }

    public function update(Request $request, Transaction $transaction, TransactionDetail $detail)
    {
        $validated = $request->validate([
            "description" => "required|string|max:255",
            "qty" => "required|integer|min:1",
            "unit_price" => "required|numeric|min:0",
        ]);

        $detail->update($validated);
        $transaction->recalculateTotalBill();

        return redirect()->back()->with("success", "Detail transaksi berhasil diperbarui.");
    }

    public function destroy(Transaction $transaction, TransactionDetail $detail)
    {
        $detail->delete();
        $transaction->recalculateTotalBill();

        return redirect()->back()->with("success", "Detail transaksi berhasil dihapus.");
    }
}
