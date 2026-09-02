<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Yudisium extends Model
{
    /**
     * Nama tabel database
     */
    protected $table = 'yudisiums';

    protected $fillable = [
        'user_id',
        'angkatan',
        'no_urut',
        
        'link_foto',
        'validasi_foto',

        'link_pembayaran_alumni',
        'validasi_pembayaran_alumni',

        'link_bebas_keuangan',
        'validasi_bebas_keuangan',

        'link_pembayaran_yudisium',
        'validasi_pembayaran_yudisium',

        'link_artikel_loa',
        'validasi_artikel_loa',
        
        'catatan',
    ];

    /**
     * Relasi ke User/Mahasiswa
     */
    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'username'
        );
    }
}