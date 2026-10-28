<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UkuranPesanan extends Model
{
    protected $table = 'ukuran_pesanan';

    protected $primaryKey = 'pesanan_id';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'pesanan_id',
        'ukuran',
        'jumlah',
    ];

    protected $casts = [
        'pesanan_id' => 'integer',
        'jumlah' => 'integer',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id');
    }
}
