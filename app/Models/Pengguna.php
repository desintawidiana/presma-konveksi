<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'pengguna';

    protected $primaryKey = 'id';

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = null;

    protected $fillable = [
        'nama',
        'username',
        'kata_sandi_hash',
        'peran',
        'aktif',
    ];

    protected $hidden = [
        'kata_sandi_hash',
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'dibuat_pada' => 'datetime',
    ];

    public function getAuthPassword()
    {
        return $this->kata_sandi_hash;
    }
}
