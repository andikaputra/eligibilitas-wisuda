<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wisuda extends Model
{
    protected $fillable = [
        'user_id',
        'no_urut',

        // Link persyaratan Wisuda
        'link_repositori',
        'link_tracer_study',
        'link_pembayaran_wisuda',
        'link_bukti_perpus',

        // Validasi Wisuda
        'validasi_repositori',
        'validasi_tracer_study',
        'validasi_pembayaran_wisuda',
        'validasi_bebas_perpus_wisuda',
    ];

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'username'
        );
    }
}