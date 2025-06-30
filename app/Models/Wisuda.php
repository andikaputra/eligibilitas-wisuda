<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wisuda extends Model
{
    protected $fillable = [
        'user_id',
        'link_bukti_pembayaran',
        'link_pasphoto',
        'link_repositori',
        'link_publish_jurnal',
        'link_bukti_skripsi',
        'link_bukti_perpus',
        'validasi_bendahara',
           'validasi_repo',
            'validasi_jurnal',
            'validasi_skripsi',
            'validasi_perpus', 
    ];



    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'username');
    }
}
