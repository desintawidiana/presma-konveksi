<?php

namespace App\Support;

/**
 * Meniru fungsi MySQL `normalisasi_hp()` di database.
 * 0812xxx / 812xxx / +62 812xxx  ->  62812xxx
 *
 * Trigger pelanggan_sebelum_insert/update di DB juga melakukan ini,
 * tetapi Laravel perlu menormalkan LEBIH DULU supaya validasi `unique`
 * dan pencarian pelanggan membandingkan format yang sama.
 */
class NomorWhatsapp
{
    public const POLA = '/^62[0-9]{8,13}$/';

    public static function normalisasi(?string $nomor): string
    {
        $d = preg_replace('/[\s\-+().]/', '', $nomor ?? '');

        if (str_starts_with($d, '0')) {
            return '62' . substr($d, 1);
        }

        if (str_starts_with($d, '8')) {
            return '62' . $d;
        }

        return $d;
    }
}
