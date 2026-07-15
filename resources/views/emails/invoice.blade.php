<!DOCTYPE html>
<html>
<head><meta charset="utf-8"></head>
<body style="font-family: 'Plus Jakarta Sans', sans-serif; margin:0; padding:0; background:#f5f5f5;">
	<table width="100%" cellpadding="0" cellspacing="0"><tr><td align="center" style="padding:40px 20px;">
		<table width="600" cellpadding="0" cellspacing="0" style="background:white; border-radius:24px; overflow:hidden;">
			<tr><td style="padding:40px; background:#050505; text-align:center;">
				<h1 style="font-family: 'Reem Kufi', sans-serif; color:#f2c94c; margin:0; font-size:24px;">EXTERA TRAVEL</h1>
				<p style="color:rgba(255,255,255,0.6); margin:4px 0 0; font-size:12px;">Invoice Pemesanan Umrah</p>
			</td></tr>
			<tr><td style="padding:32px;">
				<h2 style="font-family: 'Reem Kufi', sans-serif; font-size:20px; margin:0 0 4px;">Terima Kasih, {{ $transaction->name }}!</h2>
				<p style="color:#666; font-size:14px;">Pemesanan kamu telah diterima dan sedang diproses.</p>

				<table width="100%" cellpadding="0" cellspacing="0" style="margin:24px 0;">
					<tr><td style="padding:16px; background:#f8f6f0; border-radius:16px;">
						<table width="100%">
							<tr><td style="font-size:12px; color:#999;">Invoice</td><td style="text-align:right; font-size:14px; font-weight:bold;">#{{ $transaction->invoice_no }}</td></tr>
							<tr><td style="font-size:12px; color:#999;">Status</td><td style="text-align:right;"><span style="background:#f2c94c; color:#050505; font-size:11px; font-weight:bold; padding:2px 10px; border-radius:999px;">Pending</span></td></tr>
							<tr><td style="font-size:12px; color:#999;">Total Tagihan</td><td style="text-align:right; font-size:20px; font-weight:bold; color:#c99a1e;">Rp {{ number_format($transaction->total_bill, 0, ',', '.') }}</td></tr>
						</table>
					</td></tr>
				</table>

				<h3 style="font-size:14px; margin:0 0 12px;">Detail Pesanan</h3>
				<table width="100%" cellpadding="0" cellspacing="0" style="font-size:13px;">
					@foreach($transaction->details as $detail)
					<tr><td style="padding:6px 0; color:#333;">{{ $detail->description }}</td><td style="text-align:right; font-weight:bold;">Rp {{ number_format($detail->unit_price * $detail->qty, 0, ',', '.') }}</td></tr>
					@endforeach
				</table>

				<table width="100%" cellpadding="0" cellspacing="0" style="margin-top:24px; border-top:1px solid #e0dcd5; padding-top:16px;">
					<tr><td style="font-size:14px; font-weight:bold;">Total</td><td style="text-align:right; font-size:18px; font-weight:bold; color:#c99a1e;">Rp {{ number_format($transaction->total_bill, 0, ',', '.') }}</td></tr>
				</table>

				<p style="margin-top:24px; padding:16px; background:#f8f6f0; border-radius:12px; font-size:12px; color:#666; text-align:center;">
					Silakan lakukan pembayaran sebelum <strong>{{ $transaction->expiration_time }} jam</strong> sejak invoice ini diterbitkan.<br>
					Jika ada pertanyaan, hubungi kami di <strong>+62 812-3456-7890</strong>
				</p>
			</td></tr>
			<tr><td style="padding:20px; background:#050505; text-align:center; font-size:11px; color:rgba(255,255,255,0.4);">
				&copy; {{ date('Y') }} Extera Travel. All rights reserved.
			</td></tr>
		</table>
	</td></tr></table>
</body>
</html>