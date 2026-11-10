<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
        'deadline' => 'date:Y-m-d',
        'dibuat_pada' => 'datetime',
        'diubah_pada' => 'datetime',
        'selesai_pada' => 'datetime',
    ];

    // Ikut tampil di JSON: kode order seperti "12_7890" (id + 4 digit HP).
    protected $appends = ['kode_order'];

    protected static function booted(): void
    {
        // Kode tracking harus ACAK (32 karakter) agar tidak bisa ditebak.
        // Trigger DB hanya cadangan; di Laravel pakai CSPRNG milik Str::random.
        static::creating(function (Pesanan $pesanan) {
            if (empty($pesanan->kode_tracking)) {
                $pesanan->kode_tracking = Str::random(32);
            }
        });
    }

    public function getKodeOrderAttribute(): ?string
    {
        return $this->id && $this->hp_4_digit
            ? $this->id . '_' . $this->hp_4_digit
            : null;
    }

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

    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'pesanan_id');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'pesanan_id');
    }

    public function workOrder()
    {
        return $this->hasOne(WorkOrder::class, 'pesanan_id');
    }
}
