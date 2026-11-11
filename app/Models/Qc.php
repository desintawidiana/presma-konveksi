<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Qc extends Model
{
    protected $table = 'qc';

    public $timestamps = false;

    protected $fillable = [
        'work_order_id',
        'hasil',
        'catatan',
        'kembali_ke_tahap',
        'dicatat_oleh',
    ];

    protected $casts = [
        'tanggal' => 'datetime',
    ];
}
