<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsulanPerubahan extends Model
{
    protected $table = 'usulan_perubahan';
    protected $guarded = ['id'];

    protected $casts = [
        'data_usulan' => 'array',
        'tanggal_pengajuan' => 'datetime',
        'tanggal_keputusan' => 'datetime',
    ];

    public function pengusul()
    {
        return $this->belongsTo(User::class, 'pengusul_id');
    }

    public function peninjau()
    {
        return $this->belongsTo(User::class, 'peninjau_id');
    }

    public function unit()
    {
        return $this->belongsTo(UnitPendidikan::class, 'unit_id');
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'mapel_id');
    }
}

