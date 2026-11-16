<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EkstrakurikulerPresensi extends Model
{
    protected $table = 'ekstrakurikuler_presensi';
    protected $guarded = ['id'];

    public function jadwal()
    {
        return $this->belongsTo(EkstrakurikulerJadwal::class, 'jadwal_id');
    }

    public function anggota()
    {
        return $this->belongsTo(EkstrakurikulerAnggota::class, 'anggota_id');
    }
}
