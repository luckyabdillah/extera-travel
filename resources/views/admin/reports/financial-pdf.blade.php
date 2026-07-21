<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan {{ $year }}</title>
    <style>
        @page { margin: 20px; }
        body { font-family: "DejaVu Sans", sans-serif; font-size: 10px; color: #1a1a1a; margin: 0; padding: 20px; }
        h1 { font-size: 18px; color: #c99a1e; text-align: center; margin: 0 0 4px; }
        h2 { font-size: 14px; color: #333; margin: 20px 0 8px; border-bottom: 1px solid #ddd; padding-bottom: 4px; }
        .subtitle { text-align: center; font-size: 11px; color: #666; margin-bottom: 16px; }
        .summary { width: 100%; margin-bottom: 16px; }
        .summary td { padding: 6px 10px; border: 1px solid #ddd; text-align: center; font-size: 11px; }
        .summary .label { font-size: 9px; color: #666; text-transform: uppercase; }
        .summary .value { font-size: 14px; font-weight: bold; }
        .summary .value.green { color: #16a34a; }
        .summary .value.orange { color: #d97706; }
        .summary .value.red { color: #dc2626; }
        .summary .value.blue { color: #2563eb; }
        table.detail { width: 100%; border-collapse: collapse; margin: 8px 0 16px; font-size: 10px; }
        table.detail th { background: #1a1a1a; color: #fff; padding: 6px 8px; text-align: left; }
        table.detail th.right { text-align: right; }
        table.detail td { padding: 4px 8px; border-bottom: 1px solid #eee; }
        table.detail td.right { text-align: right; }
        table.detail .total-row td { font-weight: bold; border-top: 2px solid #333; }
        .footer { text-align: center; font-size: 9px; color: #999; margin-top: 24px; border-top: 1px solid #ddd; padding-top: 8px; }
    </style>
</head>
<body>
    <h1>EXTERA TRAVEL</h1>
    <p class="subtitle">Laporan Keuangan Tahun {{ $year }}</p>

    <table class="summary">
        <tr>
            <td style="width:25%"><div class="label">Total Pendapatan</div><div class="value green">Rp {{ number_format($totalRevenue, 0, ",", ".") }}</div></td>
            <td style="width:25%"><div class="label">Belum Dibayar</div><div class="value orange">Rp {{ number_format($totalUnpaid, 0, ",", ".") }}</div></td>
            <td style="width:25%"><div class="label">Refund</div><div class="value red">Rp {{ number_format($totalRefund, 0, ",", ".") }}</div></td>
            <td style="width:25%"><div class="label">Total Transaksi</div><div class="value blue">{{ $totalTransactions }}</div></td>
        </tr>
    </table>

    <h2>Pendapatan per Bulan</h2>
    @php($bulan = [1 => "Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"])
    <table class="detail">
        <tr><th>Bulan</th><th class="right">Paid</th><th class="right">Unpaid</th><th class="right">Refund</th><th class="right">Total</th></tr>
        @foreach($months as $m => $data)
            <tr>
                <td>{{ $bulan[$m] }}</td>
                <td class="right">Rp {{ number_format($data["paid"], 0, ",", ".") }}</td>
                <td class="right">Rp {{ number_format($data["unpaid"], 0, ",", ".") }}</td>
                <td class="right">Rp {{ number_format($data["refunded"], 0, ",", ".") }}</td>
                <td class="right">Rp {{ number_format($data["paid"] + $data["unpaid"] + $data["refunded"], 0, ",", ".") }}</td>
            </tr>
        @endforeach
    </table>

    <h2>Pendapatan per Kategori Paket</h2>
    <table class="detail">
        <tr><th>Kategori</th><th class="right">Booking</th><th class="right">Revenue</th></tr>
        @forelse($categoryRevenue as $cr)
            <tr>
                <td>{{ $cr->category ?? "Tanpa Kategori" }}</td>
                <td class="right">{{ $cr->bookings }}</td>
                <td class="right">Rp {{ number_format($cr->revenue, 0, ",", ".") }}</td>
            </tr>
        @empty
            <tr><td colspan="3" class="right">Belum ada data.</td></tr>
        @endforelse
    </table>

    <h2>Paket Terlaris</h2>
    <table class="detail">
        <tr><th>Paket</th><th class="right">Booking</th><th class="right">Revenue</th></tr>
        @forelse($topPackages as $tp)
            <tr>
                <td>{{ $tp->package?->title ?? "Paket Dihapus" }}</td>
                <td class="right">{{ $tp->bookings }}</td>
                <td class="right">Rp {{ number_format($tp->revenue, 0, ",", ".") }}</td>
            </tr>
        @empty
            <tr><td colspan="3" class="right">Belum ada data.</td></tr>
        @endforelse
    </table>

    <div class="footer">
        &copy; {{ date("Y") }} Extera Travel &mdash; Dihasilkan pada {{ now()->locale("id")->isoFormat("DD MMMM YYYY") }}
    </div>
</body>
</html>