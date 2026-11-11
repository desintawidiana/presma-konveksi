<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    protected $table = 'work_order';

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diubah_pada';

    // nomor_wo adalah kolom GENERATED ("WO-<pesanan_id>"): jangan diisi.
    protected $fillable = [
        'pesanan_id',
        'tanggal_wo',
        'catatan_produksi',
        'status_wo',
        'dibuat_oleh',
    ];

    protected $casts = [
        'tanggal_wo' => 'date:Y-m-d',
        'dibuat_pada' => 'datetime',
        'diubah_pada' => 'datetime',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id');
    }
}
