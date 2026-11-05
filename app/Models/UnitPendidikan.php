<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnitPendidikan extends Model
{
    protected $table = 'unit_pendidikan';
    protected $guarded = ['id'];

    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class, 'jenjang_id');
    }

    public function pengguna()
    {
        return $this->hasMany(User::class, 'unit_id');
    }

    public function kurikulum()
    {
        return $this->hasMany(Kurikulum::class, 'unit_id');
    }

    public function kokurikuler()
    {
        return $this->hasMany(KegiatanKokurikuler::class, 'unit_id');
    }

    public function ekstrakurikuler()
    {
        return $this->hasMany(KegiatanEkstrakurikuler::class, 'unit_id');
    }

    public function usulanPerubahan()
    {
        return $this->hasMany(UsulanPerubahan::class, 'unit_id');
    }
}

