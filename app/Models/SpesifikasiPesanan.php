<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpesifikasiPesanan extends Model
{
    protected $table = 'spesifikasi_pesanan';

    protected $primaryKey = 'pesanan_id';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'pesanan_id',
        'model_cuttingan',
        'lengan',
        'status_desain',
        'catatan_desain',
        'bahan',
        'warna',
        'pakai_lanyard',
        'pakai_id_card',
        'model_saku',
        'pakai_sablon',
        'pakai_bordir',
        'ket_bordir_sablon',
        'tambahan',
        'variasi_lain',
    ];

    protected $casts = [
        'pakai_lanyard' => 'boolean',
        'pakai_id_card' => 'boolean',
        'pakai_sablon' => 'boolean',
        'pakai_bordir' => 'boolean',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id');
    }
}
