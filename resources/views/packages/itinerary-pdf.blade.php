<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Itinerary {{ $package->title }}</title>
    <style>
        @page {
            margin: 52mm 15mm 30mm 15mm;
        }
        body {
            font-family: "DejaVu Sans", sans-serif;
            font-size: 11px;
            color: #1a1a1a;
            line-height: 1.5;
        }

        /* Header — fixed on every page */
        #header {
            position: fixed;
            top: -48mm;
            left: 0;
            right: 0;
            text-align: center;
            padding: 6mm 15mm;
            border-bottom: 2px solid #c99a1e;
        }
        #header h1 { font-size: 16px; color: #c99a1e; margin: 0; }
        #header p { font-size: 9px; color: #666; margin: 2px 0 0; }

        /* Footer — fixed on every page */
        #footer {
            position: fixed;
            bottom: -24mm;
            left: 0;
            right: 0;
            text-align: center;
            padding: 4mm 15mm;
            font-size: 8px;
            color: #999;
            border-top: 1px solid #ddd;
        }
        #footer .page:after { content: counter(page); }

        .cover {
            text-align: center;
            padding: 30mm 0 20mm;
        }
        .cover h2 { font-size: 22px; color: #c99a1e; margin: 0 0 6px; }
        .cover .meta { font-size: 12px; color: #555; margin: 4px 0; }
        .cover .price { font-size: 14px; color: #1d4ed8; font-weight: bold; margin-top: 10px; }

        h3.section-title {
            font-size: 13px;
            color: #1a1a1a;
            border-bottom: 1px solid #ddd;
            padding-bottom: 4px;
            margin: 20px 0 10px;
        }

        ul.list { margin: 4px 0 8px; padding-left: 16px; }
        ul.list li { margin-bottom: 3px; }

        .day-card {
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 8px 12px;
            margin-bottom: 8px;
            page-break-inside: avoid;
        }
        .day-card .day-title {
            font-weight: bold;
            font-size: 12px;
            color: #1d4ed8;
            margin-bottom: 4px;
        }
        .day-card .day-meta {
            font-size: 10px;
            color: #666;
            margin-bottom: 4px;
        }
        .day-card .day-desc {
            font-size: 11px;
            color: #333;
        }
        .price-table {
            width: 100%;
            border-collapse: collapse;
            margin: 8px 0;
            font-size: 11px;
        }
        .price-table th {
            background: #1e3a5f;
            color: #fff;
            padding: 6px 10px;
            text-align: left;
        }
        .price-table td {
            padding: 5px 10px;
            border-bottom: 1px solid #e5e7eb;
        }
        .price-table td.right { text-align: right; }
    </style>
</head>
<body>

<div id="header">
    <h1>EXTERA TRAVEL</h1>
    <p>Itinerary Perjalanan &mdash; {{ $package->title }}</p>
</div>

<div id="footer">
    Extera Travel &mdash; Halaman <span class="page"></span>
</div>

{{-- Cover --}}
<div class="cover">
    <h2>{{ $package->title }}</h2>
    @if($package->category)
        <p class="meta">{{ $package->category->name }}</p>
    @endif
    <p class="meta">{{ \Carbon\Carbon::parse($package->date)->locale("id")->isoFormat("DD MMMM YYYY") }}</p>
    <p class="meta">{{ $package->total_days }} hari &mdash; {{ $package->flight_by ?? "-" }}</p>
    @php($cheapest = $package->cheapestPrice())
    @if($cheapest)
        <p class="price">{{ $cheapest->currency === "IDR" ? "Rp" : $cheapest->currency }} {{ number_format($cheapest->price, 0, ",", ".") }} /orang</p>
    @endif
</div>

{{-- Itinerary --}}
@if($package->itineraries->isNotEmpty())
    <h3 class="section-title">Itinerary Perjalanan</h3>
    @foreach($package->itineraries as $it)
        <div class="day-card">
            <div class="day-title">{{ $it->marker }}: {{ $it->title }}</div>
            @if($it->accommodation_place || $it->meals)
                <div class="day-meta">
                    {{ $it->accommodation_place ?? "" }}{{ $it->accommodation_days ? " ({$it->accommodation_days} malam)" : "" }}
                    {{ $it->accommodation_place && $it->meals ? " | " : "" }}
                    {{ $it->meals ?? "" }}
                </div>
            @endif
            <div class="day-desc">{!! nl2br(e($it->itinerary)) !!}</div>
        </div>
    @endforeach
@endif

{{-- Prices --}}
@if($package->prices->isNotEmpty())
    <h3 class="section-title">Harga Paket</h3>
    <table class="price-table">
        <tr><th>Tipe</th><th class="right">Harga</th></tr>
        @foreach($package->prices as $p)
            <tr>
                <td>{{ $p->price_type }}</td>
                <td class="right">{{ $p->currency === "IDR" ? "Rp" : ($p->currency === "USD" ? "$" : $p->currency) }} {{ number_format($p->price, 0, ",", ".") }}</td>
            </tr>
        @endforeach
    </table>
@endif

{{-- Inclusions --}}
@if($package->inclusions)
    <h3 class="section-title">Termasuk</h3>
    <ul class="list">
        @foreach(explode("\n", $package->inclusions) as $line)
            @if(trim($line))
                <li>{{ trim($line) }}</li>
            @endif
        @endforeach
    </ul>
@endif

{{-- Exclusions --}}
@if($package->exclusions)
    <h3 class="section-title">Tidak Termasuk</h3>
    <ul class="list">
        @foreach(explode("\n", $package->exclusions) as $line)
            @if(trim($line))
                <li>{{ trim($line) }}</li>
            @endif
        @endforeach
    </ul>
@endif

{{-- Requirements --}}
@if($package->requirements)
    <h3 class="section-title">Persyaratan</h3>
    <ul class="list">
        @foreach(explode("\n", $package->requirements) as $line)
            @if(trim($line))
                <li>{{ trim($line) }}</li>
            @endif
        @endforeach
    </ul>
@endif

</body>
</html>