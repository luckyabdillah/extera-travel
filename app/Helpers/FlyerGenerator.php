<?php

namespace App\Helpers;

use App\Models\Package;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class FlyerGenerator
{
    // Kanvas landscape sedang — pas buat thumbnail card di listing paket (rasio 8:5)
    private const WIDTH = 1200;
    private const HEIGHT = 750;

    public static function generate(Package $package): string
    {
        $img = imagecreatetruecolor(self::WIDTH, self::HEIGHT);
        imagealphablending($img, true);

        // ---------------------------------------------------------------
        // Palet brand (samain dengan landing page: hijau, gold, ink, putih)
        // ---------------------------------------------------------------
        $gold = imagecolorallocate($img, 224, 165, 46);
        $goldSoft = imagecolorallocate($img, 237, 193, 88);
        $white = imagecolorallocate($img, 255, 255, 255);
        $offWhite = imagecolorallocate($img, 226, 226, 226);
        $muted = imagecolorallocate($img, 163, 163, 165);
        $inkDark = imagecolorallocate($img, 5, 5, 5);

        // ---------------------------------------------------------------
        // Font — download & taruh 3 file ini di resources/fonts/
        // (Reem Kufi & Plus Jakarta Sans, sama seperti landing page)
        // ---------------------------------------------------------------
        $fontDisplay = self::fontPath('ReemKufi-Bold.ttf');
        $fontBold = self::fontPath('PlusJakartaSans-Bold.ttf');
        $fontRegular = self::fontPath('PlusJakartaSans-Regular.ttf');

        // ---------------------------------------------------------------
        // 1. Background: foto cover kategori paket (cover-fit), fallback gradient
        // ---------------------------------------------------------------
        // Sesuaikan nama relasi ini kalau di model Package bukan `category`
        $coverPath = optional($package->category)->image_cover;
        $drawn = false;

        if ($coverPath && Storage::disk('public')->exists($coverPath)) {
            $drawn = self::drawCoverImage($img, Storage::disk('public')->path($coverPath), self::WIDTH, self::HEIGHT);
        }

        if (!$drawn) {
            self::drawFallbackBackground($img, self::WIDTH, self::HEIGHT);
        }

        // Wash gelap tipis merata biar teks & badge tetap kebaca di atas foto apa pun
        $wash = imagecolorallocatealpha($img, 5, 5, 5, 60);
        imagefilledrectangle($img, 0, 0, self::WIDTH, self::HEIGHT, $wash);

        // Aksen arch (mihrab) samar sebagai watermark dekoratif — ciri khas brand
        $archColor = imagecolorallocatealpha($img, 224, 165, 46, 105);
        self::drawArchOutline($img, 90, self::HEIGHT - 40, 240, 300, $archColor, 3);

        // Garis aksen emas di tepi atas & bawah kanvas
        imagefilledrectangle($img, 0, 0, self::WIDTH, 5, $gold);
        imagefilledrectangle($img, 0, self::HEIGHT - 3, self::WIDTH, self::HEIGHT, $gold);

        // ---------------------------------------------------------------
        // 2. Brand lockup, kiri atas (di atas foto, dengan panel kaca)
        // ---------------------------------------------------------------
        $pillBg = imagecolorallocatealpha($img, 5, 5, 5, 35);
        self::fillRoundedRect($img, 36, 28, 300, 76, 14, $pillBg);

        imagefilledellipse($img, 62, 52, 30, 30, $gold);
        self::drawArchOutline($img, 62, 66, 22, 26, $inkDark, 2);
        imagettftext($img, 15, 0, 86, 47, $white, $fontBold, 'EXTERA TRAVEL');
        imagettftext($img, 9, 0, 86, 63, $muted, $fontRegular, 'U M R A H   &   H A J I');

        // Tagline kanan bawah foto
        $tagline = 'U M R A H   •   H A J I   •   W I S A T A   R E L I G I';
        $box = imagettfbbox(9, 0, $fontRegular, $tagline);
        $taglineW = $box[2] - $box[0];
        self::fillRoundedRect($img, 30, self::HEIGHT - 66, 30 + $taglineW + 28, self::HEIGHT - 30, 12, $pillBg);
        imagettftext($img, 9, 0, 44, self::HEIGHT - 45, $goldSoft, $fontRegular, $tagline);

        // ---------------------------------------------------------------
        // 3. Kartu info kaca, kanan — semua detail paket ada di sini
        // ---------------------------------------------------------------
        $cardX1 = 706;
        $cardX2 = self::WIDTH - 40;
        $cardY1 = 40;
        $cardY2 = self::HEIGHT - 40;
        $padding = 34;
        $radius = 26;

        $cardBg = imagecolorallocatealpha($img, 8, 8, 8, 22);
        self::fillRoundedRect($img, $cardX1, $cardY1, $cardX2, $cardY2, $radius, $cardBg);
        self::strokeRoundedRect($img, $cardX1, $cardY1, $cardX2, $cardY2, $radius, $gold, 2);

        $innerX1 = $cardX1 + $padding;
        $innerX2 = $cardX2 - $padding;
        $innerWidth = $innerX2 - $innerX1;
        $cursorY = $cardY1 + $padding;

        // Badge kategori
        $categoryLabel = mb_strtoupper(optional($package->category)->name ?? 'Paket Umrah');
        $labelBox = imagettfbbox(10, 0, $fontBold, $categoryLabel);
        $labelW = $labelBox[2] - $labelBox[0];
        $pillH = 30;
        self::fillRoundedRect($img, $innerX1, $cursorY, $innerX1 + $labelW + 28, $cursorY + $pillH, $pillH / 2, $gold);
        imagettftext($img, 10, 0, $innerX1 + 14, $cursorY + 20, $inkDark, $fontBold, $categoryLabel);
        $cursorY += $pillH + 22;

        // Judul paket (auto-shrink kalau kepanjangan biar tetap muat 3 baris)
        $titleSize = 32;
        do {
            $titleLines = self::wrapText($fontDisplay, $titleSize, $package->title, $innerWidth);
            if (count($titleLines) <= 3) {
                break;
            }
            $titleSize -= 2;
        } while ($titleSize > 20);

        foreach ($titleLines as $line) {
            imagettftext($img, $titleSize, 0, $innerX1, $cursorY + $titleSize, $white, $fontDisplay, $line);
            $cursorY += (int) ($titleSize * 1.25);
        }
        $cursorY += 12;

        imageline($img, $innerX1, $cursorY, $innerX2, $cursorY, $gold);
        $cursorY += 26;

        // Grid info 2x2, pakai bullet diamond kecil (motif yang sama dengan landing page)
        $tanggal = \Carbon\Carbon::parse($package->date)->locale('id')->isoFormat('DD MMMM YYYY');
        $kuota = $package->quota > 0 ? $package->quota . ' orang' : 'Hubungi kami';

        $infoItems = [
            ['Keberangkatan', $tanggal],
            ['Durasi', $package->total_days . ' hari'],
            ['Maskapai', $package->flight_by ?? '-'],
            ['Kuota', $kuota],
        ];

        $colWidth = (int) (($innerWidth - 24) / 2);
        $rowHeight = 52;
        foreach ($infoItems as $i => [$label, $value]) {
            $col = $i % 2;
            $row = intdiv($i, 2);
            $x = $innerX1 + $col * ($colWidth + 24);
            $y = $cursorY + $row * $rowHeight;

            self::drawDiamond($img, $x + 4, $y - 4, 7, $gold);
            imagettftext($img, 9, 0, $x + 16, $y, $muted, $fontRegular, mb_strtoupper($label));
            imagettftext($img, 13, 0, $x + 16, $y + 20, $offWhite, $fontBold, self::truncate($value, $fontBold, 13, $colWidth - 20));
        }
        $cursorY += ($rowHeight * 2) + 8;

        imageline($img, $innerX1, $cursorY, $innerX2, $cursorY, $gold);
        $cursorY += 30;

        // Harga
        $cheapest = method_exists($package, 'cheapestPrice') ? $package->cheapestPrice() : null;

        imagettftext($img, 11, 0, $innerX1, $cursorY, $muted, $fontRegular, 'MULAI DARI');
        $cursorY += 30;

        if ($cheapest) {
            $currencyLabel = $cheapest->currency === 'IDR' ? 'Rp' : $cheapest->currency . ' ';
            $priceText = $currencyLabel . number_format((float) $cheapest->price, 0, ',', '.');

            imagettftext($img, 30, 0, $innerX1, $cursorY, $gold, $fontDisplay, $priceText);
            $cursorY += 26;
            imagettftext($img, 11, 0, $innerX1, $cursorY, $muted, $fontRegular, '/ orang · ' . mb_strtoupper($cheapest->price_type ?? ''));
        } else {
            imagettftext($img, 18, 0, $innerX1, $cursorY, $gold, $fontBold, 'Hubungi kami');
        }

        // ---------------------------------------------------------------
        // 4. Footer strip, penuh lebar bawah
        // ---------------------------------------------------------------
        // Garis emas tipis di tepi bawah kanvas sudah cukup jadi pemisah, tinggal teks kontak
        imagettftext($img, 9, 0, 40, self::HEIGHT - 12, $muted, $fontRegular, 'travel-extera.com');
        $phone = '+62 812-8389-0098';
        $phoneBox = imagettfbbox(9, 0, $fontRegular, $phone);
        $phoneW = $phoneBox[2] - $phoneBox[0];
        imagettftext($img, 9, 0, self::WIDTH - 40 - $phoneW, self::HEIGHT - 12, $muted, $fontRegular, $phone);

        // ---------------------------------------------------------------
        // Simpan
        // ---------------------------------------------------------------
        $fileName = 'flyer-' . $package->uuid . '.png';
        $tempPath = sys_get_temp_dir() . '/' . $fileName;
        imagepng($img, $tempPath, 6);
        imagedestroy($img);

        $storedPath = Storage::disk('public')->putFileAs('packages', new File($tempPath), $fileName);
        @unlink($tempPath);

        return $storedPath;
    }

    /**
     * Cari file font di resources/fonts. Lempar exception yang jelas
     * kalau font belum di-download, daripada gagal diam-diam di imagettftext.
     */
    private static function fontPath(string $filename): string
    {
        $path = resource_path('fonts/' . $filename);

        if (!is_file($path)) {
            throw new \RuntimeException(
                "Font '{$filename}' tidak ditemukan di resources/fonts. ".
                'Download Reem Kufi & Plus Jakarta Sans dari Google Fonts lalu taruh di sana.'
            );
        }

        return $path;
    }

    /**
     * Gambar foto ke kanvas dengan crop "cover" (mengisi penuh, tidak gepeng),
     * mirip object-fit: cover di CSS. Return false kalau file tidak bisa dibaca.
     */
    private static function drawCoverImage($canvas, string $srcPath, int $canvasW, int $canvasH): bool
    {
        $info = @getimagesize($srcPath);
        if (!$info) {
            return false;
        }

        $src = match ($info[2]) {
            IMAGETYPE_JPEG => @imagecreatefromjpeg($srcPath),
            IMAGETYPE_PNG => @imagecreatefrompng($srcPath),
            IMAGETYPE_WEBP => @imagecreatefromwebp($srcPath),
            default => null,
        };

        if (!$src) {
            return false;
        }

        $srcW = imagesx($src);
        $srcH = imagesy($src);
        $srcRatio = $srcW / $srcH;
        $dstRatio = $canvasW / $canvasH;

        if ($srcRatio > $dstRatio) {
            $cropH = $srcH;
            $cropW = (int) ($srcH * $dstRatio);
            $srcX = (int) (($srcW - $cropW) / 2);
            $srcY = 0;
        } else {
            $cropW = $srcW;
            $cropH = (int) ($srcW / $dstRatio);
            $srcX = 0;
            $srcY = (int) (($srcH - $cropH) / 2);
        }

        imagecopyresampled($canvas, $src, 0, 0, $srcX, $srcY, $canvasW, $canvasH, $cropW, $cropH);
        imagedestroy($src);

        return true;
    }

    /**
     * Gradient vertikal hijau tua -> hitam, dipakai kalau paket belum
     * punya foto cover kategori.
     */
    private static function drawFallbackBackground($canvas, int $w, int $h): void
    {
        $top = [16, 36, 22];   // primary-900
        $bottom = [5, 5, 5];   // ink-950

        for ($y = 0; $y < $h; $y++) {
            $ratio = $y / $h;
            $r = (int) ($top[0] + ($bottom[0] - $top[0]) * $ratio);
            $g = (int) ($top[1] + ($bottom[1] - $top[1]) * $ratio);
            $b = (int) ($top[2] + ($bottom[2] - $top[2]) * $ratio);
            $color = imagecolorallocate($canvas, $r, $g, $b);
            imageline($canvas, 0, $y, $w, $y, $color);
        }
    }

    /** Rectangle dengan sudut membulat (rounded card, badge, pill). */
    private static function fillRoundedRect($img, int $x1, int $y1, int $x2, int $y2, int $radius, $color): void
    {
        imagefilledrectangle($img, $x1 + $radius, $y1, $x2 - $radius, $y2, $color);
        imagefilledrectangle($img, $x1, $y1 + $radius, $x2, $y2 - $radius, $color);
        imagefilledellipse($img, $x1 + $radius, $y1 + $radius, $radius * 2, $radius * 2, $color);
        imagefilledellipse($img, $x2 - $radius, $y1 + $radius, $radius * 2, $radius * 2, $color);
        imagefilledellipse($img, $x1 + $radius, $y2 - $radius, $radius * 2, $radius * 2, $color);
        imagefilledellipse($img, $x2 - $radius, $y2 - $radius, $radius * 2, $radius * 2, $color);
    }

    /** Outline (stroke saja) dari rounded rect di atas, buat border kartu. */
    private static function strokeRoundedRect($img, int $x1, int $y1, int $x2, int $y2, int $radius, $color, int $thickness = 2): void
    {
        imagesetthickness($img, $thickness);
        imageline($img, $x1 + $radius, $y1, $x2 - $radius, $y1, $color);
        imageline($img, $x1 + $radius, $y2, $x2 - $radius, $y2, $color);
        imageline($img, $x1, $y1 + $radius, $x1, $y2 - $radius, $color);
        imageline($img, $x2, $y1 + $radius, $x2, $y2 - $radius, $color);
        imagearc($img, $x1 + $radius, $y1 + $radius, $radius * 2, $radius * 2, 180, 270, $color);
        imagearc($img, $x2 - $radius, $y1 + $radius, $radius * 2, $radius * 2, 270, 360, $color);
        imagearc($img, $x1 + $radius, $y2 - $radius, $radius * 2, $radius * 2, 90, 180, $color);
        imagearc($img, $x2 - $radius, $y2 - $radius, $radius * 2, $radius * 2, 0, 90, $color);
        imagesetthickness($img, 1);
    }

    /** Bullet diamond kecil, motif yang sama dipakai di landing page. */
    private static function drawDiamond($img, int $cx, int $cy, int $size, $color): void
    {
        $points = [
            $cx, $cy - $size,
            $cx + $size, $cy,
            $cx, $cy + $size,
            $cx - $size, $cy,
        ];
        imagefilledpolygon($img, $points, 4, $color);
    }

    /**
     * Outline lengkung ala mihrab (dua garis vertikal + busur setengah lingkaran
     * di atas) — elemen dekoratif ciri khas brand, dipakai berulang sebagai watermark
     * maupun logo mark.
     */
    private static function drawArchOutline($img, int $cx, int $baseY, int $width, int $height, $color, int $thickness = 2): void
    {
        $radius = (int) ($width / 2);
        $archTopY = $baseY - $height + $radius;

        imagesetthickness($img, $thickness);
        imageline($img, $cx - $radius, $baseY, $cx - $radius, $archTopY, $color);
        imageline($img, $cx + $radius, $baseY, $cx + $radius, $archTopY, $color);
        imagearc($img, $cx, $archTopY, $radius * 2, $radius * 2, 180, 360, $color);
        imagesetthickness($img, 1);
    }

    private static function wrapText($font, $size, $text, $maxWidth): array
    {
        $words = explode(' ', $text);
        $lines = [];
        $currentLine = '';

        foreach ($words as $word) {
            $testLine = $currentLine ? $currentLine . ' ' . $word : $word;
            $box = imagettfbbox($size, 0, $font, $testLine);
            $width = $box[2] - $box[0];

            if ($width > $maxWidth && $currentLine) {
                $lines[] = $currentLine;
                $currentLine = $word;
            } else {
                $currentLine = $testLine;
            }
        }

        if ($currentLine) {
            $lines[] = $currentLine;
        }

        return $lines;
    }

    /** Potong teks pendek (mis. nama maskapai) kalau kepanjangan buat 1 baris di grid info. */
    private static function truncate(string $text, $font, int $size, int $maxWidth): string
    {
        $box = imagettfbbox($size, 0, $font, $text);
        if (($box[2] - $box[0]) <= $maxWidth) {
            return $text;
        }

        $ellipsis = '…';
        while (mb_strlen($text) > 1) {
            $text = mb_substr($text, 0, -1);
            $box = imagettfbbox($size, 0, $font, $text . $ellipsis);
            if (($box[2] - $box[0]) <= $maxWidth) {
                return $text . $ellipsis;
            }
        }

        return $text;
    }
}