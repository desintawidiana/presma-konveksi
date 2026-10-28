<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan';

    protected $primaryKey = 'id';

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diubah_pada';

    protected $fillable = [
        'pelanggan_id',
        'jenis_produk',
        'keterangan',
        'harga_satuan',
        'deadline',
        'status_order',
        'dibuat_dari',
        'catatan_internal',
    ];

    protected $casts = [
        'harga_satuan' => 'decimal:2',
        'deadline' => 'date',
        'dibuat_pada' => 'datetime',
        'diubah_pada' => 'datetime',
        'selesai_pada' => 'datetime',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }

    public function spesifikasi()
    {
        return $this->hasOne(SpesifikasiPesanan::class, 'pesanan_id');
    }

    public function ukuranPesanan()
    {
        return $this->hasMany(UkuranPesanan::class, 'pesanan_id');
    }
}
