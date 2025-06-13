<?php

use App\Models\Pengaturan;

// if (! function_exists('activeUser')) {
//     function activeUser()
//     {
//         foreach (['guru', 'siswa', 'orangtua', 'web', 'admin'] as $guard) {
//             if (auth($guard)->check()) {
//                 return auth($guard)->user();
//             }
//         }

//         return null;
//     }
// }

if (! function_exists('activeGuard')) {
    function activeGuard(): ?string
    {
        foreach (['ibu', 'admin'] as $guard) {
            if (auth($guard)->check()) {
                return $guard;
            }
        }

        return null;
    }
}


if (! function_exists('getPengaturan')) {
    function getPengaturan(): ?Pengaturan
    {
        return Pengaturan::where('id', 1)->first();
    }
}

if (! function_exists('randomColorHex')) {
    function randomColorHex(): string
    {
        return sprintf('%06X', mt_rand(0, 0xFFFFFF));
    }
}

if (! function_exists('getUiAvatar')) {
    function getUiAvatar($nama): string
    {
        $kata = explode(' ', trim($nama));

        if (count($kata) >= 2) {
            $namaUntukUrl = $kata[0] . '+' . $kata[1];
        } else {
            $namaUntukUrl = $kata[0] ?? '';
        }

        $url = 'https://ui-avatars.com/api/?background=' . randomColorHex() . '&color=fff&name=' . $namaUntukUrl;
        return $url;
    }
}

if (! function_exists('format_rp')) {
    /**
     * Format angka menjadi mata uang Rupiah (Rp)
     *
     * @param int|float $amount
     * @param int $decimal
     * @return string
     */
    function format_rp($amount, $decimal = 0)
    {
        return 'Rp. ' . number_format($amount, $decimal, ',', '.');
    }
}

if (! function_exists('format_berat')) {
    /**
     * Format berat (gram) ke "gram" atau "kg"
     *
     * @param int $beratDalamGram
     * @return string
     */
    function format_berat($beratDalamGram)
    {
        if ($beratDalamGram >= 1000) {
            $beratDalamKg = $beratDalamGram / 1000;
            // Jika hasil kg tanpa desimal (misal: 2000 gram -> 2 kg)
            return $beratDalamKg == (int) $beratDalamKg
            ? $beratDalamKg . ' kg'
            : number_format($beratDalamKg, 2) . ' kg'; // 2 angka desimal
        }
        return $beratDalamGram . ' gram';
    }
}

if (! function_exists('format_tanggal')) {
    /**
     * Format timestamp ke format tanggal Indonesia
     *
     * @param  string|\Carbon\Carbon $timestamp
     * @param  bool $withDayName
     * @return string
     */
    function format_tanggal($timestamp, $withDayName = false)
    {
        if (empty($timestamp)) {
            return '-';
        }

        $date = \Carbon\Carbon::parse($timestamp);

        if ($withDayName) {
            return $date->translatedFormat('l, j F Y'); // Contoh: Senin, 12 Mei 2023
        }

        return $date->translatedFormat('j F Y'); // Contoh: 12 Mei 2023
    }
}

if (! function_exists('percentage')) {
    function percentage($value, $decimals = 0)
    {
        return number_format($value * 100, $decimals);
    }
}
