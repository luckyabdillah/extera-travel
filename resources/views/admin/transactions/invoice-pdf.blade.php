<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $transaction->invoice_no }}</title>
    <style>
        @page { margin: 30px; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; color: #1a1a1a; margin: 0; padding: 0; }
        .header { text-align: center; padding: 20px 0; border-bottom: 2px solid #f2c94c; }
        .header h1 { font-size: 22px; color: #c99a1e; margin: 0; }
        .header p { font-size: 11px; color: #666; margin: 2px 0 0; }
        .greeting { padding: 16px 0; }
        .greeting h2 { font-size: 16px; margin: 0 0 2px; }
        .greeting p { color: #666; font-size: 12px; margin: 0; }
        .info-box { background: #f8f6f0; border-radius: 8px; padding: 12px 16px; margin: 16px 0; }
        .info-box table { width: 100%; }
        .info-box td { padding: 3px 0; }
        .info-box .label { font-size: 10px; color: #999; }
        .info-box .value { font-size: 13px; font-weight: bold; }
        .info-box .total { font-size: 18px; font-weight: bold; color: #c99a1e; text-align: right; }
        table.items { width: 100%; border-collapse: collapse; margin: 16px 0; font-size: 11px; }
        table.items th { background: #1a1a1a; color: #fff; padding: 8px 10px; text-align: left; }
        table.items th.right { text-align: right; }
        table.items th.center { text-align: center; }
        table.items td { padding: 6px 10px; border-bottom: 1px solid #eee; }
        table.items td.right { text-align: right; }
        table.items td.center { text-align: center; }
        table.items tfoot td { border-bottom: none; font-weight: bold; padding-top: 10px; }
        table.items tfoot .grand-total { font-size: 14px; color: #c99a1e; }
        .footer { text-align: center; padding: 16px 0; font-size: 10px; color: #999; border-top: 1px solid #eee; margin-top: 24px; }
        .payment-note { background: #f8f6f0; border-radius: 8px; padding: 12px; font-size: 11px; color: #666; text-align: center; margin: 16px 0; }
    </style>
</head>
<body>
    <div class="header">
        <h1>EXTERA TRAVEL</h1>
        <p>Invoice Pemesanan Paket</p>
    </div>

    <div class="greeting">
        <h2>Terima Kasih, {{ $transaction->name }}!</h2>
        <p>Pemesanan kamu telah diterima dan sedang diproses.</p>
    </div>

    <div class="info-box">
        <table>
            <tr><td class="label">Invoice</td><td class="value" style="text-align:right;">#{{ $transaction->invoice_no }}</td></tr>
            <tr><td class="label">Tanggal</td><td class="value" style="text-align:right;">{{ $transaction->created_at->format('d M Y H:i') }}</td></tr>
            <tr><td class="label">Status</td><td style="text-align:right;"><span style="background:#f2c94c; color:#1a1a1a; font-size:10px; font-weight:bold; padding:1px 8px; border-radius:10px;">{{ ucfirst($transaction->status) }}</span></td></tr>
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

    <div class="payment-note">
        Silakan lakukan pembayaran sebelum <strong>{{ $transaction->expiration_time }} jam</strong> sejak invoice ini diterbitkan.<br>
        Jika ada pertanyaan, hubungi kami di <strong>+62 812-3456-7890</strong>
    </div>

    <div class="footer">
        &copy; {{ date('Y') }} Extera Travel. All rights reserved.<br>
        {{ config('app.url') ?? '' }}
    </div>
</body>
</html>
