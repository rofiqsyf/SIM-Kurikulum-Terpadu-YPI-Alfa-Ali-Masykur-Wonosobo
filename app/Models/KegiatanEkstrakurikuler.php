<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KegiatanEkstrakurikuler extends Model
{
    protected $table = 'kegiatan_ekstrakurikuler';
    protected $guarded = ['id'];

    public function unit()
    {
        return $this->belongsTo(UnitPendidikan::class, 'unit_id');
    }

    public function pembina()
    {
        return $this->belongsTo(User::class, 'pembina_id');
    }

    public function anggota()
    {
        return $this->hasMany(EkstrakurikulerAnggota::class, 'ekstrakurikuler_id');
    }

    public function jadwal()
    {
        return $this->hasMany(EkstrakurikulerJadwal::class, 'ekstrakurikuler_id')->orderBy('tanggal', 'desc');
    }
}

