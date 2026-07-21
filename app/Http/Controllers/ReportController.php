<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function financial(Request $request)
    {
        $year = $request->get("year", date("Y"));

        $data = $this->getReportData($year);

        return view("admin.reports.financial", $data);
    }

    public function financialPdf(Request $request)
    {
        $year = $request->get("year", date("Y"));

        $data = $this->getReportData($year);

        $pdf = Pdf::loadView("admin.reports.financial-pdf", $data);

        return $pdf->stream("laporan-keuangan-{$year}.pdf");
    }

    private function getReportData($year)
    {
        $transactions = Transaction::whereYear("transactions.created_at", $year);

        $totalRevenue = (clone $transactions)->where("transactions.payment_status", "paid")->sum("transactions.total_bill");
        $totalUnpaid = (clone $transactions)->where("transactions.payment_status", "unpaid")->sum("transactions.total_bill");
        $totalRefund = (clone $transactions)->where("transactions.payment_status", "refunded")->sum("transactions.total_bill");
        $totalTransactions = (clone $transactions)->count();
        $confirmedCount = (clone $transactions)->where("transactions.status", "confirmed")->count();
        $pendingCount = (clone $transactions)->where("transactions.status", "pending")->count();

        $monthlyRevenue = (clone $transactions)
            ->selectRaw("MONTH(transactions.created_at) as month, transactions.payment_status, SUM(transactions.total_bill) as total")
            ->groupByRaw("MONTH(transactions.created_at), transactions.payment_status")
            ->get()
            ->groupBy("month");

        $months = [];
        for ($m = 1; $m <= 12; $m++) {
            $data = $monthlyRevenue->get($m, collect());
            $months[$m] = [
                "paid" => $data->where("payment_status", "paid")->sum("total"),
                "unpaid" => $data->where("payment_status", "unpaid")->sum("total"),
                "refunded" => $data->where("payment_status", "refunded")->sum("total"),
            ];
        }

        $topPackages = (clone $transactions)
            ->where("transactions.payment_status", "paid")
            ->whereNotNull("transactions.package_id")
            ->selectRaw("transactions.package_id, SUM(transactions.total_bill) as revenue, COUNT(*) as bookings")
            ->groupBy("transactions.package_id")
            ->orderByDesc("revenue")
            ->take(5)
            ->get()
            ->load("package");

        $categoryRevenue = (clone $transactions)
            ->where("transactions.payment_status", "paid")
            ->whereNotNull("transactions.package_id")
            ->join("packages", "transactions.package_id", "=", "packages.id")
            ->join("package_categories", "packages.package_category_id", "=", "package_categories.id")
            ->selectRaw("package_categories.name as category, SUM(transactions.total_bill) as revenue, COUNT(*) as bookings")
            ->groupBy("package_categories.name")
            ->orderByDesc("revenue")
            ->get();

        $years = Transaction::selectRaw("YEAR(created_at) as year")
            ->distinct()
            ->orderByDesc("year")
            ->pluck("year");

        return compact(
            "totalRevenue", "totalUnpaid", "totalRefund",
            "totalTransactions", "confirmedCount", "pendingCount",
            "months", "topPackages", "categoryRevenue",
            "year", "years"
        );
    }
}