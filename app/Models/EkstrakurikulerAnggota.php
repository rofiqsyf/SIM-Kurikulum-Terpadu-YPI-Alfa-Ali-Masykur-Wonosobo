<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EkstrakurikulerAnggota extends Model
{
    protected $table = 'ekstrakurikuler_anggota';
    protected $guarded = ['id'];

    public function ekstrakurikuler()
    {
        return $this->belongsTo(KegiatanEkstrakurikuler::class, 'ekstrakurikuler_id');
    }

    public function presensi()
    {
        return $this->hasMany(EkstrakurikulerPresensi::class, 'anggota_id');
    }

    /**
     * Hitung persentase kehadiran santri
     */
    public function getPersentaseKehadiranAttribute(): int
    {
        $totalSesi = $this->presensi()->count();
        if ($totalSesi === 0) return 100;

        $hadir = $this->presensi()->where('status_kehadiran', 'Hadir')->count();
        return (int) round(($hadir / $totalSesi) * 100);
    }
}
