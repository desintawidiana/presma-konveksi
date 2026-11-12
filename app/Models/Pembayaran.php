<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';

    public $timestamps = false;

    // invoice_id diisi otomatis oleh trigger pembayaran_sebelum_insert.
    protected $fillable = [
        'pesanan_id',
        'jenis',
        'jumlah',
        'tanggal_bayar',
        'metode',
        'keterangan',
        'dicatat_oleh',
    ];

    protected $casts = [
        'jumlah' => 'decimal:2',
        'tanggal_bayar' => 'date:Y-m-d',
        'dibuat_pada' => 'datetime',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id');
    }
}
