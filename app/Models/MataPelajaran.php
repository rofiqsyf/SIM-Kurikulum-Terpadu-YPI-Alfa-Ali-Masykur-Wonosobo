<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    protected $table = 'mata_pelajaran';
    protected $guarded = ['id'];

    public function kurikulum()
    {
        return $this->belongsTo(Kurikulum::class, 'kurikulum_id');
    }

    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'mapel_kelas', 'mapel_id', 'kelas_id');
    }

    public function penugasan()
    {
        return $this->hasMany(PenugasanGuru::class, 'mapel_id');
    }

    public function penugasanGuru()
    {
        return $this->hasMany(PenugasanGuru::class, 'mapel_id');
    }

    public function guru()
    {
        return $this->belongsToMany(User::class, 'penugasan_guru', 'mapel_id', 'pengguna_id');
    }

    public function capaianPembelajaran()
    {
        return $this->hasMany(CapaianPembelajaran::class, 'mapel_id');
    }

    public function tujuanPembelajaran()
    {
        return $this->hasManyThrough(TujuanPembelajaran::class, CapaianPembelajaran::class, 'mapel_id', 'cp_id');
    }

    public function usulanPerubahan()
    {
        return $this->hasMany(UsulanPerubahan::class, 'mapel_id');
    }
}

