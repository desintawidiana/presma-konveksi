<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggan';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'nama',
        'no_whatsapp',
        'instansi',
        'sumber_informasi',
    ];

    /**
     * Mengisi kolom turunan sebelum data disimpan.
     */
    protected static function booted(): void
    {
        static::saving(function (Pelanggan $pelanggan) {
            if ($pelanggan->isDirty('no_whatsapp')) {
                $nomor = preg_replace(
                    '/\D+/',
                    '',
                    $pelanggan->no_whatsapp ?? ''
                );

                $pelanggan->hp_4_digit = substr($nomor, -4);
            }
        });

        static::creating(function (Pelanggan $pelanggan) {
            if (empty($pelanggan->dibuat_pada)) {
                $pelanggan->dibuat_pada = now();
            }
        });
    }
}
