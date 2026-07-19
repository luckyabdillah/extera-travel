<x-mail::message>
# Assalamu'alaikum, {{ $data['name'] }}

Terima kasih telah mengirimkan permintaan **Paket Kustom** kepada **Extera Travel**.

Berikut ringkasan permintaan Anda:

<x-mail::table>
| Detail | Informasi |
| :--- | :--- |
| Nama | {{ $data['name'] }} |
| Email | {{ $data['email'] }} |
| Telepon | {{ $data['phone'] }} |
| Jumlah Jamaah | {{ $data['total_pax'] }} |
| Keberangkatan | {{ $data['departure_month'] ?: '-' }} |
| Destinasi | {{ $data['destination_label'] ?: '-' }} |
| Durasi | {{ $data['duration_label'] ?: '-' }} |
| Budget | {{ $data['budget_label'] ?: '-' }} |
</x-mail::table>

@if($data['notes'])
**Catatan Tambahan:**
{{ $data['notes'] }}
@endif

Tim kami akan segera menghubungi Anda melalui email **{{ $data['email'] }}** atau nomor **{{ $data['phone'] }}** dalam 1x24 jam untuk mendiskusikan paket yang sesuai dengan kebutuhan Anda.

Apabila terdapat pertanyaan sebelum kami menghubungi Anda, jangan ragu untuk menghubungi tim kami.

Semoga Allah SWT memudahkan setiap langkah menuju ibadah yang penuh keberkahan.

Wassalamu'alaikum warahmatullahi wabarakatuh.

Salam hangat,<br>
**Tim Extera Travel**
</x-mail::message>
