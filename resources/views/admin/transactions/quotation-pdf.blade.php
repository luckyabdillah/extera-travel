<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Quotation #{{ $transaction->uuid }}</title>
    <style>
        @page { margin: 30px; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; color: #1a1a1a; margin: 0; padding: 0; }
        .header { text-align: center; padding: 20px 0; border-bottom: 2px solid #2563eb; }
        .header h1 { font-size: 22px; color: #1d4ed8; margin: 0; }
        .header p { font-size: 11px; color: #666; margin: 2px 0 0; }
        .greeting { padding: 16px 0; }
        .greeting h2 { font-size: 16px; margin: 0 0 2px; }
        .greeting p { color: #666; font-size: 12px; margin: 0; }
        .info-box { background: #eff6ff; border-radius: 8px; padding: 12px 16px; margin: 16px 0; }
        .info-box table { width: 100%; }
        .info-box td { padding: 3px 0; }
        .info-box .label { font-size: 10px; color: #666; }
        .info-box .value { font-size: 13px; font-weight: bold; }
        .info-box .total { font-size: 18px; font-weight: bold; color: #1d4ed8; text-align: right; }
        table.items { width: 100%; border-collapse: collapse; margin: 16px 0; font-size: 11px; }
        table.items th { background: #1e3a5f; color: #fff; padding: 8px 10px; text-align: left; }
        table.items th.right { text-align: right; }
        table.items th.center { text-align: center; }
        table.items td { padding: 6px 10px; border-bottom: 1px solid #e2e8f0; }
        table.items td.right { text-align: right; }
        table.items td.center { text-align: center; }
        table.items tfoot td { border-bottom: none; font-weight: bold; padding-top: 10px; }
        table.items tfoot .grand-total { font-size: 14px; color: #1d4ed8; }
        .footer { text-align: center; padding: 16px 0; font-size: 10px; color: #999; border-top: 1px solid #e2e8f0; margin-top: 24px; }
        .note { background: #fff7ed; border: 1px solid #fed7aa; border-radius: 8px; padding: 12px; font-size: 11px; color: #9a3412; text-align: center; margin: 16px 0; }
        .validity { text-align: right; font-size: 11px; color: #666; margin-top: 8px; font-style: italic; }
    </style>
</head>
<body>
    <div class="header">
        <h1>EXTERA TRAVEL</h1>
        <p>Quotation Pemesanan Paket</p>
    </div>

    <div class="greeting">
        <h2>Kepada Yth, {{ $transaction->name }}</h2>
        <p>Terima kasih telah mempercayakan perjalanan ibadah & wisata Anda kepada kami.</p>
    </div>

    <div class="info-box">
        <table>
            <tr><td class="label">No. Quotation</td><td class="value" style="text-align:right;">#{{ $transaction->uuid }}</td></tr>
            <tr><td class="label">Tanggal</td><td class="value" style="text-align:right;">{{ $transaction->created_at->format('d M Y') }}</td></tr>
            <tr><td class="label">Customer</td><td class="value" style="text-align:right;">{{ $transaction->email }} @if($transaction->phone)/ {{ $transaction->phone }} @endif</td></tr>
        </table>
    </div>

    <table class="items">
        <thead>
            <tr><th>Deskripsi</th><th class="center" style="width:60px;">Qty</th><th class="right" style="width:120px;">Harga Satuan</th><th class="right" style="width:120px;">Subtotal</th></tr>
        </thead>
        <tbody>
            @foreach($transaction->details as $detail)
                <tr>
                    <td>{{ $detail->description }}</td>
                    <td class="center">{{ $detail->qty }}</td>
                    <td class="right">Rp {{ number_format($detail->unit_price, 0, ',', '.') }}</td>
                    <td class="right">Rp {{ number_format($detail->unit_price * $detail->qty, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr><td colspan="3" class="right">Total</td><td class="right grand-total">Rp {{ number_format($transaction->total_bill, 0, ',', '.') }}</td></tr>
        </tfoot>
    </table>

    @if($transaction->package)
        <div class="validity">
            Penawaran ini berlaku selama 14 hari sejak tanggal diterbitkan.
        </div>
    @endif

    <div class="note">
        <strong>Catatan:</strong> Harga sewaktu-waktu dapat berubah tanpa pemberitahuan sebelumnya. Harga ini merupakan estimasi dan bukan merupakan tagihan resmi. Silakan hubungi kami untuk konfirmasi ketersediaan dan pemesanan lebih lanjut.
    </div>

    <div class="footer">
        &copy; {{ date('Y') }} Extera Travel. All rights reserved.<br>
        {{ config('app.url') ?? '' }}
    </div>
</body>
</html>
