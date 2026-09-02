<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ijazah extends Model
{
    protected $fillable = [
        'user_id',
        'nama',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'nim',
        'prodi',
        'validasi_nama',
        'validasi_nik',
        'validasi_tempat_lahir',
        'validasi_tanggal_lahir',
        'validasi_nim',
        'validasi_prodi',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}