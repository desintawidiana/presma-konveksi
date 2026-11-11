<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoice';

    public $timestamps = false;

    // nomor_invoice & deskripsi_produk diisi otomatis oleh trigger
    // invoice_sebelum_insert, jadi tidak boleh diisi dari Laravel.
    protected $fillable = [
        'pesanan_id',
        'tanggal_invoice',
        'dibuat_oleh',
    ];

    protected $casts = [
        'tanggal_invoice' => 'date:Y-m-d',
        'dibuat_pada' => 'datetime',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id');
    }
}
