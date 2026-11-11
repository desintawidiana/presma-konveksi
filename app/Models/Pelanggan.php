<?php

namespace App\Models;

use App\Support\NomorWhatsapp;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggan';

    protected $primaryKey = 'id';

    // Kolom dibuat_pada diisi default oleh database (CURRENT_TIMESTAMP).
    public $timestamps = false;

    // JANGAN masukkan hp_4_digit: kolom itu GENERATED di database
    // (right(no_whatsapp, 4)) sehingga tidak boleh diisi dari Laravel.
    protected $fillable = [
        'nama',
        'no_whatsapp',
        'instansi',
        'sumber_informasi',
    ];

    protected $casts = [
        'dibuat_pada' => 'datetime',
    ];

    /** Selalu simpan nomor dalam format 62xxxxxxxxxx. */
    protected function noWhatsapp(): Attribute
    {
        return Attribute::set(
            fn (?string $nilai) => NomorWhatsapp::normalisasi($nilai)
        );
    }

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'pelanggan_id');
    }
}
