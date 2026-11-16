<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EkstrakurikulerJadwal extends Model
{
    protected $table = 'ekstrakurikuler_jadwal';
    protected $guarded = ['id'];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function ekstrakurikuler()
    {
        return $this->belongsTo(KegiatanEkstrakurikuler::class, 'ekstrakurikuler_id');
    }

    public function presensi()
    {
        return $this->hasMany(EkstrakurikulerPresensi::class, 'jadwal_id');
    }

    public function getHadirCountAttribute(): int
    {
        return $this->presensi()->where('status_kehadiran', 'Hadir')->count();
    }
}
