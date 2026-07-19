<x-mail::message>
# Permintaan Paket Kustom Baru

Seorang pengunjung baru saja mengirimkan permintaan paket kustom melalui website.

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

---

Segera hubungi customer melalui:
- Email: **{{ $data['email'] }}**
- Telepon: **{{ $data['phone'] }}**
</x-mail::message>
